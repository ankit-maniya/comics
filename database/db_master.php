<?php
// Ankit Maniya
class DBMaster
{
    const DATABASE_USER = "root";
    const DATABASE_PASSWORD = "";
    const DATABASE_HOST = "localhost";
    const DATABASE_NAME = "db_comics";
    const DATABASE_CHARSET = "utf8mb4";

    static protected $connectDB = null;
    protected $sqlStatement="";
    protected $params=null;
    protected $stmt=null;
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

            // generate Genres table
            self::generateGenereTable($pdo);

            // generate Comics table
            self::generateComicsTable($pdo);

            // generate Carts table
            self::generateCartsTable($pdo);

            // generate Orders table
            self::generateOrdersTable($pdo);

            // generate Order Items table
            self::generateOrderItemsTable($pdo);
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
            `user_firstname` VARCHAR(100) NOT NULL,
            `user_lastname` VARCHAR(100) DEFAULT '',
            `user_type` VARCHAR(100) DEFAULT 'customer',
            `user_username` VARCHAR(100) NOT NULL,
            `user_password` VARCHAR(255) NOT NULL,
            `user_email` VARCHAR(100) NOT NULL,
            `user_mobile` VARCHAR(15) NOT NULL,
            `user_address` VARCHAR(200) NOT NULL,
            `user_pincode` VARCHAR(7) NOT NULL,
            `user_province` VARCHAR(2) NOT NULL,
            `user_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `user_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    function generateGenereTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_genres` (
            `genre_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `genre_name` VARCHAR(100) NOT NULL,
            `genre_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`genre_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    function generateComicsTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_comics` (
            `comic_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `comic_title` VARCHAR(100) NOT NULL,
            `comic_price` decimal(10,2) NOT NULL,
            `comic_description` TEXT NOT NULL,
            `comic_stock_quantity` INT DEFAULT 0,
            `genre_id` mediumint(8) unsigned,
            `comic_author` VARCHAR(100) DEFAULT '',
            `comic_author_name` VARCHAR(100) NOT NULL,
            `comic_author_email` VARCHAR(100) NOT NULL,
            `comic_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `comic_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`comic_id`),
            FOREIGN KEY (`genre_id`) REFERENCES tbl_genres(`genre_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    function generateCartsTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_carts` (
            `cart_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` mediumint(8) unsigned,
            `comic_id` mediumint(8) unsigned,
            `cart_quantity` INT DEFAULT 0,
            `cart_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `cart_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`cart_id`),
            FOREIGN KEY (`user_id`) REFERENCES tbl_users(`user_id`),
            FOREIGN KEY (`comic_id`) REFERENCES tbl_comics(`comic_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    function generateOrdersTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_orders` (
            `order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` mediumint(8) unsigned,
            `order_amount` DECIMAL(10,2) DEFAULT 0.0,
            `order_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`order_id`),
            FOREIGN KEY (`user_id`) REFERENCES tbl_users(`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    function generateOrderItemsTable($pdo)
    {
        $pdo->query("CREATE TABLE `tbl_order_items` (
            `order_item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `order_id` mediumint(8) unsigned,
            `comic_id` mediumint(8) unsigned,
            `order_item_quantity` INT DEFAULT 0,
            `order_item_amount` DECIMAL(10,2) DEFAULT 0.0,
            `order_item_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`order_item_id`),
            FOREIGN KEY (`order_id`) REFERENCES tbl_orders(`order_id`),
            FOREIGN KEY (`comic_id`) REFERENCES tbl_comics(`comic_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    function bindAndExecuteDatabaseQuery($pdo, $sql_statement)
    {
        $sql_statement = $pdo->prepare($sql_statement);

        if ($sql_statement) {
            $sql_statement->execute();
        }
    }
    
    function __construct()
    {
        if (self::$connectDB == null) {
            try {
                self::$connectDB =  new PDO("mysql:host=" . self::DATABASE_HOST . "; dbname=" . self::DATABASE_NAME . ";charset=" . self::DATABASE_CHARSET, self::DATABASE_USER, self::DATABASE_PASSWORD);
                self::$connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
    // Pratik Boghani----------
    function getConnection(){
        return self::$connectDB;
    }
    function getRowCount(){
        return $this->stmt->rowCount();
    }
    function reset(){
        $this->sqlStatement="";
        $this->params=null;
        $this->stmt=null;
    }
    function sqlStatement($sqlStatement){
        $this->reset();
        $this->sqlStatement=$sqlStatement;
        return $this;
    }
    function params($params){
        $this->params=$params;
        return $this;
    }
    function execute($sqlStatement=""){
        if(!empty($sqlStatement)){
            $this->sqlStatement=$sqlStatement;
        }
        if(is_array($this->params)){
            $this->stmt=self::$connectDB->prepare($this->sqlStatement);
            $this->stmt->execute($this->params);
            
        }else{
            $this->stmt=self::$connectDB->query($this->sqlStatement);
        }
        return $this;
    }
}
