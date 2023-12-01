<?php
require('../database/db_user.php');
$user = new User();
$user->setUserId($_POST["user_id"]);
$user->setName($_POST["user_name"]);
$user->setEmail($_POST["user_email"]);
$user->setType($_POST["user_type"]);
$user->setPassword($_POST["user_password"]);

if (empty($user->getErrors())) {
    $user->insert();
    echo "<p>User successfully registered!</p>";
    echo '<a href="login.php">Back to Login</a>';
}  
?>
