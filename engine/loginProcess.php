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
$conn = $auth->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Decode incoming JSON data
    $input = json_decode(file_get_contents("php://input"), true);

    // Sanitize and type cast
    $email = (string) filter_var(trim($input['login-email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = (string) trim($input['login-password'] ?? '');

    // Validate
    if ($email === '' || $password === '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email and password are required.'
        ]);
        exit;
    }

    // Attempt login
    if ($auth->login($email, $password)) {

        // Update last login time
        $newDateTime = date("Y-m-d H:i:s");
        $lastLoginTime = $conn->prepare("UPDATE user_profile SET updated_at = ? WHERE email = ?");
        $lastLoginTime->bind_param("ss", $newDateTime, $email);
        $lastLoginTime->execute();
        $lastLoginTime->close();

        // Example: deactivate expired pins older than 3 months
        $stopPin = $conn->prepare("
            UPDATE next_of_kin 
            SET status = 'inactive' 
            WHERE email = ? 
              AND expiry_date <= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
        ");
        $stopPin->bind_param("s", $email);
        $stopPin->execute();
        $stopPin->close();

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
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are allowed.'
    ]);
}
