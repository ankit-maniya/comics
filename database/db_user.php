<!-- Pratik Boghani -->
<?php
require_once(__DIR__  . '/db_master.php');
class User
{
    protected $user_id;
    protected $user_username;
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
        return $this->user_username;
    }
    function setName($user_username)
    {
        $this->user_username = trim(htmlspecialchars($user_username));
        if (empty($this->user_username)) {
            $this->errors["user_username"] = "<p>User Name is required.</p>";
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
        if (isset($properties["user_username"])) $this->setName($properties["user_username"]);
        if (isset($properties["user_email"])) $this->setEmail($properties["user_email"]);
        if (isset($properties["user_type"])) $this->setType($properties["user_type"]);
        if (isset($properties["user_password"])) $this->setPassword($properties["user_password"]);
    }

    function insert()
    {
        $sql = new DBMaster();
        $hashedPassword = password_hash($this->user_password, PASSWORD_DEFAULT);
        $sql->sqlStatement("insert into tbl_users (user_username, user_email, user_type, user_password) values(:user_username, :user_email, :user_type, :user_password)")
            ->params([

                "user_username" => $this->user_username,
                "user_email" => $this->user_email,
                "user_type" => $this->user_type,
                "user_password" => $hashedPassword,
            ])
            ->execute();
        $this->user_id = $sql->getConnection()->lastInsertId();
        return $sql->getRowCount();
    }

    function authenticateUser()
    {
        $sql = new DBMaster();
        $user_data = $sql->sqlStatement("SELECT * FROM tbl_users WHERE user_email = :user_email")
            ->params(["user_email" => $this->user_email])
            ->execute()
            ->fetchOne();

        if ($user_data) {
            if (password_verify($this->user_password, $user_data['user_password'])) {

                session_start();
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['user_username'] = $user_data['user_username'];
                $_SESSION['user_type'] = $user_data['user_type'];
            } else {
                $this->errors["user_password"] = "User Password Not Matched!";
            }
        } else {
            $this->errors["user_email"] = "User Not Found";
        }
    }
}
?>