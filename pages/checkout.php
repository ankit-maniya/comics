<!DOCTYPE html>
<html>
<?php
require_once('../database/db_master.php');
require_once('../configs/Path.php');
include_once './components/header.php';

// Simulated cart items (you might fetch these from your database)
$cartItems = [
    ['product' => 'Comic 1', 'price' => 70.00, 'quantity' => 1],
    // ... more items
];

$subTotal = 0;
foreach ($cartItems as $item) {
    $subTotal += $item['price'] * $item['quantity'];
}

$shippingRate = 7.99;
$taxRate = 0.13;

$total = $subTotal + $shippingRate + ($subTotal * $taxRate);
?>

<body>
    <header>
        Comics Store - Comics
    </header>

    <?php
    $activeTab = "checkout";
    include_once './components/navbar.php';
    ?>

    <div class="my-container">

        <!-- Order summary -->
        <h2>Your Order</h2>
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
        <form method="POST" action="process_order.php">
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