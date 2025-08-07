<?php
declare(strict_types=1);

// --- JSON Response ---
header('Content-Type: application/json');

// --- Enable error logging but not display ---
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
ini_set("log_errors", "1");
ini_set("error_log", __DIR__ . "/php-error.log");

// --- Load dependencies ---
require_once 'auth.php';

try {
    // --- Ensure POST method ---
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        exit;
    }

    // --- Get input safely ---
    $bank_name     = $_POST['bank_name']     ?? null;
    $bank_account  = $_POST['bank_account']  ?? null;
    $bank_balance  = $_POST['bank_balance']  ?? null;
    $account_type  = $_POST['account_type']  ?? null;
    $account_details  = $_POST['account_details']  ?? null;

    // --- Validate fields one by one ---
    if (!$bank_name) {
        echo json_encode(['success' => false, 'error' => 'Bank name is required.']);
        exit;
    }
    if (!$bank_account) {
        echo json_encode(['success' => false, 'error' => 'Bank account is required.']);
        exit;
    }
    if (!$bank_balance) {
        echo json_encode(['success' => false, 'error' => 'Bank balance is required.']);
        exit;
    }
    if (!$account_type) {
        echo json_encode(['success' => false, 'error' => 'Account type is required.']);
        exit;
    }

    // --- Initialize DB/Auth ---
    $auth = new Auth(new Database());
    $conn = $auth->getConnection();

    if (!$auth->isLoggedIn()) {
        echo json_encode(['success' => false, 'error' => 'User not authenticated.']);
        exit;
    }

    $user_id = $auth->getUserId();

    // --- Check if details already exist for user ---
    $check = $conn->prepare("SELECT bank_name, bank_account FROM bank_details WHERE u_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Bank details already submitted.']);
        $check->close();
        exit;
    }
    $check->close();

    // --- Insert new bank details ---
    $insert = $conn->prepare("INSERT INTO bank_details (u_id, bank_name, bank_account, bank_balance, account_type, account_details) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("isssss", $user_id, $bank_name, $bank_account, $bank_balance, $account_type, $account_details);

    if ($insert->execute()) {
        echo json_encode(['success' => true, 'message' => 'Bank details saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save bank details.']);
    }

    $insert->close();
    $conn->close();

} catch (Throwable $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Server error occurred.',
        'message' => $e->getMessage()
    ]);
    exit;
}
