<!DOCTYPE html>
<html>

<?php
require('../database/db_user.php');
require_once('../configs/Path.php');
require_once('../helpers/ImageHandler.php');
require_once('./components/header.php');
require_once('../database/db_comics.php');

$user = new User();
$showLoginForm = !isset($_POST['showSignup']) || ($_POST['showSignup'] == 0);
$showSignupForm = isset($_POST['showSignup']) && ($_POST['showSignup'] == 1);


$isLoginFormSubmitted = ($showLoginForm && $_SERVER["REQUEST_METHOD"] == "POST");


$isSignupFormSubmitted = ($showSignupForm && $_SERVER["REQUEST_METHOD"] == "POST");


// if ($isLoginFormSubmitted) {
//     $user->setUserId($_POST["login_username"]);
//     $user->setPassword($_POST["login_password"]);

//     if (empty($user->getErrors())) {
//         echo 'Login Done';
//     }
// } elseif ($isSignupFormSubmitted) {
//     // $user->setUserId($_POST["user_name"]);
//     // $user->setName($_POST["user_name"]);
//     // $user->setEmail($_POST["user_email"]);
//     // $user->setType($_POST["user_type"]);
//     // $user->setPassword($_POST["user_password"]);

//     // $hashedPassword = password_hash($_POST["user_password"], PASSWORD_DEFAULT);
//     // // $user->setPassword($hashedPassword);
//     // if (empty($user->getErrors())) {
//     //     $user->insert();
//     // }
// }
?>

<body>
    <header>
        Comics Store - Login Page
    </header>
    <?php
    $activeTab = "login";
    include_once './components/navbar.php';
    ?>

    <div class="my-container mb-5">
        <h1><?php echo $showLoginForm ? 'Login' : 'Sign Up'; ?></h1>

        <?php if ($showLoginForm): ?>
            <form method="post" action="login.php">
                <label for="login_username">Username:</label>
                <input type="text" id="login_username" name="login_username"><br><br>

                <label for="login_password">Password:</label>
                <input type="password" id="login_password" name="login_password"><br><br>

                <input type="submit" value="Login">
            </form>
            <form method="post">
                <input type="hidden" name="showSignup" value="1">
                <input type="submit" value="Don't have an account? Sign Up here">
            </form>
        <?php endif; ?>

        <?php if ($showSignupForm): ?>
            <form method="post" action="register.php">
                <?php
                if ($isSignupFormSubmitted) {
                    echo implode('', $user->getErrors());
                }
                ?>
                <label for="user_name">Username:</label>
                <input type="text" id="user_name" name="user_name"><br><br>
                <label for="user_email">Email:</label>
                <input type="text" id="user_email" name="user_email"><br><br>

                <label for="user_type">Type:</label>
                <select id='user_type' name='user_type'>
                    <?php
                    $user_types = ["Admin", "Customer"];
                    foreach ($user_types as $type) {
                        echo "<option value='$type'>$type</option>";
                    }
                    ?>
                </select>
                <br><br>
                <label for="user_password">Password:</label>
                <input type="password" id="user_password" name="user_password"><br><br>

                <input type="submit" value="Sign Up">
            </form>
            <form method="post">
                <input type="hidden" name="showSignup" value="0">
                <input type="submit" value="Back to Login">
            </form>
        <?php endif; ?>
    </div>
    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>
