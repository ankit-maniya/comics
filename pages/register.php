<?php
require('../database/db_user.php');
$user = new User();
$user->setUserId($_POST["user_id"]);
$user->setName($_POST["user_name"]);
$user->setEmail($_POST["user_email"]);
$user->setType($_POST["user_type"]);
$user->setPassword($_POST["user_password"]);

if (count($user->getErrors())>0) {
    foreach($user->getErrors() as $error){
            echo $error;
        }
        echo '<br><a href="login.php">Go Back</a>';}else {
    $user->insert();
    echo "<p>User successfully registered!</p>";
    echo '<a href="login.php">Back to Login</a>';
}  
?>
