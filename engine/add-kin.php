<?php
header('Content-Type: application/json');

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$response = ['success' => false];

// Validate inputs
$next_of_kin_name = trim($data['next_of_kin_name'] ?? '');
$next_of_kin_address = trim($data['next_of_kin_address'] ?? '');
$next_of_kin_telephone = trim($data['next_of_kin_telephone'] ?? '');
$next_of_kin_relationship = trim($data['next_of_kin_relationship'] ?? '');
$pin = trim($data['pin'] ?? '');
$expiry_date = date("Y-m-d H:i:s");

if (!$next_of_kin_name || !$next_of_kin_address || !$next_of_kin_relationship) {
    $response['error'] = 'All fields are required.';
    echo json_encode($response);
    exit;
}

if (!is_numeric($next_of_kin_telephone)) {
    $response['error'] = 'Telephone detail must be a number.';
    echo json_encode($response);
    exit;
}

require_once 'auth.php';
$auth = new Auth(new Database());
$conn = $auth->getConnection();
$user_id = $auth->getUserId(); // Assuming session is active

// Check if row exists
$check = $conn->prepare("SELECT u_id FROM next_of_kin WHERE u_id = ?");
$check->bind_param("i", $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Record exists — do UPDATE
    $stmt = $conn->prepare("
        UPDATE next_of_kin 
        SET next_of_kin_name = ?, 
            next_of_kin_address = ?, 
            next_of_kin_telephone = ?, 
            next_of_kin_relationship = ? 
        WHERE u_id = ?
    ");
    $stmt->bind_param("ssssi", $next_of_kin_name, $next_of_kin_address, $next_of_kin_telephone, $next_of_kin_relationship, $user_id);
} else {
    // No record — do INSERT
    $stmt = $conn->prepare("
        INSERT INTO next_of_kin (u_id, next_of_kin_name, next_of_kin_address, next_of_kin_telephone, next_of_kin_relationship, pin, status, expiry_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssssss", $user_id, $next_of_kin_name, $next_of_kin_address, $next_of_kin_telephone, $next_of_kin_relationship, $pin, $status, $expiry_date);
}
$check->close();

// Run query
if ($stmt) {
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['error'] = $stmt->error;
    }
    $stmt->close();
} else {
    $response['error'] = $conn->error;
}

echo json_encode($response);
