<html lang="en">
<head>
    <?php include("components/links.php") ?>
    <title>Forgot Password</title>
    <style>
        .forgot-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 80px;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php @include 'components/navbar.php' ?>  

    <div class="container">
        <div class="forgot-container">
            <h4 class="text-center mb-3">Forgot Password</h4>
            <form id='forgotForm' method="post">
                <div class="mb-3 mt-5">
                    <label for="email" class="form-label">Enter your email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="e.g. you@example.com" required>
                </div>

                <div class="d-grid">
                    <button name="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
            <div id="responseMessage"></div>
        </div>
    </div>

    <?php @include 'components/footer.php' ?>  
    <script src='assets/js/forgot-password.js'></script>
</body>
</html>
