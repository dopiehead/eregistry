<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require_once 'auth.php';

header('Content-Type: application/json');

$auth = new Auth(new Database());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    // Validate and sanitize inputs
    $name = trim($input['signup-name'] ?? '');
    $email = trim($input['signup-email'] ?? '');
    $password = $input['signup-password'] ?? '';
    $bio = trim($input['bio'] ?? '');
    $pin = $input['pin'] ?? '';
    $image = $input['image'] ?? null; // Optional
    $created = date('Y-m-d H:i:s');
    $verified = 0;
    $vkey = md5(time() . $email);

    if (empty($email) || empty($password)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email and password are required.'
        ]);
        exit;
    }

    // Attempt registration
    $registered = $auth->register($name, $email, $password, $image, $bio, $pin, $vkey, $verified, $created);

    if ($registered) {
        echo json_encode([
            'status' => 'success',
            'message' => 'User registered successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email already exists or registration failed.'
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are allowed.'
    ]);
}
