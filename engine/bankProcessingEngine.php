<?php
header('Content-Type: application/json');

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$response = ['success' => false];

// Validate inputs
$bank_name = trim($data['bank_name'] ?? '');
$bank_account = trim($data['bank_account'] ?? '');
$bank_balance = trim($data['bank_balance'] ?? '');

if (!$bank_name || !$bank_account || !$bank_balance) {
    $response['error'] = 'All fields are required.';
    echo json_encode($response);
    exit;
}

if (!is_numeric($bank_balance)) {
    $response['error'] = 'Bank balance must be a number.';
    echo json_encode($response);
    exit;
}

require_once 'auth.php';
$auth = new Auth(new Database());
$conn = $auth->getConnection();
$user_id = $auth->getUserId(); // Assuming session is active

// Check if row exists
$check = $conn->prepare("SELECT u_id FROM bank_details WHERE u_id = ?");
$check->bind_param("i", $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Record exists — do UPDATE
    $stmt = $conn->prepare("UPDATE bank_details SET bank_name = ?, bank_account = ?, bank_balance = ? WHERE u_id = ?");
    $stmt->bind_param("ssdi", $bank_name, $bank_account, $bank_balance, $user_id);
} else {
    // No record — do INSERT
    $stmt = $conn->prepare("INSERT INTO bank_details (u_id, bank_name, bank_account, bank_balance) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $user_id, $bank_name, $bank_account, $bank_balance);
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
