<?php

declare(strict_types=1);

require_once 'auth.php';

header('Content-Type: application/json');

$auth = new Auth(new Database());

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || empty($data['email'])) {
    echo json_encode([
        "success" => false,
        "message" => "Email is required."
    ]);
    exit;
}

$email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
$vkey = bin2hex(random_bytes(32)); // 64-character secure key
$created_at = date("Y-m-d H:i:s");

if (!$email) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email address."
    ]);
    exit;
}

$forgotten = $auth->forgotPassword($email, $vkey, $created_at);

if ($forgotten) {
    // Simulate email send here (or send the link)
    // e.g., $resetLink = "https://yourdomain.com/reset-password.php?vkey=$vkey";

    echo json_encode([
        "success" => true,
        "message" => "A password reset link has been sent to your email.",
        "vkey" => $vkey // only for testing, remove in production
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Something went wrong while processing your request."
    ]);
}

?>