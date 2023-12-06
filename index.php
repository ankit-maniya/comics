<!DOCTYPE html>
<html>

<?php
require_once('./configs/Path.php');
include_once './pages/components/header.php';

?>

<body>
    <?php
    $activeTab = "home";
    include_once './pages/components/navbar.php';
    ?>
    <header class="bg-light-dark fs-3 text-white py-2 text-center mb-3">
        Comics Store - Home Page
    </header>
    <section class="text-center mt-2">
        <h2 class="fs-1 text-white">Welcome to Comics Store</h2>
    </section>
    <?php
    include_once './pages/components/footer.php';
    ?>

</body>

</html>