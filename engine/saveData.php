<?php 

session_start();
header('Content-Type: application/json');
require_once 'auth.php';

$auth = new Auth(new Database());
$conn = $auth->getConnection();

$response = ['success' => false];

$id = $_POST['id'] ?? null;
$column = $_POST['column'] ?? null;
$value = $_POST['value'] ?? null;

$allowedColumns = ['name', 'password', 'phone', 'dob', 'state', 'lga', 'address', 'bio', 'family'];
if (!$id || !$column || $value === null || !in_array($column, $allowedColumns)) {
    echo json_encode($response);
    exit;
}


// Phone number validation
if ($column === 'phone') {
    // Remove any non-digit characters (optional)
    $value = preg_replace('/\D/', '', $value); 

    if (!ctype_digit($value) || strlen($value) < 11) {
        $response['error'] = "Phone number must be at least 11 digits and contain only numbers.";
        echo json_encode($response);
        exit;
    }
}


if ($column === 'password') {
    $value = password_hash($value, PASSWORD_BCRYPT);
}

$sql = "UPDATE user_profile SET `$column` = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('si', $value, $id);
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
