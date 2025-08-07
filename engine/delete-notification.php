<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load DB connection (change this as per your actual path)
require_once '../engine/auth.php';

$auth = new Auth(new Database());
$conn = $auth->getConnection();

// ✅ Now using POST
$id = isset($_POST['id']) ? (int)$_POST['id'] : null;

if (!empty($id)) {
    try {
        $stmt = $conn->prepare("DELETE FROM user_notifications WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "1";
        } else {
            echo "No notification found with that ID.";
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid or missing ID.";
}
