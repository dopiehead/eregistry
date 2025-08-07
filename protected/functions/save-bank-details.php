<?php
// save-bank-details.php
declare(strict_types=1);
require_once '../../engine/auth.php';
$auth = new Auth(new Database());
$conn = $auth->getConnection();

$id = $_POST['id'] ?? null;
$bank_name = $_POST['bank_name'] ?? '';
$bank_account = $_POST['bank_account'] ?? '';
$bank_balance = $_POST['bank_balance'] ?? '';
$account_type = $_POST['account_type'] ?? '';
$account_details = $_POST['account_details'] ?? '';

if (!$id || !$bank_name || !$bank_account || !$bank_balance || !$account_type) {
    die("All required fields must be filled.");
}

$stmt = $conn->prepare("UPDATE bank_details SET bank_name=?, bank_account=?, bank_balance=?, account_type=?, account_details=? WHERE id=?");
$stmt->bind_param("sssssi", $bank_name, $bank_account, $bank_balance, $account_type, $account_details, $id);

if ($stmt->execute()) {
    echo "Bank details updated successfully. <a href='bank-details.php?id=$id'>Back</a>";
} else {
    echo "Error updating record: " . $stmt->error;
}
