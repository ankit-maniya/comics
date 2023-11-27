<?php
// Ankit Maniya
require_once(__DIR__ . '/db_master.php');
class Comic
{
    protected $comic_id;
    protected $comic_title;
    protected $comic_price;
    protected $comic_description;
    protected $comic_stock_quantity;
    protected $genre_id;
    protected $comic_author_name;
    protected $comic_author_email;
    protected $comic_updated_at;

    protected $errors = [];
    function hasError()
    {
        foreach ($this->errors as $key => $value) {
            if ($value != null && $value != '') {
                return true;
            }
        }
        return false;
    }

    function getErrors()
    {
        return $this->errors;
    }
    function cleanErrors()
    {
        $this->errors = [];
    }

    function getComicId()
    {
        return $this->comic_id;
    }

    function getComicTitle()
    {
        return $this->comic_title;
    }
    function setComicTitle($comic_title)
    {
        $this->comic_title = trim(htmlspecialchars($comic_title));
        if (empty($this->comic_title)) {
            $this->errors["comic_title"] = "Title is required.";
        }
    }

    function getComicPrice()
    {
        return $this->comic_price;
    }
    function setComicPrice($comic_price)
    {
        $this->comic_price = trim(htmlspecialchars($comic_price));
        if (empty($this->comic_price)) {
            $this->errors["comic_price"] = "Price is required.";
        }
    }

    function getComicDescription()
    {
        return $this->comic_description;
    }
    function setComicDescription($comic_description)
    {
        $this->comic_description = trim(htmlspecialchars($comic_description));
        if (empty($this->comic_description)) {
            $this->errors["comic_description"] = "Description is required.";
        }
    }

    function getComicStockQuantity()
    {
        return $this->comic_stock_quantity;
    }
    function setComicStockQuantity($comic_stock_quantity)
    {
        $this->comic_stock_quantity = trim(htmlspecialchars($comic_stock_quantity));
        if (empty($this->comic_stock_quantity)) {
            $this->errors["comic_stock_quantity"] = "Stock Quntity is required.";
        }
    }

    function getGenreId()
    {
        return $this->genre_id;
    }
    function setGenreId($genre_id)
    {
        $this->genre_id = trim(htmlspecialchars($genre_id));
        if (empty($this->genre_id)) {
            $this->errors["genre_id"] = "Genre is required.";
        }
    }

    function getComicAuthorName()
    {
        return $this->comic_author_name;
    }
    function setComicAuthorName($comic_author_name)
    {
        $this->comic_author_name = trim(htmlspecialchars($comic_author_name));
        if (empty($this->comic_author_name)) {
            $this->errors["comic_author_name"] = "Author Name is required.";
        }
    }

    function getComicAuthorEmail()
    {
        return $this->comic_author_email;
    }
    function setComicAuthorEmail($comic_author_email)
    {
        $this->comic_author_email = trim(htmlspecialchars($comic_author_email));
        if (empty($this->comic_author_email)) {
            $this->errors["comic_author_email"] = "Author Email is required.";
        }
    }

    function __construct($properties = [])
    {
        if (isset($properties["comic_title"])) $this->setComicTitle($properties["comic_title"]);
        if (isset($properties["comic_price"])) $this->setComicPrice($properties["comic_price"]);
        if (isset($properties["comic_description"])) $this->setComicDescription($properties["comic_description"]);
        if (isset($properties["comic_stock_quantity"])) $this->setComicStockQuantity($properties["comic_stock_quantity"]);
        if (isset($properties["genre_id"])) $this->setGenreId($properties["genre_id"]);
        if (isset($properties["comic_author_name"])) $this->setComicAuthorName($properties["comic_author_name"]);
        if (isset($properties["comic_author_email"])) $this->setComicAuthorEmail($properties["comic_author_email"]);
    }

    function insert()
    {
        $sql = new DBMaster();
        $sql->sqlStatement("insert into tbl_comics (comic_title, comic_price, comic_description, comic_stock_quantity, genre_id, comic_author_name, comic_author_email) values(:comic_title, :comic_price, :comic_description, :comic_stock_quantity, :genre_id, :comic_author_name, :comic_author_email)")
            ->params([
                "comic_title" => $this->comic_title,
                "comic_price" => $this->comic_price,
                "comic_description" => $this->comic_description,
                "comic_stock_quantity" => $this->comic_stock_quantity,
                "genre_id" => $this->genre_id,
                "comic_author_name" => $this->comic_author_name,
                "comic_author_email" => $this->comic_author_email,
            ])
            ->execute();
        $this->comic_id = $sql->getConnection()->lastInsertId();
        return $sql->getRowCount();
    }
}
