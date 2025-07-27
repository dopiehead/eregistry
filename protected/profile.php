<?php

require_once '../engine/auth.php';

$auth = new Auth( new Database());

if (!$auth->isLoggedIn()) {
    header('Location: ../getstarted.php');
    exit;
}

else{
    include("contents/userDetails.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title>Profile</title>
    <?php include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/profile.css">

</head>
<body>
    <!-- Sidebar -->
     <?php @include("components/sidebar.php") ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
       <?php @include("components/topbar.php") ?>

    </div>

</div>