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

// Email credentials belong in the hosting environment, never in committed source.
$apiKey = getenv('RESEND_API_KEY') ?: '';
$recipient = getenv('CONTACT_TO_EMAIL') ?: 'shikhardhangar0118@gmail.com';
$sender = getenv('CONTACT_FROM_EMAIL') ?: '';

if ($apiKey === '' || $sender === '') {
    error_log('Sea Asia contact form: email delivery is not configured.');
    $error = 'Enquiry sending is not configured yet. Please contact us by email or WhatsApp.';
    if ($isJsonRequest) {
        respondWithJson(503, $error);
    }
    redirectWithStatus('error', $error);
}

$subject = 'Website enquiry' . ($service !== '' ? ' — ' . $service : '');
$text = "New enquiry from the Sea Asia website\n\n"
    . "Name: {$name}\n"
    . 'Company: ' . ($company !== '' ? $company : 'Not provided') . "\n"
    . "Email: {$email}\n"
    . 'Phone: ' . ($phone !== '' ? $phone : 'Not provided') . "\n"
    . 'Service: ' . ($service !== '' ? $service : 'Not specified') . "\n\n"
    . "Shipment details:\n{$message}\n";

$payload = json_encode([
    'from' => $sender,
    'to' => [$recipient],
    'reply_to' => $email,
    'subject' => $subject,
    'text' => $text,
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Authorization: Bearer {$apiKey}\r\nContent-Type: application/json\r\nAccept: application/json\r\n",
        'content' => $payload,
        'timeout' => 12,
        'ignore_errors' => true,
    ],
]);

$responseBody = @file_get_contents('https://api.resend.com/emails', false, $context);
$statusLine = $http_response_header[0] ?? '';
preg_match('/\s(\d{3})\s/', $statusLine, $statusMatch);
$httpStatus = isset($statusMatch[1]) ? (int) $statusMatch[1] : 0;

if ($responseBody === false || $httpStatus < 200 || $httpStatus >= 300) {
    error_log('Sea Asia contact form email delivery failed. HTTP status: ' . $httpStatus . '; response: ' . (string) $responseBody);
    $error = 'We could not send your enquiry right now. Please contact us by email or WhatsApp.';
    if ($isJsonRequest) {
        respondWithJson($httpStatus === 0 ? 503 : 500, $error);
    }
    redirectWithStatus('error', $error);
}

if ($isJsonRequest) {
    respondWithJson(201, 'Thank you. Your enquiry has been sent to our team.');
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
redirectWithStatus('success', 'Thank you. Your enquiry has been sent to our team.');
