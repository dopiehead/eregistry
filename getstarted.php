<?php include("engine/checkSession.php");
error_reporting(E_ALL ^ E_NOTICE);
isset($_GET['details']) && !empty($_GET['details']) ? $details = filter_var($_GET['details'], FILTER_SANITIZE_STRING) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login/Signup Toggle</title>
  <?php @include("components/links.php") ?>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="assets/css/getstarted.css">
</head>
<body class='bg-light'>

<div class='container px-3 py-2 back-button d-flex justify-content-between'>
    <a class='text-white text-decoration-none' onclick="history.go(-1)"><i class='fa fa-arrow-left'></i> Back</a>

    <a class='text-white text-decoration-none' href="index.php">Home <i class='fa fa-arrow-right'></i> </a>
</div>

<div class='auth-home'>
<div class="auth-container">
  <div id="auth-tabs" class="auth-tabs px-2">
    <ul>
      <li><a href="#login-form">Login</a></li>
      <li><a href="#signup-form">Sign Up</a></li>
    </ul>
    <div id="login-form">


<!-- log in form -->
      <form id="login">
      <?php
$loginFields = [
    [
        'label' => 'Email', 'type' => 'email',
        'name' => 'login-email',  'id' => 'login-email',   'placeholder' => 'Enter your email'
    ],
    [
        'label' => 'Password',  'type' => 'password',   'name' => 'login-password',
        'id' => 'login-password',  'placeholder' => 'Enter your password'
    ]
];
?>

<?php foreach ($loginFields as $field): ?>
  <div>
    <label for="<?= htmlspecialchars($field['id']) ?>"><?= htmlspecialchars($field['label']) ?></label>
    <input type="<?= htmlspecialchars($field['type']) ?>"  name="<?= htmlspecialchars($field['name']) ?>"
      id="<?= htmlspecialchars($field['id']) ?>"  placeholder="<?= htmlspecialchars($field['placeholder']) ?>" required
    >
  </div>
<?php endforeach; ?>

        <p><a href="forgot-password.php">Forgot password</a></p>
        <button class='btn-custom' type="submit"><span class='signin-note'></span>Login  <span style='display:none;' class='spinner-border text-light'></span></button>       
      </form>
     
      <div class='mt-3 text-danger text-center w-100' id="error-message"></div>
    </div>
   
<!-- sign up form -->

    <div id="signup-form">
      <form id="signup">
      <?php
$fields = [
    [
        'label' => 'Full Name', 'type' => 'text',  'name' => 'signup-name',
        'id' => 'signup-name', 'placeholder' => 'Enter your full name'
    ],
    [
        'label' => 'Email', 'type' => 'email',   'name' => 'signup-email',
        'id' => 'signup-email', 'placeholder' => 'Enter your email'
    ],
    [
        'label' => 'Password', 'type' => 'password', 'name' => 'signup-password',
        'id' => 'signup-password','placeholder' => 'Create a password'
    ],
    [
        'label' => 'Confirm Password', 'type' => 'password', 'name' => 'signup-confirm',
        'id' => 'signup-confirm', 'placeholder' => 'Confirm your password'
    ],
];
?>

<?php foreach ($fields as $field): ?>
  <div>
    <label for="<?= htmlspecialchars($field['id']) ?>"><?= htmlspecialchars($field['label']) ?></label>
    <input 
      type="<?= htmlspecialchars($field['type']) ?>" 
      name="<?= htmlspecialchars($field['name']) ?>" 
      id="<?= htmlspecialchars($field['id']) ?>" 
      placeholder="<?= htmlspecialchars($field['placeholder']) ?>" 
      required
    >
  </div>
<?php endforeach; ?>

        <button class='btn-custom' type="submit"><span class='signup-note'>Create Account</span> <span style='display:none;' class='spinner-border text-light'></span></button>
      </form>
      <div class='mt-3 text-danger text-center w-100' id="error-message"></div>
    </div>
  </div>
</div>
</div>

<input type="text" id="url_details" value="<?= htmlspecialchars($details) ?>">
<?php @include 'components/footer.php' ?>  
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src='assets/js/getstarted.js'></script>

</body>
</html>