<!DOCTYPE html>
<html>
<?php
require_once('../database/db_master.php');
require_once('../configs/Path.php');
include_once './components/header.php';
require_once('../helpers/ImageHandler.php');
require_once('../database/db_comics.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieving cart items stored in the session
$cartItems = $_SESSION['cart'] ?? [];

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

        <!-- Order summary -->
        <h2 class="text-white">Your Order</h2>
        <table>
            <tr>
                <th>Product</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($cartItems as $item) : ?>
                <tr>
                    <td><?= $item['product'] ?> × <?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td>Subtotal</td>
                <td>$<?= number_format($subTotal, 2) ?></td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>$<?= number_format($shippingRate, 2) ?></td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>$<?= number_format($subTotal * $taxRate, 2) ?></td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>$<?= number_format($total, 2) ?></strong></td>
            </tr>
        </table>

        <!-- Form for capturing user details -->
        <div class="container my-5">
            <div class="bg-hevy-dark p-5 rounded shadow-lg">
                <h2 class="mb-3">Billing Information</h2>
                <form class="text-dark" method="POST" action="purchase.php">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="firstname" name="firstname" value="" placeholder="">
                        <label for="firstname">First Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lastname" name="lastname" value="" placeholder="">
                        <label for="lastname">Last Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="company" name="company" value="" placeholder="">
                        <label for="company">Company Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="country" name="country" value="" placeholder="">
                        <label for="country">Country / Region</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="street" name="street" value="" placeholder="">
                        <label for="street">Street Address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="apartment" name="apartment" value="" placeholder="">
                        <label for="apartment">Apartment, Suite, Unit, etc.</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="city" name="city" value="" placeholder="">
                        <label for="city">City</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="province" name="province" value="Ontario" placeholder="">
                        <label for="province">Province</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="postalcode" name="postalcode" placeholder="+1 226-888-5555">
                        <label for="postalcode">Postal Code</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="+1 226-888-5555">
                        <label for="phone">Phone</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                        <label for="email">Email address</label>
                    </div>

                    <!-- Other input fields for payment details, etc. -->

                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button class="btn btn-orange btn-lg" type="submit" value="order_submit">Place Order</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>