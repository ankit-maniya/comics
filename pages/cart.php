<!DOCTYPE html>
<html>
<?php
require_once('../configs/Path.php');
include_once './components/header.php';
?>

<body>
    <header>
        Comics Store - Cart Page
    </header>

    <?php
    $activeTab = "cart";
    include_once './components/navbar.php';
    ?>

    <div class="my-container">

        <br/><br/>
        <a href="checkout.php" class="btn btn-primary">Go To Checkout</a>
        <a href="books.php" class="btn btn-primary">Continue Shopping</a>
    </div>

    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>