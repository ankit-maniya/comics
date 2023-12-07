<?php
require('../database/db_user.php');

$user = new User();
$user->setEmail($_POST["login_email"]);
$user->setPassword($_POST["login_password"]);
$user->authenticateUser();

if (count($user->getErrors()) > 0) {
    $errorMessages = implode('<br>', $user->getErrors());
    header("Location: login.php?error=$errorMessages");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
