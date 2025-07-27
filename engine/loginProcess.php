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

    $email = $input['login-email'] ?? '';
    
    $password = $input['login-password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email and password are required.'
        ]);
        exit;
    }

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
    }
}
?>


