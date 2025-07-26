<?php include("engine/checkSession.php");
error_reporting(E_ALL ^ E_NOTICE);
isset($_GET['details']) && !empty($_GET['details']) ? $details = filter_var($_GET['details']) : null;
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

<div class='container px-3 py-2 back-button'>
    <a class='text-white text-decoration-none' onclick="history.go(-1)"><i class='fa fa-arrow-left'></i> Back</a>
</div>

<div class='auth-home'>
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
        <p><a href="forget-password">Forgot password</a></p>
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
</div>

<input type="text" id="url_details" value="<?= htmlspecialchars($details) ?>">


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function() {
    // jQuery UI tabs initialization with fade animation
    $("#auth-tabs").tabs({
        activate: function(event, ui) {
            ui.newPanel.hide().fadeIn(300);
        }
    });
    // Handle user type button selection (outside form submission)
    // $(".btn-outline-secondary").on("click", function(e) {
    //     e.preventDefault();
    //     const userType = $(this).attr("id");
    //     $("#user_type").val(userType);
    //     $(this).addClass("btn-secondary text-white")
    //            .siblings().removeClass("btn-secondary text-white");
    // });

    // LOGIN HANDLER
    $('#login').on('submit', function(e) {
        e.preventDefault();

        $(".spinner-border").show();
        $(".signin-note").hide();
        $('.btn-custom').prop('disabled', true);

        const email = $("#login-email").val();
        const password = $("#login-password").val();
        const url = $("#url_details").val().trim();

        $.ajax({
            type: "POST",
            url: "engine/signin-process.php",
            data: { email, password },
            dataType: "json",
            success: function(response) {
                $(".spinner-border").hide();
                $(".signin-note").show();
                $('.btn-custom').prop('disabled', false);

                if (response.status === "success") {
                    if (url) {
                        window.location.href = url;
                    } else {
                                window.location.href = "protected/dashboard.php";                      
                    }
                } else {
                    $("#error-message").text(response.message);
                }
            },
            error: function() {
                $(".spinner-border").hide();
                $(".signin-note").show();
                $('.btn-custom').prop('disabled', false);
                $("#error-message").text("Something went wrong. Please try again.");
            }
        });
    });

    // SIGNUP HANDLER
    $('#signup').on('submit', function(e) {
        e.preventDefault();

        if ($('#signup-password').val() !== $('#signup-confirm').val()) {
            alert("Passwords do not match!");
            return;
        }

        $(".spinner-border").show();
        $(".signup-note").hide();
        $('.btn-custom').prop('disabled', true);

        const formData = {
            name: $("#signup-name").val(),
            email: $("#signup-email").val(),
            password: $("#signup-password").val(),
            confirm: $("#signup-confirm").val(),
            user_type: $("#user_type").val() || 'User' // optional fallback
        };

        $.ajax({
            type: "POST",
            url: "engine/signup-process.php",
            data: formData,
            dataType: "json",
            success: function(response) {
                $(".spinner-border").hide();
                $(".signup-note").show();
                $('.btn-custom').prop('disabled', false);

                if (response.status === "success") {
                    swal({
                        icon: "success",
                        title: "Registration Successful",
                        text: response.message
                    });
                    $('#signup')[0].reset();
                } else {
                    swal({
                        icon: "warning",
                        title: "Registration Failed",
                        text: response.message
                    });
                }
            },
            error: function(err) {
                $(".spinner-border").hide();
                $(".signup-note").show();
                $('.btn-custom').prop('disabled', false);
                swal({
                    icon: "error",
                    title: "Registration Failed",
                    text: err.responseText || "Something went wrong"
                });
            }
        });
    });
});
</script>


</body>
</html>