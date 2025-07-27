<?php
declare(strict_types=1);

require_once 'auth.php';

$auth = new Auth(new Database());

$auth->logout();

header('Location: ../getstarted.php');
exit;
