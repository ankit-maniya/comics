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
require_once('../database/db_cart.php');


$cart = new Cart();
$comic = new Comic();
if (isset($_GET['comic_id'])) {
    $comicId = $_GET['comic_id'];
    $comic->find($comicId);
}


$totalPrice = $cart->getTotalPrice();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new DBMaster();

    
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : '';
    $province = isset($_POST['province']) ? $_POST['province'] : '';

    // Inserting data into the database
    $sql = "INSERT INTO tbl_users (user_username, user_email, user_mobile, user_address, user_pincode, user_province) 
            VALUES (:username, :email, :mobile, :address, :pincode, :province)";

    $params = [
        'username' => $username,
        'email' => $email,
        'mobile' => $mobile,
        'address' => $address,
        'pincode' => $pincode,
        'province' => $province
    ];

    $db->sqlStatement($sql)->params($params)->execute();
}

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
                    <form method="post" action="pdf.php">
                        <label for="username">Name:</label>
                        <input type="text" id="username" name="username" required><br><br>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br><br>

                        <label for="mobile">Mobile:</label>
                        <input type="text" id="mobile" name="mobile" required><br><br>

                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea><br><br>

                        <label for="pincode">Pincode:</label>
                        <input type="text" id="pincode" name="pincode" required><br><br>

                        <label for="province">Province:</label>
                        <input type="text" id="province" name="province" required><br><br>
                        <input type="hidden" name="comic_title" value="<?= $comic->getComicTitle() ?>">
                        <input type="hidden" name="comic_price" value="<?= $comic->getComicPrice() ?>">

                        <input type="submit" value="Submit">
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