<?php
require("engine/auth.php");
$auth = new Auth(new Database());

$conn = $auth->getConnection();
$id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
$u_id = base64_decode($id);
?>
<html lang="en">
<head>
     <?php @include("components/links.php") ?>
     <link rel="stylesheet" href="assets/css/user-profile.css">
     <title>Profile</title>
</head>
<body>
<?php @include 'components/navbar.php' ?> 
<?= htmlspecialchars($u_id) ?>
<br><br>
<?php @include 'components/footer.php' ?> 
</body>
</html>