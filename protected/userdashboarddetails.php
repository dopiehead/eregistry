<?php
declare(strict_types=1);
require("../engine/auth.php");
$auth = new Auth(new Database());
$conn = $auth->getConnection();
// should define $conn and start session or auth
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Guard: ensure we have the PIN in session
if (empty($_SESSION['next_of_kin_pin'])) {
    http_response_code(302);
    header("Location:nextOfkinSignin.php"); // change to your PIN page
    exit;
}

$pin = (string)$_SESSION['next_of_kin_pin']; // keep as string to preserve leading zeros

// Fetch user fields by PIN
$sql = "SELECT id, name, email, state, lga, address, bio, phone, occupation, dob, family
        FROM user_profile
        WHERE pin = ?
        LIMIT 1";
$stmt = $conn->prepare($sql);
$error = '';
$found = false;
$id = $name = $email = $state = $lga = $address = $bio = $phone = $occupation = $dob = $family = '';

if (!$stmt) {
    http_response_code(500);
    $error = "Service error";
} else {
    $stmt->bind_param("s", $pin); // string binding
    if (!$stmt->execute()) {
        http_response_code(500);
        $error = "Service error";
    } else {
        // Use bind_result to avoid mysqlnd dependency
        $stmt->bind_result(
            $id, $name, $email, $state, $lga, $address, $bio, $phone, $occupation, $dob, $family
        );
        $found = (bool)$stmt->fetch();
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

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <!-- css for user dashboard -->
   <link rel="stylesheet" href="../assets/css/protected/userdashboarddetails.css">

</head>
<body>
  <div class="header-section">
    <a href="../engine/logOut" class="logout-btn">
      <i class="fas fa-sign-out-alt me-2"></i>Log out
    </a>
    
    <div class="profile-container">
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-triangle me-2"></i><?= e($error) ?>
        </div>
      <?php else: ?>
        <div class="profile-header">
  <div class="profile-avatar">
    <?php
      // Prefer DB name if available; fallback to session; then to "?"
      $displayName = $name !== '' ? $name : ($_SESSION['next_of_kin_name'] ?? '');
      $initial = $displayName !== '' ? mb_strtoupper(mb_substr($displayName, 0, 1, 'UTF-8'), 'UTF-8') : '?';
      echo e($initial);
    ?>
  </div>
  <h1 class="profile-name"><?= e($displayName) ?></h1>
  <p class="profile-email">
    <?= e($email !== '' ? $email : ($_SESSION['next_of_kin_email'] ?? '')) ?>
  </p>
</div>
      <?php endif; ?>
    </div>
  </div>

  <div class="profile-container">
    <?php if (!empty($error)): ?>
      <!-- Error already shown in header -->
    <?php else: ?>
      <!-- Personal Information -->
      <div class="profile-card loading">
        <div class="card-header">
          <h2 class="card-title">
            <i class="fas fa-user"></i>
            Personal Information
          </h2>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-user"></i>
                  Full Name
                </div>
                <div class="field-value"><?= e($name) ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-envelope"></i>
                  Email Address
                </div>
                <div class="field-value"><?= e($email) ?></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-map-marker-alt"></i>
                  State
                </div>
                <div class="field-value"><?= e($state) ?></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-map"></i>
                  LGA
                </div>
                <div class="field-value"><?= e($lga) ?></div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-phone"></i>
                  Phone Number
                </div>
                <div class="field-value"><?= e($phone) ?></div>
              </div>
            </div>
            <div class="col-12">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-home"></i>
                  Address
                </div>
                <div class="field-value"><?= e($address) ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-briefcase"></i>
                  Occupation
                </div>
                <div class="field-value"><?= e($occupation) ?></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-birthday-cake"></i>
                  Date of Birth
                </div>
                <div class="field-value"><?= e($dob) ?></div>
              </div>
            </div>
            <div class="col-12">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-users"></i>
                  Family
                </div>
                <div class="field-value"><?= e($family) ?></div>
              </div>
            </div>
            <div class="col-12">
              <div class="field-group">
                <div class="field-label">
                  <i class="fas fa-info-circle"></i>
                  Biography
                </div>
                <div class="field-value bio"><?= nl2br(e($bio)) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bank Details -->
      <div class="profile-card loading">
        <div class="card-header">
          <h2 class="card-title">
            <i class="fas fa-university"></i>
            Bank Details
          </h2>
        </div>
        <div class="card-body">
          <?php if ($found): ?>
            <?php
              $bankStmt = $conn->prepare("SELECT bank_name, bank_account, bank_balance FROM bank_details WHERE u_id = ?");
              if ($bankStmt) {
                  $bankStmt->bind_param("i", $id);
                  if ($bankStmt->execute()) {
                      $bankStmt->bind_result($bank_name, $bank_account, $bank_balance);
                      $hasRows = false;
                      while ($bankStmt->fetch()) {
                          $hasRows = true;
            ?>
                          <div class="bank-card">
                            <div class="row g-3">
                              <div class="col-md-4">
                                <div class="bank-field">
                                  <div class="bank-label">Bank Name</div>
                                  <div class="bank-value"><?= e($bank_name) ?></div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="bank-field">
                                  <div class="bank-label">Account Number</div>
                                  <div class="bank-value"><?= e($bank_account) ?></div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="bank-field">
                                  <div class="bank-label">Balance</div>
                                  <div class="bank-value">₦<?= number_format((float)$bank_balance, 2) ?></div>
                                </div>
                              </div>
                            </div>
                          </div>
            <?php
                      }
                      if (!$hasRows) {
                          echo '<div class="no-data"><i class="fas fa-info-circle me-2"></i>No bank records found.</div>';
                      }
                  } else {
                      echo '<div class="no-data text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Unable to load bank details.</div>';
                  }
                  $bankStmt->close();
              } else {
                  echo '<div class="no-data text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Unable to load bank details.</div>';
              }
            ?>
          <?php else: ?>
            <div class="no-data"><i class="fas fa-info-circle me-2"></i>No bank records found.</div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>