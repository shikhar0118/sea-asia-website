<?php
declare(strict_types=1);

$contentType = strtolower(trim(explode(';', (string) ($_SERVER['CONTENT_TYPE'] ?? ''))[0]));
$isJsonRequest = $contentType === 'application/json';

if ($isJsonRequest) {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
} else {
    session_start();
}

function respondWithJson(int $status, string $message): never
{
    http_response_code($status);
    echo json_encode(['ok' => $status >= 200 && $status < 300, 'message' => $message]);
    exit;
}

// Keep a short result message for the legacy PHP form.
function redirectWithStatus(string $type, string $message): never
{
    $_SESSION['contact_status'] = ['type' => $type, 'message' => $message];
    header('Location: ../contact.php', true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($isJsonRequest) {
        respondWithJson(405, 'Use the enquiry form to submit a request.');
    }
    header('Allow: POST');
    redirectWithStatus('error', 'Please submit the enquiry form.');
}

if ($isJsonRequest) {
    $submittedData = json_decode((string) file_get_contents('php://input'), true);
    if (!is_array($submittedData)) {
        respondWithJson(400, 'The enquiry could not be read. Please review the form and try again.');
    }
} else {
    $submittedData = $_POST;
}

// Honeypot: silently accept bot submissions without storing them.
if (!empty($submittedData['website'] ?? '')) {
    if ($isJsonRequest) {
        respondWithJson(201, 'Thank you. Your enquiry has been received.');
    }
    redirectWithStatus('success', 'Thank you. Your enquiry has been received.');
}

// Legacy PHP form requests still use their session token. Same-origin JSON
// requests from the static contact page use application/json and no session.
if (!$isJsonRequest) {
    $postedToken = (string) ($_POST['csrf_token'] ?? '');
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $postedToken)) {
        redirectWithStatus('error', 'Your form session expired. Please reload the page and try again.');
    }
}

$name = trim((string) ($submittedData['name'] ?? ''));
$company = trim((string) ($submittedData['company'] ?? ''));
$email = trim((string) ($submittedData['email'] ?? ''));
$phone = trim((string) ($submittedData['phone'] ?? ''));
$service = trim((string) ($submittedData['service'] ?? ''));
$message = trim((string) ($submittedData['message'] ?? ''));

if (
    $name === ''
    || mb_strlen($name) > 100
    || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || mb_strlen($email) > 190
    || $message === ''
    || mb_strlen($message) > 5000
    || mb_strlen($company) > 150
    || mb_strlen($phone) > 30
) {
    $error = 'Please check the required fields and their length, then submit again.';
    if ($isJsonRequest) {
        respondWithJson(422, $error);
    }
    redirectWithStatus('error', $error);
}

$allowedServices = [
    'Customs clearance',
    'Import / Export',
    'Air freight',
    'Ocean freight',
    'Road transportation',
    'Warehousing',
    'Project logistics',
    'Shipment documentation',
    'Other / not sure',
];

if ($service !== '' && !in_array($service, $allowedServices, true)) {
    $error = 'Please select a service from the list.';
    if ($isJsonRequest) {
        respondWithJson(422, $error);
    }
    redirectWithStatus('error', $error);
}

// Credentials belong in the hosting environment, never in committed source.
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$db = getenv('DB_NAME') ?: '';
$user = getenv('DB_USER') ?: '';
$pass = getenv('DB_PASSWORD') ?: '';

if ($db === '' || $user === '') {
    error_log('Sea Asia contact form: database environment is not configured.');
    $error = 'Enquiry saving is not configured yet. Please contact us by phone or email.';
    if ($isJsonRequest) {
        respondWithJson(503, $error);
    }
    redirectWithStatus('error', $error);
}

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $stmt = $pdo->prepare(
        'INSERT INTO contact_enquiries (name, company, email, phone, service, message) '
        . 'VALUES (:name, :company, :email, :phone, :service, :message)'
    );
    $stmt->execute([
        'name' => $name,
        'company' => $company ?: null,
        'email' => $email,
        'phone' => $phone ?: null,
        'service' => $service ?: null,
        'message' => $message,
    ]);

    if ($isJsonRequest) {
        respondWithJson(201, 'Thank you. Your enquiry has been saved. Our team will review it.');
    }

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    redirectWithStatus('success', 'Thank you. Your enquiry has been saved. Our team will review it.');
} catch (Throwable $e) {
    error_log('Sea Asia contact form database error: ' . $e->getMessage());
    $error = 'We could not save your enquiry right now. Please contact us by phone or email.';
    if ($isJsonRequest) {
        respondWithJson(500, $error);
    }
    redirectWithStatus('error', $error);
}
