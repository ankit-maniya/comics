<nav>
    <div class="container">
        <ul>
            <li class="<?php echo $activeTab == "" ? "active" : ""; ?>"><a href="../index.php">Home</a></li>
            <li class="<?php echo $activeTab == "comics" ? "active" : ""; ?>"><a href="comics.php">Comics</a></li>
            <li class="<?php echo $activeTab == "cart" ? "active" : ""; ?>"><a href="cart.php">Cart</a></li>
            <li class='<?php echo $activeTab == "login" ? "active" : ""; ?>'><a href="login.php">Login</a></li>
        </ul>
    </div>
</nav>