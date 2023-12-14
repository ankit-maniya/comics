<!DOCTYPE html>
<html>

<?php
require_once('./configs/Path.php');
include_once './pages/components/header.php';

?>

<body>
    <?php
    $activeTab = "home";
    include_once './pages/components/navbar.php';
    ?>
    <header class="bg-light-dark fs-3 text-white py-2 text-center mb-3">
        Comics Store - Home Page
    </header>
    <section class="text-center mt-2">
        <h2 class="fs-1 text-white">Welcome to Comics Store</h2>
        <p class="fs-4 text-white">Explore a world of thrilling adventures and captivating stories with our vast collection of comics!</p>
    </section>
    <section class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <img src="./pages/admin/images/all.jpg" alt="Featured Comic" class="img-fluid" />
            </div>
            <div class="col-md-6">
                <h3 class="fs-2 text-white">Featured Comic of the Month</h3>
                <p class="fs-4 text-white">Don't miss our featured comic for this month! Immerse yourself in an extraordinary tale filled with action, suspense, and wonder.</p>
                <a href="./pages/comics.php" class="navbar nav-link active rounded">Explore More Comics</a>
            </div>
        </div>
    </section>
    <section class="container mt-4">
        <h2 class="fs-2 text-white">Popular Genres</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="./pages/admin/images/action_image.jpg" class="card-img-top" alt="Action Genre">
                    <div class="card-body">
                        <h5 class="card-title">Action</h5>
                        <p class="card-text">Dive into heart-pounding action and adrenaline-pumping adventures.</p>
                        <a href="./pages/comics.php?genre_id=1" class="navbar nav-link active rounded">Explore Action Comics</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="./pages/admin/images/dragon_riders.jpg" class="card-img-top" alt="Fantasy Genre">
                    <div class="card-body">
                        <h5 class="card-title">Fantasy</h5>
                        <p class="card-text">Discover magical realms, mythical creatures, and epic quests.</p>
                        <a href="./pages/comics.php?genre_id=3" class="navbar nav-link active rounded">Explore Fantasy Comics</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="./pages/admin/images/sci_fi_image.jpg" class="card-img-top" alt="Sci-Fi Genre">
                    <div class="card-body">
                        <h5 class="card-title">Sci-Fi</h5>
                        <p class="card-text">Journey into the future with mind-bending science fiction adventures.</p>
                        <a href="./pages/comics.php?genre_id=4" class="navbar nav-link active rounded"> Explore Sci-Fi Comics</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br /><br /><br />
    <?php
    include_once './pages/components/footer.php';
    ?>

</body>

</html>