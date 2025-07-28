<?php
session_start();
require_once 'auth.php';
header('Content-Type: application/json');

$auth = new Auth(new Database());
$conn = $auth->getConnection();

$response = ['success' => false];

if (!isset($_SESSION['u_id'])) {
    echo json_encode($response);
    exit;
}

$id = $_POST['id'] ?? null;
$column = $_POST['column'] ?? null;
$value = $_POST['value'] ?? null;

if (!$id || !$column || $value === null) {
    echo json_encode($response);
    exit;
}

// Sanitize column name (whitelist)
$allowedColumns = ['name', 'password', 'phone', 'dob', 'state', 'lga', 'address', 'bio'];
if (!in_array($column, $allowedColumns)) {
    echo json_encode($response);
    exit;
}

if ($column === 'password') {
    $value = password_hash($value, PASSWORD_BCRYPT);
}

$sql = "UPDATE user_profile SET $column = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('si', $value, $id);
    if ($stmt->execute()) {
        $response['success'] = true;
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
