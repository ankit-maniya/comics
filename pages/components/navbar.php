<!-- Ankit Maniya -->
<?php

$currActiveTab = isset($activeTab) ? $activeTab  : "home";
function isActiveTab($currentTab, $expectedTab)
{
    return $currentTab == $expectedTab ? "active" : "";
}

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid text-center">
        <a class="navbar-brand" href="#">Comico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-2" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "home"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "comics"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/comics.php">Comics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "checkout"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/checkout.php">Checkout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "cart"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "login"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "admin-all-comics"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/admin/comics/">Comics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActiveTab($currActiveTab, "admin-all-genres"); ?> rounded" aria-current="page" href="<?php echo Path::getDomainUri(); ?>pages/admin/genres/">Genres</a>
                </li>
            </ul>
        </div>
    </div>
</nav>