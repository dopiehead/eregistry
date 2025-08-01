<?php
declare(strict_types=1);

// Show all errors during development
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Return JSON response
header('Content-Type: application/json');

// Load dependencies
require_once 'auth.php';

$auth = new Auth(new Database());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Decode incoming JSON data
    $input = json_decode(file_get_contents("php://input"), true);

    // Sanitize inputs
    $email = filter_var(trim($input['login-email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($input['login-password'] ?? '');

    // Validate
    if (empty($email) || empty($password)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email and password are required.'
        ]);
        exit;
    }

    // Attempt login
    if ($auth->login($email, $password)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful.'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid email or password.'
        ]);
        exit;
    }

} else {
    // Invalid request method
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are allowed.'
    ]);
    http_response_code(405); // Method Not Allowed
}
?>
