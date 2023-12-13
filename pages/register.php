<?php
require('../database/db_user.php');
$user = new User();
// $user->setUserId($_POST["user_id"]);
$user->setName($_POST["user_name"]);
$user->setEmail($_POST["user_email"]);
$user->setType($_POST["user_type"]);
$user->setPassword($_POST["user_password"]);

if (count($user->getErrors()) > 0) {
    $errorMessages = implode('<br>', $user->getErrors());
    header("Location: login.php?error=$errorMessages");
    exit();
} else {
    $user->insert();
    header("Location: ../index.php?success=User successfully registered!");
    exit();
}
