<?php

require_once '../engine/auth.php';

$auth = new Auth(new Database());

if (!$auth->isLoggedIn()) {
    header('Location: ../getstarted.php');
    exit;
} else {
    include("contents/userDetails.php");
    $extension = strtolower(pathinfo($image,PATHINFO_EXTENSION));
    $image_extension  = array('jpg','jpeg','png'); 
}
