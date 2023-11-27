<!DOCTYPE html>
<html>
<?php
require_once('../database/db_master.php');
require_once('../configs/Path.php');
include_once './components/header.php';

// Simulated cart items (you might fetch these from your database)
$cartItems = [
    ['id' => 1, 'title' => 'Comic 1', 'price' => 70.00, 'quantity' => 2],
    // ... more items
];

$totalAmount = 0;
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
        <!-- Display items in the cart -->
        <h2>Items in Your Cart</h2>
        <table class=" cart">
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php foreach ($cartItems as $item) : ?>
                <tr>
                    <td><?= $item['title'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php $totalAmount += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
        </table>
        <p>Total Amount: $<?= number_format($totalAmount, 2) ?></p>

        <br /><br />
        <a href="checkout.php" class="btn btn-primary">Go To Checkout</a>
        <a href="comics.php" class="btn btn-primary">Continue Shopping</a>
    </div>
    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>