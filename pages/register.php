<?php
require('../database/db_user.php');
var_dump($_POST);
$user = new User();
$user->setName($_POST["user_name"]);
$user->setEmail($_POST["user_email"]);
$user->setType($_POST["user_type"]);
$user->setPassword($_POST["user_password"]);

if (count($user->getErrors()) > 0) {
    $errorMessages = implode('<br>', $user->getErrors());
    header("Location: login.php?error=$errorMessages");
    exit();
} else {
    if ($user->insert()) {
        header("Location: ../index.php?success=User successfully registered!");
        exit();
    } else {
        $errorMessages = "Failed to insert user into the database.";
        header("Location: login.php?error=$errorMessages");
        exit();
    }
}
