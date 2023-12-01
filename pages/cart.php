<!DOCTYPE html>
<html>
<?php
require_once('../database/db_master.php');
require_once('../configs/Path.php');
include_once './components/header.php';
require_once('../helpers/ImageHandler.php');
require_once('../database/db_comics.php');

session_start();

// Retrieving cart items stored in the session
$cartItems = $_SESSION['cart'] ?? [];

?>

<body>
    <header>
        Comics Store - Cart Page
    </header>

    <?php
    $activeTab = "cart";
    include_once './components/navbar.php';
    ?>

    <div class="container">

        <?php
    // Initialize or retrieve cart items
    session_start();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Initialize an empty cart
    }

    
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['add_to_cart']) && isset($_GET['comic_id'])) {

        $comicIdToAdd = $_GET['comic_id'];

        
        array_push($_SESSION['cart'], $comicsDetail);
    }
    ?>

    <div class="container mb-5 pb-5">
        <h1 class="text-center">Cart</h1>
        <?php if (empty($_SESSION['cart'])) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <!-- Display cart items -->
            <?php foreach ($_SESSION['cart'] as $cartItem) : ?>
                <div class='card my-3'>
                    <div class='row g-0'>
                        ]
                        <div class='col-md-4'>
                            <img src='<?php echo $cartItem['comic_image']; ?>' class='img-fluid rounded-start' alt='<?php echo $cartItem['comic_title']; ?>'>
                        </div>
                        <div class='col-md-8'>
                            <div class='card-body'>
                                <h5 class='card-title'><?php echo $cartItem['comic_title']; ?></h5>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    </div>

    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>
