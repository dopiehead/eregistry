<?php
declare(strict_types=1);

/**
 * engine/verify_pin.php
 * Minimal-error JSON responses.
 */

error_reporting(E_ALL);                       // keep strict internally
ini_set('display_errors', '0');               // never echo PHP errors
ini_set('display_startup_errors', '0');
header('Content-Type: application/json; charset=utf-8');
session_start();
ob_start();                                   // capture accidental output

// Turn PHP warnings/notices into exceptions so we can return clean JSON
set_error_handler(function (int $severity, string $message, string $file, int $line) {
    if (!(error_reporting() & $severity)) return false;
    throw new ErrorException('Server error', 0, $severity, $file, $line);
});

// Return helpers (minimal messages)
function json_fail(string $msg, int $code = 400): void {
    http_response_code($code);
    $payload = ['success' => false, 'error' => $msg];
    // discard any accidental output and send clean JSON
    ob_end_clean();
    echo json_encode($payload);
    exit;
}

function json_ok(array $data): void {
    http_response_code(200);
    $payload = array_merge(['success' => true], $data);
    ob_end_clean();
    echo json_encode($payload);
    exit;
}

try {
    require_once __DIR__ . '/auth.php';

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        json_fail('Method not allowed', 405);
    }

    // DB connect
    $auth = new Auth(new Database());
    $conn = $auth->getConnection();
    if (!($conn instanceof mysqli)) {
        json_fail('Service unavailable', 503);
    }

    // Body
    $raw = file_get_contents('php://input') ?: '';
    $input = json_decode($raw, true);
    if (!is_array($input)) {
        json_fail('Invalid request', 400);
    }

    // Validate PIN (exactly 4 digits, as string to keep leading zeros)
    $pin = isset($input['pin']) ? trim((string)$input['pin']) : '';
    if (!preg_match('/^\d{4}$/', $pin)) {
        json_fail('Invalid PIN', 422);
    }

    // 1) Verify active user by PIN
    $sqlVerify = "SELECT id FROM user_profile WHERE verified = 1 AND pin = ? LIMIT 1";
    $stmt = $conn->prepare($sqlVerify);
    if (!$stmt) json_fail('Service error', 500);
    $stmt->bind_param('s', $pin);
    if (!$stmt->execute()) { $stmt->close(); json_fail('Service error', 500); }
    $stmt->bind_result($userId);
    $hasUser = $stmt->fetch();
    $stmt->close();
    if (!$hasUser) {
        json_fail('Invalid credentials', 401);
    }

    // 2) Fetch next_of_kin by PIN
    $sqlNok = "SELECT id, next_of_kin_name, next_of_kin_relationship, expiry_date
               FROM next_of_kin WHERE pin = ? LIMIT 1";
    $stmt = $conn->prepare($sqlNok);
    if (!$stmt) json_fail('Service error', 500);
    $stmt->bind_param('s', $pin);
    if (!$stmt->execute()) { $stmt->close(); json_fail('Service error', 500); }
    $stmt->bind_result($nokId, $nokName, $nokRel, $nokExpiry);
    $hasNok = $stmt->fetch();
    $stmt->close();

    if (!$hasNok) {
        json_fail('Record not found', 404);
    }

    // Save session (minimal)
    $_SESSION['next_of_kin_id']           = (int)$nokId;
    $_SESSION['next_of_kin_name']         = (string)$nokName;
    $_SESSION['next_of_kin_pin']          = $pin;
    $_SESSION['next_of_kin_relationship'] = (string)$nokRel;

    json_ok([
        'message'  => 'OK',
        'redirect' => 'protected/userdashboarddetails.php',
        'data'     => [
            'id'           => (int)$nokId,
            'name'         => (string)$nokName,
            'relationship' => (string)$nokRel,
            'expiry_date'  => $nokExpiry !== null ? (string)$nokExpiry : ''
        ]
    ]);

} catch (Throwable $e) {
    // One-line minimal fallback
    json_fail('Server error', 500);
}
