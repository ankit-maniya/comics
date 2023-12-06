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
        <form method="POST" action="purchase.php">
            <h2>Billing Information</h2>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required><br><br>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required><br><br>

            <label for="company">Company Name:</label>
            <input type="text" id="company" name="company"><br><br>

            <label for="country">Country / Region:</label>
            <input type="text" id="country" name="country" value="Canada" disabled><br><br>

            <label for="street">Street Address:</label>
            <input type="text" id="street" name="street" required><br><br>

            <label for="apartment">Apartment, Suite, Unit, etc.:</label>
            <input type="text" id="apartment" name="apartment"><br><br>

            <label for="city">Town / City:</label>
            <input type="text" id="city" name="city" required><br><br>

            <label for="province">Province:</label>
            <input type="text" id="province" name="province" value="Ontario" disabled><br><br>

            <label for="postalcode">Postal Code:</label>
            <input type="text" id="postalcode" name="postalcode" required><br><br>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required><br><br>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required><br><br>

            <!-- Other input fields for payment details, etc. -->

            <input type="submit" value="Place Order">
        </form>
    </div>

    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>