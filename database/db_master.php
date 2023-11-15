<?php
class DBMaster
{
    const DATABASE_USER = "root";
    const DATABASE_PASSWORD = "";
    const DATABASE_HOST = "127.0.0.1";
    const DATABASE_NAME = "db_comics";
    const DATABASE_CHARSET = "utf8mb4";

    function initDatabase()
    {
        try {
            $pdo = new PDO("mysql:host=" . self::DATABASE_HOST . ";charset=" . self::DATABASE_CHARSET, self::DATABASE_USER, self::DATABASE_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::dropDatabaseIfExists($pdo, self::DATABASE_NAME);
        } catch (ErrorException $msg) {
            echo "Initialization for database is failed :: " . $msg->getMessage();
        }
    }

    function dropDatabaseIfExists($pdo, $dbName)
    {
        $stmt = $pdo->query("DROP DATABASE IF EXISTS :DATABASE_NAME");
        $stmt->bindParam(':DATABASE_NAME', $dbName, PDO::PARAM_STR);
        $stmt->execute();
    }

}
