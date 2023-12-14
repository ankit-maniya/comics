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
    protected $sqlStatement = "";
    protected $params = null;
    protected $stmt = null;
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
            self::insertGenereTableData($pdo);
            self::insertComicsTableData($pdo);
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
            `user_name` VARCHAR(100),
            `user_type` VARCHAR(100) DEFAULT 'customer',
            `user_username` VARCHAR(100),
            `user_password` VARCHAR(255),
            `user_email` VARCHAR(100),
            `user_mobile` VARCHAR(15),
            `user_address` VARCHAR(200),
            `user_pincode` VARCHAR(7),
            `user_province` VARCHAR(2),
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
            `genre_image` VARCHAR(100) NOT NULL,
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
            `comic_image` VARCHAR(100)  NOT NULL,
            `comic_description` TEXT NOT NULL,
            `comic_stock_quantity` INT DEFAULT 0,
            `genre_id` mediumint(8) unsigned,
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
    function insertGenereTableData($pdo)
    {
        $pdo->query("INSERT INTO tbl_genres (genre_name, genre_image) VALUES
        ('Action', 'action_image.jpg'),
        ('Adventure', 'adventure_image.jpg'),
        ('Fantasy', 'fantasy_image.jpg'),
        ('Sci-Fi', 'sci_fi_image.jpg'),
        ('Mystery', 'mystery_image.jpg');");
    }
    function insertComicsTableData($pdo)
    {
        $pdo->query("INSERT INTO tbl_comics (comic_title, comic_price, comic_image, comic_description, comic_stock_quantity, genre_id, comic_author_name, comic_author_email) VALUES
       
        ('The Heroic Quest', 12.99, 'heroic_quest.jpg', 'Join our hero in a thrilling action-packed journey.', 150, 1, 'John Smith', 'john.smith@email.com'),
        ('City Shadows', 9.99, 'city_shadows.jpg', 'A tale of vigilantes fighting crime in the city at night.', 120, 1, 'Jane Doe', 'jane.doe@email.com'),
        ('Battlefield Glory', 14.99, 'battlefield_glory.jpg', 'Warriors clash in epic battles for honor and glory.', 100, 1, 'Chris Johnson', 'chris.johnson@email.com'),
        ('Lost Kingdom', 11.99, 'lost_kingdom.jpg', 'Embark on a quest to discover a hidden, ancient kingdom.', 130, 2, 'Amanda White', 'amanda.white@email.com'),
        ('The Explorer\'s Legacy', 10.99, 'explorers_legacy.jpg', 'Discover uncharted territories and face the challenges of the wild.', 110, 2, 'Robert Turner', 'robert.turner@email.com'),
        ('Jungle Expedition', 13.99, 'jungle_expedition.jpg', 'Navigate through the dense jungle and uncover its secrets.', 95, 2, 'Emily Davis', 'emily.davis@email.com'),
        ('Realm of Magic', 15.99, 'realm_of_magic.jpg', 'Magic and mythical creatures abound in a world of fantasy.', 160, 3, 'Daniel Wilson', 'daniel.wilson@email.com'),
        ('Dragon Riders', 12.99, 'dragon_riders.jpg', 'A group of warriors on dragonback embarks on a quest.', 125, 3, 'Sophie Turner', 'sophie.turner@email.com'),
        ('The Enchanted Crown', 14.99, 'enchanted_crown.jpg', 'A quest to retrieve a magical crown and save the kingdom.', 105, 3, 'Michael Brown', 'michael.brown@email.com'),
        ('Galactic Odyssey', 16.99, 'galactic_odyssey.jpg', 'Explore the vastness of space in an intergalactic adventure.', 170, 4, 'Olivia Harris', 'olivia.harris@email.com'),
        ('Cybernetic Revolution', 13.99, 'cybernetic_revolution.jpg', 'In a future world, humanity embraces cybernetic enhancements.', 140, 4, 'Ethan Turner', 'ethan.turner@email.com'),
        ('Alien Encounter', 17.99, 'alien_encounter.jpg', 'The human race faces an unexpected and mysterious extraterrestrial threat.', 115, 4, 'Mia Johnson', 'mia.johnson@email.com'),
        ('Whodunit Chronicles', 11.99, 'whodunit_chronicles.jpg', 'Solve complex mysteries in a series of intriguing cases.', 135, 5, 'William Turner', 'william.turner@email.com'),
        ('Conspiracy Unveiled', 10.99, 'conspiracy_unveiled.jpg', 'Uncover hidden conspiracies that threaten the world.', 125, 5, 'Emma White', 'emma.white@email.com'),
        ('The Detective\'s Dilemma', 12.99, 'detectives_dilemma.jpg', 'A detective navigates through personal and professional challenges.', 110, 5, 'Christopher Davis', 'christopher.davis@email.com');");
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
    function getConnection()
    {
        return self::$connectDB;
    }
    function getRowCount()
    {
        return $this->stmt->rowCount();
    }
    function reset()
    {
        $this->sqlStatement = "";
        $this->params = null;
        $this->stmt = null;
    }
    function sqlStatement($sqlStatement)
    {
        $this->reset();
        $this->sqlStatement = $sqlStatement;
        return $this;
    }
    function params($params)
    {
        $this->params = $params;
        return $this;
    }
    

    function execute($sqlStatement = "")
    {
        if (!empty($sqlStatement)) {
            $this->sqlStatement = $sqlStatement;
        }

        try {
            if (is_array($this->params)) {
                $this->stmt = self::$connectDB->prepare($this->sqlStatement);
                $this->stmt->execute($this->params);
            } else {
                $this->stmt = self::$connectDB->query($this->sqlStatement);
            }
        } catch (PDOException $e) {
            echo "Error executing query: " . $e->getMessage();
        }

        return $this;
    }
    function fetchOne()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ankit Maniya
    function forEach(callable $callback, $userDefinedData = null)
    {
        $index = 0;
        while ($row = $this->stmt->fetch()) {
            $callback($index, $row, $userDefinedData);
            $index++;
        }
    }
    function forOne(callable $callback, $userDefinedData = null)
    {
        if ($row = $this->stmt->fetch()) {
            $callback($row, $userDefinedData);
        }
    }
    


}
