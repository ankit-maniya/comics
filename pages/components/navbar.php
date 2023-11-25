<nav>
    <div class="container">
        <ul>
            <li class="<?php echo $activeTab == "" ? "active" : ""; ?>"><a href="<?php echo Path::getDomainUri(); ?>">Home</a></li>
            <li class="<?php echo $activeTab == "comics" ? "active" : ""; ?>"><a href="<?php echo Path::getDomainUri(); ?>pages/comics.php">Comics</a></li>
            <li class="<?php echo $activeTab == "checkout" ? "active" : ""; ?>"><a href="<?php echo Path::getDomainUri(); ?>pages/checkout.php">checkout</a></li>
            <li class="<?php echo $activeTab == "cart" ? "active" : ""; ?>"><a href="<?php echo Path::getDomainUri(); ?>pages/cart.php">Cart</a></li>
            <li class='<?php echo $activeTab == "login" ? "active" : ""; ?>'><a href="<?php echo Path::getDomainUri(); ?>pages/login.php">Login</a></li>
        </ul>
    </div>
</nav>