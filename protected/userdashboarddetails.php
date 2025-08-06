<?php
declare(strict_types=1);

include __DIR__ . "/contents/permission.php"; // should define $conn and start session or auth
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Guard: ensure we have the PIN in session
if (empty($_SESSION['next_of_kin_pin'])) {
    http_response_code(302);
    header("Location: /pin"); // change to your PIN page
    exit;
}

$pin = (int)$_SESSION['next_of_kin_pin'];

// Fetch user fields by PIN (treat as string to preserve leading zeros)
$sql = "SELECT name, email, state, lga, address, bio, phone, occupation, dob, family
        FROM user_profile
        WHERE pin = ?
        LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    $error = "Service error";
} else {
    $stmt->bind_param("s", $pin);
    if (!$stmt->execute()) {
        http_response_code(500);
        $error = "Service error";
    } else {
        // Use bind_result to avoid mysqlnd dependency
        $stmt->bind_result(
            $name, $email, $state, $lga, $address, $bio, $phone, $occupation, $dob, $family
        );
        $found = $stmt->fetch();
        if (!$found) {
            http_response_code(404);
            $error = "Record not found";
        }
    }
    $stmt->close();
}

// Helper to escape output
function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background:#fff; }
    .profile { max-width: 920px; margin: 2rem auto; }
    .label { color:#6c757d; font-size:.9rem; }
    .value { font-weight: 600; }
    .card { border-radius: 16px; }
  </style>
</head>
<body>
  <div class="container profile">
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger mt-3"><?= e($error) ?></div>
    <?php else: ?>
      <div class="card p-3 p-md-4 shadow-sm">
        <h1 class="h4 mb-3">User Profile</h1>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="label">Name</div>
            <div class="value"><?= e($name) ?></div>
          </div>
          <div class="col-md-6">
            <div class="label">Email</div>
            <div class="value"><?= e($email) ?></div>
          </div>

          <div class="col-md-4">
            <div class="label">State</div>
            <div class="value"><?= e($state) ?></div>
          </div>
          <div class="col-md-4">
            <div class="label">LGA</div>
            <div class="value"><?= e($lga) ?></div>
          </div>
          <div class="col-md-4">
            <div class="label">Phone</div>
            <div class="value"><?= e($phone) ?></div>
          </div>

          <div class="col-12">
            <div class="label">Address</div>
            <div class="value"><?= e($address) ?></div>
          </div>

          <div class="col-md-6">
            <div class="label">Occupation</div>
            <div class="value"><?= e($occupation) ?></div>
          </div>
          <div class="col-md-6">
            <div class="label">Date of Birth</div>
            <div class="value"><?= e($dob) ?></div>
          </div>

          <div class="col-12">
            <div class="label">Family</div>
            <div class="value"><?= e($family) ?></div>
          </div>

          <div class="col-12">
            <div class="label">Bio</div>
            <div class="value"><?= nl2br(e($bio)) ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
