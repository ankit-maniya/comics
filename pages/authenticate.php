<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../database/db_user.php');
echo 'Hello';
$user = new User();
$user->setLoginEmail($_POST["login_email"]);
$user->setLoginPassword($_POST["login_password"]);
echo $user->getLoginEmail();
$user->authenticateUser();
echo $user;
if (count($user->getLoginErrors()) > 0) {
    $errorMessages = implode('<br>', $user->getLoginErrors());
    header("Location: login.php?error=$errorMessages");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>
