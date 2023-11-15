<?php
class DBMaster
{
    const DATABASE_USER = "root";
    const DATABASE_PASSWORD = "";
    const DATABASE_HOST = "localhost";
    const DATABASE_NAME = "db_comics";
    const DATABASE_CHARSET = "utf8mb4";

    function initDatabase()
    {
        try {
            $pdo = new PDO("mysql:host=" . self::DATABASE_HOST . ";charset=" . self::DATABASE_CHARSET, self::DATABASE_USER, self::DATABASE_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::dropDatabaseIfExists($pdo, self::DATABASE_NAME);
            self::createDatabase($pdo, self::DATABASE_NAME);
            self::useDatabase($pdo, self::DATABASE_NAME);

            // generate User table
            self::generateUserTable($pdo);

            // generate Genere table
            self::generateGenereTable($pdo);

            // generate Comics table
            self::generateComicsTable($pdo);
        } catch (ErrorException $msg) {
            echo "Initialization for database is failed :: " . $msg->getMessage();
        }
    }

    function dropDatabaseIfExists($pdo, $dbName)
    {
        $sql_statement = "DROP DATABASE IF EXISTS $dbName";
        self::bindAndExecuteDatabaseQuery($pdo, $sql_statement);
    }

    function createDatabase($pdo, $dbName)
    {
        $sql_statement = "CREATE DATABASE $dbName";
        self::bindAndExecuteDatabaseQuery($pdo, $sql_statement);
    }

    function useDatabase($pdo, $dbName)
    {
        $sql_statement = "USE $dbName";
        self::bindAndExecuteDatabaseQuery($pdo, $sql_statement);
    }

    function generateUserTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_users` (
            `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `user_firstname` varchar(100) NOT NULL,
            `user_lastname` varchar(100) DEFAULT '',
            `user_username` varchar(100) NOT NULL,
            `user_password` varchar(255) NOT NULL,
            `user_email` varchar(100) NOT NULL,
            `user_mobile` varchar(15) NOT NULL,
            `user_address` varchar(200) NOT NULL,
            `user_pincode` varchar(7) NOT NULL,
            `user_province` varchar(2) NOT NULL,
            `user_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    function generateGenereTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_genres` (
            `genre_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `genre_name` varchar(100) NOT NULL,
            `genre_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`genre_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    function generateComicsTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_comics` (
            `comic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `comic_title` varchar(100) NOT NULL,
            `comic_price` decimal(10,2) NOT NULL,
            `comic_description` TEXT NOT NULL,
            `comic_stock_quantity` INT DEFAULT 0,
            `genre_id` mediumint(8) unsigned,
            `comic_author` varchar(100) DEFAULT '',
            `comic_author_name` varchar(100) NOT NULL,
            `comic_author_email` varchar(100) NOT NULL,
            `comic_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`comic_id`),
            FOREIGN KEY (`genre_id`) REFERENCES tbl_genres(`genre_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    function bindAndExecuteDatabaseQuery($pdo, $sql_statement)
    {
        $sql_statement = $pdo->prepare($sql_statement);

        if ($sql_statement) {
            $sql_statement->execute();
        }
    }
}
