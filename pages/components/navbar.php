<nav>
    <div class="my-container">
        <ul>
            <li class="<?php echo $activeTab == "" ? "active" : ""; ?>"><a href="<?php echo Path::getDomainUri(); ?>">Home</a></li>
            <li class="<?php echo $activeTab == "comics" ? "active" : ""; ?>"><a href="<?php echo Path::getDomainUri(); ?>pages/comics.php">Comics</a></li>
            <li class="<?php echo $activeTab == "cart" ? "active" : ""; ?>"><a href="<?php echo Path::getDomainUri(); ?>pages/cart.php">Cart</a></li>
            <li class='<?php echo $activeTab == "login" ? "active" : ""; ?>'><a href="<?php echo Path::getDomainUri(); ?>pages/login.php">Login</a></li>
            <li class='<?php echo $activeTab == "admin-add-comics" ? "active" : ""; ?>'><a href="<?php echo Path::getDomainUri(); ?>pages/admin/comics/add_comics.php">Add Comics</a></li>
            <li class='<?php echo $activeTab == "admin-add-genres" ? "active" : ""; ?>'><a href="<?php echo Path::getDomainUri(); ?>pages/admin/genres/add_genres.php">Add Genres</a></li>
        </ul>
    </div>
</nav>