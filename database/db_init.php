<?php
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
    <header>
        Initialize Database
    </header>
    <div class="container text-center">
        <?php

        if ($msg) {
            echo $msg;
        }

        ?>
        <form method="POST">
            <input type="submit" class="init-button" value="Initialize Database">
        </form>
    </div>
    <footer>
        <div class="container">
            ~Developed by Duel Ninja - Comics Group
        </div>
    </footer>
</body>

</html>