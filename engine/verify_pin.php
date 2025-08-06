<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');


header('Content-Type: application/json');

require_once 'auth.php';

$auth = new Auth(new Database());
$conn = $auth->getConnection();

// Read JSON body
$inputRaw = file_get_contents('php://input');
$input = json_decode($inputRaw, true);

// Basic input validation
$pin = isset($input['pin']) ? trim((string)$input['pin']) : '';
if ($pin === '' || !ctype_digit($pin)) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'PIN is required and must be numeric.'
    ]);
    exit;
}
$pinInt = (int)$pin;

/**
 * 1) Verify active user with this PIN exists
 */
$verify = $conn->prepare("SELECT id FROM user_profile WHERE status = 'active' AND pin = ?");
if (!$verify) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare verification query.']);
    exit;
}
$verify->bind_param("i", $pinInt);
$verify->execute();
$verifyRes = $verify->get_result();

if (!$verifyRes || $verifyRes->num_rows === 0) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Invalid PIN or inactive account.'
    ]);
    exit;
}
$user = $verifyRes->fetch_assoc();
$verify->close();

/**
 * 2) Fetch next_of_kin by PIN
 */
$getNextOfKin = $conn->prepare("SELECT * FROM next_of_kin WHERE pin = ?");
if (!$getNextOfKin) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare next-of-kin query.']);
    exit;
}
$getNextOfKin->bind_param("i", $pinInt);
$getNextOfKin->execute();
$nokRes = $getNextOfKin->get_result();

if (!$nokRes || $nokRes->num_rows === 0) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'No next-of-kin record found for this PIN.'
    ]);
    exit;
}

$row = $nokRes->fetch_assoc();
$getNextOfKin->close();

// Set session values safely
$_SESSION['next_of_kin_id']            = (int)$row['id'];
$_SESSION['next_of_kin_name']          = (string)$row['next_of_kin_name'];
$_SESSION['next_of_kin_pin']           = (string)($row['pin'] ?? $pinInt);
$_SESSION['next_of_kin_relationship']  = (string)$row['next_of_kin_relationship'];

echo json_encode([
    'status'  => 'success',
    'message' => 'Login successful.',
    'data'    => [
        'id'            => (int)$row['id'],
        'name'          => (string)$row['next_of_kin_name'],
        'relationship'  => (string)$row['next_of_kin_relationship'],
        'expiry_date'   => (string)($row['expiry_date'] ?? '')
    ]
]);
exit;
