<?php
declare(strict_types=1);

require_once 'auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method Not Allowed. Use POST.'
    ]);
    return;
}

$auth = new Auth(new Database());
$data = json_decode(file_get_contents('php://input'), true);

// Validate and sanitize email
$email = trim($data['email'] ?? '');
$date = date("Y-m-d H:i:s");

// Validate email format
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'status' => 'error',
        'message' => 'A valid email is required.'
    ]);
    return;
}

// Call your method
try {
    $subscribed = $auth->subscribe($email, $date);

    if ($subscribed) {
        echo json_encode([
            'status' => 'success',
            'message' => 'You have been subscribed successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Subscription failed. You may already be subscribed.'
        ]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Internal server error',
        'debug' => $e->getMessage() // Remove in production
    ]);
}
