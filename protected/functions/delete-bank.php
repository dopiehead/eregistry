<?php
// delete-bank.php

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../../engine/auth.php';
$auth = new Auth(new Database());
$conn = $auth->getConnection();
// Check if 'id' is passed via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Bank ID not provided.");
}

$bank_id = (int) $_GET['id'];

try {
  
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Optional: Validate if the record exists before deleting
    $checkQuery = $conn->prepare("SELECT id FROM bank_details WHERE id = ?");
    $checkQuery->bind_param("i", $bank_id);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows === 0) {
        echo "Bank detail not found.";
        exit;
    }

    // Delete the bank record
    $stmt = $conn->prepare("DELETE FROM bank_details WHERE id = ?");
    $stmt->bind_param("i", $bank_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Bank record deleted successfully.";
    } else {
        echo "Failed to delete record.";
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
