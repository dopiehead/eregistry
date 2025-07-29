<?php

declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once 'auth.php';

header('Content-Type: application/json');

$auth = new Auth(new Database());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    // Sanitize and fetch input data
    $name       = trim($input['signup-name'] ?? '');
    $email      = trim($input['signup-email'] ?? '');
    $password   = $input['signup-password'] ?? '';
    $state      = trim($input['state'] ?? '');
    $lga        = trim($input['lga'] ?? '');
    $address    = trim($input['address'] ?? '');
    $bio        = trim($input['bio'] ?? '');
    $phone      = trim($input['phone'] ?? '');
    $occupation = trim($input['occupation'] ?? '');
    $dob        = trim($input['dob'] ?? '');
    $family     = trim($input['family'] ?? '');
    $image      = $input['image'] ?? '';
    $pin        = $input['pin'] ?? null;
    $vkey       = md5(time() . $email);
    $verified   = 0;
    $created    = date('Y-m-d H:i:s');

    // Basic validation
    if (empty($email) || empty($password)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email and password are required.'
        ]);
        exit;
    }

    // Attempt registration
    $registered = $auth->register(
        $name,
        $email,
        $password,
        $state,
        $lga,
        $address,
        $bio,
        $phone,
        $occupation,
        $dob,
        $family,
        $image,
        $pin,
        $vkey,
        $verified,
        $created
    );

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
