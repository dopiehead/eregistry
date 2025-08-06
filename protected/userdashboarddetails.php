<?php
include("contents/permission.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
    <?php
    $getuserinfo = $conn->prepare("SELECT * FROM user_profile WHERE pin = ? ");
    $getuserinfo->bind("i",$_SESSION['next_of_kin_pin']);
    ?>
    </div>
</body>
</html>