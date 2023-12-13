<!DOCTYPE html>
<html>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../database/db_master.php');
require_once('../configs/Path.php');
include_once './components/header.php';
require_once('../helpers/ImageHandler.php');
require_once('../database/db_comics.php');



$cart = new Cart();
$comicId = $_GET['comic_id'];

$comic = new Comic();
$comic->find($comicId);

// Assuming you have a function to calculate 
$totalPrice = $cart->getTotalPrice(); 
?>

<body>
    <?php
    $activeTab = "checkout";
    include_once './components/navbar.php';
    ?>

    <header class="bg-light-dark fs-3 text-white py-2 text-center mb-3">
        Comics Store - Checkout
    </header>

    <div class="text-center mt-2">
    <div class="container">
        <h2>Checkout</h2>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Comic Name: <?= $comic->getComicTitle() ?></h5>
                <p>Total Price: <?= $comic->getComicPrice() ?></p>
                <!-- Add payment, shipping details, etc. here -->
                <form method="post" action="process_payment.php">
                    <!-- Payment and shipping form -->
                    <button type="submit" class="btn btn-primary">Confirm Payment</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>