<?php
// Ankit Maniya
$msg = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('./db_master.php');
    $master = new DBMaster();
    $master->initDatabase();
    $msg = "Database Initialized Successfully!";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Initialize Database
    </title>
    <link rel="stylesheet" href="../public/css/index.css" type="text/css">
</head>

<body>
    <header class="bg-hevy-dark fs-3 text-white py-2 text-center">
        Initialize Database
    </header>
    <div class="text-center">
        <?php

        if ($msg) {
            echo $msg;
        }

        ?>
        <form method="POST">
            <input type="submit" class="init-button" value="Initialize Database">
        </form>
    </div>
    <footer class="position-fixed bottom-0 w-100 text-center bg-hevy-dark text-white">
        <div class="my-1 py-1 font-Pacifico">
            Developed by Duel Ninja - Comics Group - 2023
        </div>
    </footer>
</body>

</html>