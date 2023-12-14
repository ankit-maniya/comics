<!DOCTYPE html>
<html>
<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../configs/Path.php');
include_once './components/header.php';
require_once('../helpers/ImageHandler.php');
require_once('../database/db_comics.php');
include_once('../database/db_master.php');
require_once('../database/db_cart.php');

$cart = new Cart();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $comicId = $_GET['comic_id'];

    $comic = new Comic();
    $comic->find($comicId);

    if ($comic->getComicId() > 0) {
        $cart->addToCart($comic, 1);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $comicId = $_POST['comic_id'];
    $newQuantity = $_POST['new_quantity'];

    $cart->updateQuantity($comicId, $newQuantity);
}



 ?>

<body>
    <?php
    $activeTab = "cart";
    include_once './components/navbar.php';
    ?>

    <header class="bg-light-dark fs-3 text-white py-2 text-center mb-3">
        Comics Store - Cart Page
    </header>

    <div class="container">

    <h2>Shopping Cart</h2>
        <?php
        $cartItems = $cart->getCartItems();
        if (empty($cartItems)) {
            echo "<p>Your cart is empty.</p>";
        } else {
            foreach ($cartItems as $item) {
                $comic = $item['item'];
                $imgUri = ImageHandler::getImgUri($comic->getComicImage());
                echo "
                <div class='card mb-2'>
                    <div class='row g-0'>
                        <div class='col-md-2'>
                            <img src='{$imgUri}' class='img-fluid rounded-start' alt='{$comic->getComicTitle()}'>
                        </div>
                        <div class='col-md-8'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$comic->getComicTitle()}</h5>
                                <h6 class='card-subtitle mb-2 text-body-secondary'>{$comic->getGenreName()}</h6>
                                <div>
                                    <label class='fw-bold'>Price:</label>
                                    <span class='badge text-bg-primary'>\${$comic->getComicPrice()}</span>
                                </div>
                                <div>
                                    <label class='fw-bold'>Quantity:</label>
                                    <span class='badge text-bg-primary'>$item[quantity]</span>
                                </div>
                                <form method='post' action='cart.php?comic_id={$_GET['comic_id']}'>
                                   <input type='hidden' name='comic_id' value='{$comic->getComicId()}'>
                                   <input type='number' name='new_quantity' value='{$item['quantity']}' min='1'>
                                   <button type='submit' name='update_quantity' class='btn btn-primary'>Update Quantity</button>
                                </form>
                                <form method='post' action='cart.php?remove_from_cart={$comic->getComicId()}'>
                                    <button type='submit' name='remove_from_cart' class='btn btn-danger'>Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }

            echo "
            <div class='text-end'>
                <h4>Total Items: {$cart->getTotalItems()}</h4>
                <h4>Total Price: \${$cart->getTotalPrice()}</h4>
                <form method='post' action='checkout.php?comic_id={$_GET['comic_id']}'>
                    <button type='submit' name='chekout' class='btn btn-primary'>Proced to checkout</button>
                </form>
            </div>
            ";
        }
        ?>
    </div>
    

    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>