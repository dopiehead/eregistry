<?php

require_once '../engine/auth.php';

$auth = new Auth(new Database());

if (!$auth->isLoggedIn()) {
    header('Location: ../getstarted.php');
    exit;
} else {
    include("contents/userDetails.php");
}
?>