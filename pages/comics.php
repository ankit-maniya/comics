<!DOCTYPE html>
<html>
<?php
require_once('../configs/Path.php');
include_once './components/header.php';
?>

<body>
    <header>
        Comics Store - Comics
    </header>

    <?php
    $activeTab = "comics";
    include_once './components/navbar.php';
    ?>

    <div class="container">
        <h2>Welcome to Comics</h2>
    </div>

    <?php
    include_once './components/footer.php';
    ?>
</body>

</html>