<?php
// Ankit Maniya
require_once(__DIR__ . '/db_master.php');
class Genre
{
    protected $genre_id;
    protected $genre_name;

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

    function getGenreId()
    {
        return $this->genre_id;
    }

    function getComicTitle()
    {
        return $this->genre_name;
    }
    function setComicTitle($genre_name)
    {
        $this->genre_name = trim(htmlspecialchars($genre_name));
        if (empty($this->genre_name)) {
            $this->errors["genre_name"] = "Genre is required.";
        }
    }

    function __construct($properties = [])
    {
        if (isset($properties["genre_name"])) $this->setComicTitle($properties["genre_name"]);
    }

    function insert()
    {
        $sql = new DBMaster();
        $sql->sqlStatement("insert into tbl_genres (genre_name) values(:genre_name)")
            ->params([
                "genre_name" => $this->genre_name
            ])
            ->execute();
        $this->genre_id = $sql->getConnection()->lastInsertId();
        return $sql->getRowCount();
    }
    
    
}
