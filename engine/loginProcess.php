<?php
require_once 'engine/auth.php';

$auth = new Auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($email, $password)) {
        echo"1";
        exit;
    } else {
        echo"Invalid email or password";
    }
}
?>


