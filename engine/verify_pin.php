<?php
declare(strict_types=1);

/**
 * engine/verify_pin.php
 * Explicit JSON errors when DEBUG is true.
 */

$DEBUG = true; // <<< set to false in production

error_reporting(E_ALL);
ini_set('display_errors', $DEBUG ? '1' : '0');
ini_set('display_startup_errors', $DEBUG ? '1' : '0');
header('Content-Type: application/json; charset=utf-8');
ob_start();

// Turn warnings/notices into Exceptions
set_error_handler(function (int $severity, string $message, string $file, int $line) {
    if (!(error_reporting() & $severity)) return false;
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Make mysqli throw on errors (so we can catch and JSON them)
if ($DEBUG && function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

// JSON helpers
function json_fail(string $msg, int $code = 400, array $debug = null): void {
    http_response_code($code);
    $payload = ['success' => false, 'error' => $msg];
    if ($debug) $payload['debug'] = $debug;
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
        json_fail('Invalid request', 400, $DEBUG ? ['raw' => $raw] : null);
    }

    // Validate PIN (exactly 4 digits, keep leading zeros)
    $pin = isset($input['pin']) ? trim((string)$input['pin']) : '';
    if (!preg_match('/^\d{4}$/', $pin)) {
        json_fail('Invalid PIN', 422);
    }

    // 1) Verify active user by PIN
    $sqlVerify = "SELECT id FROM user_profile WHERE verified = 1 AND pin = ? LIMIT 1";
    $stmt = $conn->prepare($sqlVerify);
    if (!$stmt) json_fail('Service error', 500, $DEBUG ? ['where' => 'prepare verify'] : null);
    $stmt->bind_param('s', $pin);
    $stmt->execute();
    $stmt->bind_result($userId);
    $hasUser = $stmt->fetch();
    $stmt->close();

    if (!$hasUser) {
        json_fail('Invalid credentials', 401);
    }

    // 2) Fetch next_of_kin by PIN
    $sqlNok = "SELECT id, next_of_kin_name, email, next_of_kin_relationship, expiry_date
               FROM next_of_kin WHERE pin = ? LIMIT 1";
    $stmt = $conn->prepare($sqlNok);
    if (!$stmt) json_fail('Service error', 500, $DEBUG ? ['where' => 'prepare nok'] : null);
    $stmt->bind_param('s', $pin);
    $stmt->execute();
    $stmt->bind_result($nokId, $nokName, $nokEmail, $nokRel, $nokExpiry);
    $hasNok = $stmt->fetch();
    $stmt->close();

    if (!$hasNok) {
        json_fail('Record not found', 404);
    }

    // Save session
    $_SESSION['next_of_kin_id']           = (int)$nokId;
    $_SESSION['next_of_kin_name']         = (string)$nokName;
    $_SESSION['next_of_kin_email'] = (string)$nokEmail;
    $_SESSION['next_of_kin_pin']          = $pin;
    $_SESSION['next_of_kin_relationship'] = (string)$nokRel;

    // 3) Insert notification (safe, non-blocking)
    // Adjust to your schema: if sender_id is INT, set $admin = 1 and adjust bind types.
    
    $message = $nokName . ' tried to login';
    $admin   = 'admin';
    $pending = 0;
    $date    = date('Y-m-d H:i:s');

    $insSql = "INSERT INTO user_notifications (sender_id, message, recipient_id, pending, date)
               VALUES (?, ?, ?, ?, ?)";
    if ($ins = $conn->prepare($insSql)) {
        $ins->bind_param('ssiss', $admin, $message, $userId, $pending, $date);
        try {
            $ins->execute();
        } catch (Throwable $e) {
            // If DEBUG, surface insert error details in a non-fatal way
            if ($DEBUG) {
                // Don’t fail the whole request; attach debug info instead.
                $notifErr = $e->getMessage();
            }
        }
        $ins->close();
    } elseif ($DEBUG) {
        $notifErr = 'prepare failed';
    }

    // Success
    $resp = [
        'message'  => 'OK',
        'redirect' => 'protected/userdashboarddetails.php',
        'data'     => [
            'id'           => (int)$nokId,
            'name'         => (string)$nokName,
            'relationship' => (string)$nokRel,
            'expiry_date'  => $nokExpiry !== null ? (string)$nokExpiry : ''
        ]
    ];
    if ($DEBUG && isset($notifErr)) {
        $resp['debug']['notification'] = $notifErr;
    }
    json_ok($resp);

} catch (Throwable $e) {
    // Show explicit error when DEBUG is on
    $msg = $DEBUG ? $e->getMessage() : 'Server error';
    $dbg = null;

    if ($DEBUG) {
        // include minimal context to help debugging; avoid file/line if you prefer
        $dbg = [
            'phase'       => 'catch',
            'last_error'  => error_get_last(),
            // comment next line if you want even less detail:
            'trace'       => $e->getTrace()
        ];
    }
    json_fail($msg, 500, $dbg);
}
