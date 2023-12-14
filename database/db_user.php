<!-- Pratik Boghani -->
<?php
require_once(__DIR__  . '/db_master.php');
class User
{
    protected $user_id;
    protected $user_name;
    protected $user_type;
    protected $user_password;
    protected $user_email;

    protected $errors = [];

    function getErrors()
    {
        return $this->errors;
    }
    function cleanErrors()
    {
        $this->errors = [];
    }

    function getUserId()
    {
        return $this->user_id;
    }

    function setUserId($user_id)
    {
        $this->user_id = trim(htmlspecialchars($user_id));
        $this->user_id = (int)$this->user_id;
    }

    function getName()
    {
        return $this->user_name;
    }
    function setName($user_name)
    {
        $this->user_name = trim(htmlspecialchars($user_name));
        if (empty($this->user_name)) {
            $this->errors["user_name"] = "<p>User Name is required.</p>";
        }
    }
    function getEmail()
    {
        return $this->user_email;
    }
    function setEmail($user_email)
    {
        $this->user_email = trim(htmlspecialchars($user_email));
        if (empty($this->user_email)) {
            $this->errors["user_email"] = "<p>Email is required.</p>";
        }
        if (!filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["user_email"] = "<p>Email is Invalid</p>";
        }
    }

    function getType()
    {
        return $this->user_type;
    }
    function setType($user_type)
    {
        $this->user_type = trim(htmlspecialchars($user_type));
        if (empty($this->user_type)) {
            $this->errors["user_type"] = "<p>User type is required.</p>";
        }
        if (!in_array($this->user_type, ["Admin", "Customer", "ADMIN", "CUSTOMER"])) {
            $this->errors["user_type"] = "<p>User type is Invalid or not from Admin, Customer</p>";
        }
    }
    function getPassword()
    {
        return $this->user_password;
    }
    function setPassword($user_password)
    {
        $this->user_password = trim(htmlspecialchars($user_password));
        if (empty($this->user_password)) {
            $this->errors["user_password"] = "<p>Password is required.</p>";
        }
    }

    function __construct($properties = [])
    {
        if (isset($properties["user_id"])) $this->setUserId($properties["user_id"]);
        if (isset($properties["user_name"])) $this->setName($properties["user_name"]);
        if (isset($properties["user_email"])) $this->setEmail($properties["user_email"]);
        if (isset($properties["user_type"])) $this->setType($properties["user_type"]);
        if (isset($properties["user_password"])) $this->setPassword($properties["user_password"]);
    }

    function insert()
    {
        try {
        $sql = new DBMaster();
        if (!$sql->checkDatabaseExists()) {
            header("Location: ../database/db_init.php");
            exit();
        }
        else{
            $hashedPassword = password_hash($this->user_password, PASSWORD_DEFAULT);
            
            $sql->sqlStatement("INSERT INTO tbl_users (user_name, user_email, user_type, user_password) VALUES (:user_name, :user_email, :user_type, :user_password)")
                ->params([
                    "user_name" => $this->user_name, 
                    "user_email" => $this->user_email,
                    "user_type" => $this->user_type,
                    "user_password" => $hashedPassword,
                ])
                ->execute();

            $this->user_id = $sql->getConnection()->lastInsertId();

            return $sql->getRowCount();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
    }

    function authenticateUser()
    {
        $sql = new DBMaster();
        if (!$sql->checkDatabaseExists()) {
            header("Location: ../database/db_init.php");
            exit();
        }
        else{
            if (filter_var($this->user_email, FILTER_VALIDATE_EMAIL)) {
                $user_data = $sql->sqlStatement("SELECT * FROM tbl_users WHERE user_email = :user_email")
                    ->params(["user_email" => $this->user_email])
                    ->execute()
                    ->fetchOne();
                if ($user_data) {
                    if (password_verify($this->user_password, $user_data['user_password'])) {
                        session_regenerate_id();
                        session_start();
                        $_SESSION['user_id'] = $user_data['user_id'];
                        $_SESSION['user_name'] = $user_data['user_name'];
                        $_SESSION['user_type'] = $user_data['user_type'];
                    } else {
                        $this->errors["user_password"] = "User Password Not Matched!";
                    }
                } else {
                    $this->errors["user_email"] = "User Not Found";
                }
            } else {
                $this->errors["user_email"] = "Invalid Email Format";
            }
        }
    }

    public static function isAdmin()
    {
        if (!empty($_SESSION["user_type"]) && $_SESSION["user_type"] == "Admin") {
            return true;
        }

        return false;
    }

    public static function redirectIfLoggedIn()
    {
        if (!empty($_SESSION["user_id"])) {
            header("Location: index.php");
            exit();
        }
    }

    public static function logout()
    {

        session_unset();
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        session_start();
        $_SESSION['user_id'] = null;
        $_SESSION['user_name'] = null;
        $_SESSION['user_type'] = null;

        setcookie('PHPSESSID', '', time() - 3600, '/', 0, 0);

        print_r($_SESSION);
        header("Location: login.php");
        exit();
    }

    public static function redirectIfNotLoggedIn()
    {
        if (empty($_SESSION["user_id"])) {
            header("Location: login.php");
            exit();
        }
    }
}
?>