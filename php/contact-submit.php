<?php
declare(strict_types=1);

session_start();

// Save a short result message, then return the visitor to the contact page.
function redirectWithStatus(string $type, string $message): never
{
    $_SESSION['contact_status'] = ['type' => $type, 'message' => $message];
    header('Location: ../contact.php', true, 303);
    exit;
}

// The form handler accepts submissions only.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contact.php', true, 303);
    exit;
}

// Honeypot: silently accept automated submissions without saving them.
if (!empty($_POST['website'] ?? '')) {
    redirectWithStatus('success', 'Thank you. Your enquiry has been received.');
}

// Verify the form session before reading the submitted enquiry.
$postedToken = (string) ($_POST['csrf_token'] ?? '');
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $postedToken)) {
    redirectWithStatus('error', 'Your form session expired. Please reload the page and try again.');
}

// Read and validate the visitor's contact details.
$name = trim((string) ($_POST['name'] ?? ''));
$company = trim((string) ($_POST['company'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$service = trim((string) ($_POST['service'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

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
    redirectWithStatus('error', 'Please check the required fields and their length, then submit again.');
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
    redirectWithStatus('error', 'Please select a service from the list.');
}

// Connect using the database settings supplied by the hosting environment.
$host = getenv('DB_HOST') ?: '127.0.0.1';
$db = getenv('DB_NAME') ?: '';
$user = getenv('DB_USER') ?: '';
$pass = getenv('DB_PASSWORD') ?: '';

if ($db === '' || $user === '') {
    error_log('Sea Asia contact form: database environment is not configured.');
    redirectWithStatus('error', 'The enquiry form is temporarily unavailable. Please try again later.');
}

// Save the enquiry, then show a success or error message on the contact page.
try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$db};charset=utf8mb4",
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

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    redirectWithStatus('success', 'Thank you. Your enquiry has been received. Our team will review it.');
} catch (Throwable $e) {
    error_log('Sea Asia contact form database error: ' . $e->getMessage());
    redirectWithStatus('error', 'We could not save your enquiry right now. Please try again later.');
}
