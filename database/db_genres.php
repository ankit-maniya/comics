<?php
// Ankit Maniya
require_once(__DIR__ . '/db_master.php');
class Genre
{
    protected $genre_id;
    protected $genre_name;
    protected $genre_image;

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

    function getGenreImage()
    {
        return $this->genre_image;
    }
    function setGenreImage($genre_image)
    {
        $this->genre_image = trim(htmlspecialchars($genre_image));

        if (empty($this->genre_image) || is_null($this->genre_image)) {
            $this->errors["genre_image"] = "Image is required.";
        }
    }

    function __construct($properties = [])
    {
        if (isset($properties["genre_name"])) $this->setComicTitle($properties["genre_name"]);
        if (isset($properties["genre_image"])) $this->setGenreImage($properties["genre_image"]);
    }

    function insert()
    {
        $sql = new DBMaster();
        $sql->sqlStatement("insert into tbl_genres (genre_name, genre_image) values(:genre_name, :genre_image)")
            ->params([
                "genre_name" => $this->genre_name,
                "genre_image" => $this->genre_image
            ])
            ->execute();
        $this->genre_id = $sql->getConnection()->lastInsertId();
        return $sql->getRowCount();
    }
}
