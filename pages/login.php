<!DOCTYPE html>
<html>

<?php
require_once('../configs/Path.php');
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

    <div class="my-container mb-5">
        <!-- Login form -->
        <h1>Login</h1>
        <form method="post" action="login.php">
            <label for="login_username">Username:</label>
            <input type="text" id="login_username" name="login_username"><br><br>

            <label for="login_password">Password:</label>
            <input type="password" id="login_password" name="login_password"><br><br>

            <input type="submit" value="Login">
        </form>

        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // For login form
            if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
                $username = $_POST['login_username'];
                $password = $_POST['login_password'];
                
                // Validate username and password
                if (empty($username)) {
                    echo "Username is required.<br>";
                }
                if (empty($password)) {
                    echo "Password is required.<br>";
                }
                if (!empty($username) && !empty($password)) {
                    // Process the login
                    // Example: Check the username and password against a database
                }
            }
        }
        ?>

        <!-- Sign Up form -->
        <h1>Sign Up</h1>
        <form method="post" action="login.php">
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

        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // For sign-up form
            if (isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_type']) && isset($_POST['user_password'])) {
                $username = $_POST['user_name'];
                $email = $_POST['user_email'];
                $userType = $_POST['user_type'];
                $password = $_POST['user_password'];
                
                // Validate input data
                if (empty($username)) {
                    echo "Username is required.<br>";
                }
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "Valid email is required.<br>";
                }
                if (empty($userType) || !in_array($userType, ["Admin", "Customer"])) {
                    echo "Valid user type is required.<br>";
                }
                if (empty($password)) {
                    echo "Password is required.<br>";
                }
                if (!empty($username) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($userType) && in_array($userType, ["Admin", "Customer"]) && !empty($password)) {
                    // Process the sign-up
                    // Example: Insert the new user into a database
                }
            }
        }
        ?>
    </div>

    <?php
    include_once './components/footer.php';
    ?>

</body>

</html>
