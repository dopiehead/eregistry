<?php
// bank-details.php
declare(strict_types=1);
require_once '../../engine/auth.php';
$auth = new Auth(new Database());
$conn = $auth->getConnection();

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Missing ID in URL.");
}

$stmt = $conn->prepare("SELECT * FROM bank_details WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$bank = $result->fetch_assoc();

if (!$bank) {
    die("Bank record not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bank Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <form action="save-bank-details.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <div class="mb-3">
            <label class="form-label">Bank Name</label>
            <input type="text" name="bank_name" class="form-control" value="<?= htmlspecialchars($bank['bank_name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Bank Account Number</label>
            <input type="text" name="bank_account" class="form-control" value="<?= htmlspecialchars($bank['bank_account'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Bank Balance</label>
            <input type="text" name="bank_balance" class="form-control" value="<?= htmlspecialchars($bank['bank_balance'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Account Type</label>
            <input type="text" name="account_type" class="form-control" value="<?= htmlspecialchars($bank['account_type'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Account Details</label>
            <textarea name="account_details" class="form-control" rows="3"><?= htmlspecialchars($bank['account_details'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Details</button>
    </form>
</body>
</html>
