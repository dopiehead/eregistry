<?php

require_once '../engine/auth.php';

$auth = new Auth( new Database());

if (!$auth->isLoggedIn()) {
    header('Location: ../getstarted.php');
    exit;
}
?>

<h2>Welcome, User ID <?= $auth->getUserId(); ?>!</h2>
<a href="../engine/logout.php">Logout</a>
