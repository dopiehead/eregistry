<?php
require_once '../engine/auth.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    header('Location: ../getstarted.php');
    exit;
}
?>

<h2>Welcome, User ID <?= $auth->getUserId(); ?>!</h2>
<a href="logout.php">Logout</a>
