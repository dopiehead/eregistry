<?php
declare(strict_types=1);

require_once 'auth.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
    exit;
}

$auth = new Auth(new Database());
$data = json_decode(file_get_contents('php://input'), true);

// Sanitize and validate fields
$firstname = trim($data['firstName'] ?? '');
$lastname = trim($data['lastName'] ?? '');
$email = trim($data['email'] ?? '');
$message = trim($data['message'] ?? '');
$subject = trim($data['subject'] ?? 'General Inquiry'); // Default subject if not provided
$date = date("Y-m-d H:i:s");

// Basic validation
if (empty($firstname) || empty($email) || empty($message)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields: firstName, email, or message'
    ]);
    exit;
}

// Call your method (make sure contactUs exists in your Auth class)
$helpline = $auth->contactUs($firstname, $lastname, $subject, $email, $message, $date);

if ($helpline) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Your message was received!'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error in sending message'
    ]);
}
