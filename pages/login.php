<!-- Pratik Boghani -->
<?php
    require('../dal/user.php');
    $user=new User(array_merge(
            [
                "user_name"=>"",
                "user_email"=>"",
                "user_type"=>"",
                "user_password"=>"",
            ],$_POST
        ));
        
    if(count($user->getErrors())>0)
    {
        foreach($user->getErrors() as $error){
            echo $error;
        }
        
        echo '<br><a href="login.php">Go Back</a>';
    }
    else
    {
       $user->insert();
       header("Location: comics.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Comics Store
        </title>
        <link rel="stylesheet" href="../public/css/index.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <header>
            Comics Store - Login Page
        </header>
        <nav>
            <div class="container">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="comics.php">Comics</a></li>
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
        <form method="post" action="login.php">
            <label for="user_name">Username:</label>
            <input type="text" id="user_name" name="user_name"><br><br>
            
            <label for="user_email">Email:</label>
            <input type="text" id="user_email" name="user_email"><br><br>
            
            <label for="user_type">Type:</label>
            <!-- <input type="text" id="user_type" name="user_type"><br><br> -->
            <select  id='user_type' name='user_type' >
                <?php
                    $user_types=["Admin","Customer"];
                    foreach($user_types as $type)
                    {
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
    <br />
    <br />
    <br />

    <footer>
            <div class="container">
                Developed by Duel Ninja - Comics Group - 2023
            </div>
    </footer>
</body>
</html>
