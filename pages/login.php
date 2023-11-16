<!DOCTYPE html>
<html>
    <head>
        <title>
            Comics Store
        </title>
        <link rel="stylesheet" href="../public/css/index.css" type="text/css">
    </head>
    <body>
        <header>
            Comics Store - Login Page
        </header>
        <nav>
            <div class="container">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="list.php">Comics</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li  class="active"><a href="#">Login</a></li>
                </ul>
            </div>
        </nav>

    <div class="container">
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
        <form method="post" action="signup.php">
            <label for="signup_username">Username:</label>
            <input type="text" id="signup_username" name="signup_username"><br><br>
            
            <label for="signup_password">Password:</label>
            <input type="password" id="signup_password" name="signup_password"><br><br>
            
            <input type="submit" value="Sign Up">
        </form>
    </div>

    <footer>
            <div class="container">
                @ Developed by Duel Ninja - Comics Group - 2023
            </div>
    </footer>
</body>
</html>
