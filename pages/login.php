<!-- Pratik Boghani -->
<?php
require('../dal/user.php');
$user = new User(array_merge(
    [
        "user_name" => "",
        "user_email" => "",
        "user_type" => "",
        "user_password" => "",
    ],
    $_POST
));

if (count($user->getErrors()) > 0) {
    foreach ($user->getErrors() as $error) {
        echo $error;
    }

    echo '<br><a href="login.php">Go Back</a>';
} else {
    $user->insert();
    header("Location: comics.php");
}
?>

<!DOCTYPE html>
<html>

<?php
include_once './components/header.php';
?>

<body>
    <header>
        Comics Store - Login Page
    </header>
    <?php
    $activeTab = "login";
    include_once './components/navbar.php';
    ?>

    <div class="container mb-5">
        <!-- Login form -->
        <h1>Login</h1>
        <form method="post" action="login.php">
            <label for="login_username">Username:</label>
            <input type="text" id="login_username" name="login_username"><br><br>

            <label for="login_password">Password:</label>
            <input type="password" id="login_password" name="login_password"><br><br>

            <input type="submit" value="Login">
        </form>



        <!-- Sign Up form -->
        <h1>Sign Up</h1>
        <form method="post" action="login.php">
            <label for="user_name">Username:</label>
            <input type="text" id="user_name" name="user_name"><br><br>

            <label for="user_email">Email:</label>
            <input type="text" id="user_email" name="user_email"><br><br>

            <label for="user_type">Type:</label>
            <!-- <input type="text" id="user_type" name="user_type"><br><br> -->
            <select id='user_type' name='user_type'>
                <?php
                $user_types = ["Admin", "Customer"];
                foreach ($user_types as $type) {
                    echo "<option value='$type'>$type</option>";
                    echo "<li><a class='dropdown-item' href='#'>Action</a></li>";
                }
                ?>
            </select>
            <br><br>
            <label for="user_password">Password:</label>
            <input type="password" id="user_password" name="user_password"><br><br>

            <input type="submit" value="Sign Up">
        </form>
    </div>

    <?php
    include_once './components/footer.php';
    ?>

</body>

</html>