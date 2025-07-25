<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login/Signup Toggle</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="assets/css/getstarted.css">
</head>
<body>

<div class="auth-container">
  <div id="auth-tabs" class="auth-tabs px-2">
    <ul>
      <li><a href="#login-form">Login</a></li>
      <li><a href="#signup-form">Sign Up</a></li>
    </ul>
    <div id="login-form">
      <form id="login">
        <div>
          <label for="login-email">Email</label>
          <input type="email" id="login-email" placeholder="Enter your email" required>
        </div>

        <div>
          <label for="login-password">Password</label>
          <input type="password" id="login-password" placeholder="Enter your password" required>
        </div>

        <button type="submit">Login</button>
      </form>
    </div>
    <div id="signup-form">
      <form id="signup">
        <div>
          <label for="signup-name">Full Name</label>
          <input type="text" id="signup-name" placeholder="Enter your full name" required>
        </div>

        <div>
          <label for="signup-email">Email</label>
          <input type="email" id="signup-email" placeholder="Enter your email" required>
        </div>

        <div>
          <label for="signup-password">Password</label>
          <input type="password" id="signup-password" placeholder="Create a password" required>
        </div>

        <div>
          <label for="signup-confirm">Confirm Password</label>
          <input type="password" id="signup-confirm" placeholder="Confirm your password" required>
        </div>

        <button type="submit">Create Account</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
  $(function() {
    $("#auth-tabs").tabs({
      activate: function(event, ui) {
        // Add animation class to new panel
        ui.newPanel.hide().fadeIn(300);
      }
    });

    // Simulated submit handler
    $('#login').on('submit', function(e) {
      e.preventDefault();
      alert("Logging in with: " + $('#login-email').val());
    });

    $('#signup').on('submit', function(e) {
      e.preventDefault();
      if ($('#signup-password').val() !== $('#signup-confirm').val()) {
        alert("Passwords do not match!");
        return;
      }
      alert("Signing up: " + $('#signup-email').val());
    });
  });
</script>

</body>
</html>