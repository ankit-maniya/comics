<!DOCTYPE html>
<html>

<?php
require_once('./configs/Path.php');
include_once './pages/components/header.php';

?>

<body>
    <header class="bg-hevy-dark fs-3 text-white py-2 text-center">
        Comics Store - Home Page
    </header>
    <?php
    $activeTab = "home";
    include_once './pages/components/navbar.php';
    ?>
    <section class="text-center mt-2">
        <h2 class="fs-1">Welcome to Comics Store</h2>
    </section>
    <?php
    include_once './pages/components/footer.php';
    ?>

</body>

</html>