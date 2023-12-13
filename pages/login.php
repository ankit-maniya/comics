<!DOCTYPE html>
<html>

<?php
require_once('../database/db_user.php');
require_once('../configs/Path.php');
require_once('../helpers/ImageHandler.php');
require_once('./components/header.php');
require_once('../database/db_comics.php');

$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';
$successMessage = isset($_GET['success']) ? $_GET['success'] : '';

$user = new User();
$showLoginForm = !isset($_POST['showSignup']) || ($_POST['showSignup'] == 0);
$showSignupForm = isset($_POST['showSignup']) && ($_POST['showSignup'] == 1);


$isLoginFormSubmitted = ($showLoginForm && $_SERVER["REQUEST_METHOD"] == "POST");
$isSignupFormSubmitted = ($showSignupForm && $_SERVER["REQUEST_METHOD"] == "POST");

?>

<body>
    <?php
    $activeTab = "login";
    require_once('./components/navbar.php');
    ?>
    <header class="bg-light-dark fs-3 text-white py-2 text-center mb-5">
        Comics Store - <?php echo $showLoginForm ? 'Login' : 'Sign Up'; ?> Page
    </header>

    <div class="w-75 mx-auto mt-2 mb-5 py-2 bg-hevy-dark rounded shadow-lg">
        <div class="w-75 mx-auto my-5">
            <h1 class="text-white font-bold">
                Hello,
                <p>
                    <?php echo $showLoginForm ? "Welcome back!" : 'Form is Right Here!'; ?>
                </p>
            </h1>

            <?php if ($showLoginForm) : ?>
                <?php
                if ($errorMessage) {
                    echo $errorMessage;
                }
                ?>
                <form class="text-dark" method="post" action="authenticate.php">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="login_email" name="login_email" placeholder="name@example.com">
                        <label for="login_email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
                        <label for="login_password">Password</label>
                    </div>

                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button class="btn btn-orange btn-lg" type="submit" value="Login">Login</button>
                    </div>
                </form>

                <form class="w-100 mt-3" method="post">
                    <input type="hidden" name="showSignup" value="1">
                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button class="btn btn-link text-white" type="submit" value="Don't have an account? Sign Up here">Don't have an account? Sign Up</button>
                    </div>
                </form>
            <?php endif; ?>

            <?php if ($showSignupForm) : ?>
                <?php
                if ($errorMessage) {
                    echo $errorMessage;
                }
                ?>

                <?php if (!empty($successMessage)) : ?>
                    <p style="color: green;"><?php echo $successMessage; ?></p>
                <?php endif; ?>

                <form class="text-dark" method="post" action="register.php">
                    <?php
                    if ($isSignupFormSubmitted) {
                        echo implode('', $user->getErrors());
                    }
                    ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="user_name" name="user_name">
                        <label for="user_name">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="name@example.com">
                        <label for="user_email">Email address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="user_type" name="user_type">
                            <?php
                            $user_types = ["Customer", "Admin"];
                            foreach ($user_types as $type) {
                                echo "<option value='$type'>$type</option>";
                            }
                            ?>
                        </select>
                        <label for="user_type">User Type</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
                        <label for="user_password">Password</label>
                    </div>

                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button class="btn btn-orange btn-lg" type="submit" value="Sign Up">Sign Up</button>
                    </div>
                </form>
                <form class="w-100 mt-3" method="post">
                    <input type="hidden" name="showSignup" value="0">
                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button class="btn btn-link text-white" type="submit" value="Back to Login">Back to Login</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php
    require_once('./components/footer.php');
    ?>
</body>

</html>