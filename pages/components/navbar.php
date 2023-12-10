<!-- Ankit Maniya -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$currActiveTab = isset($activeTab) ? $activeTab  : "home";
function isActiveTab($currentTab, $expectedTab)
{
    return $currentTab == $expectedTab ? "active" : "";
}

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid text-center">
        <a class="navbar-brand" href="#">Comico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-2" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "home"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>">
                        <i class="bi bi-house-door"></i>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "comics"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/comics.php">
                        <i class="bi bi-book"></i>
                        Comics
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "checkout"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/checkout.php">
                        <i class="bi bi-bag-check"></i>
                        Checkout
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "cart"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/cart.php">
                        <i class="bi bi-cart-check"></i>
                        Cart
                    </a>
                </li>
                <?php
                if (!isset($_SESSION["user_type"]) && empty($_SESSION["user_type"])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActiveTab($currActiveTab, "login"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/login.php">
                            <i class="bi bi-person-circle"></i>
                            Login
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "Admin") {
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActiveTab($currActiveTab, "admin-all-comics"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/admin/comics/">
                            <i class="bi bi-book-half"></i>
                            Comics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActiveTab($currActiveTab, "admin-all-genres"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/admin/genres/">
                            <i class="bi bi-card-list"></i>
                            Genres
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php
                if (!empty($_SESSION["user_type"])) {
                ?>
                    <li class="nav-item dropdown dropstart">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION["user_username"]; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo Path::getDomainUri(); ?>pages/logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>