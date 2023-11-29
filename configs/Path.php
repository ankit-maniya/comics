<!-- Ankit Maniya -->
<?php
class Path
{
    const BASE_URI = "http://localhost/comics/";

    public static function getDomainUri()
    {
        return self::BASE_URI;
    }

    public static function getFilePath()
    {
        $FILE_UPLOAD_PATH = $_SERVER['DOCUMENT_ROOT'] . "/comics/public/uploads/";

        return  $FILE_UPLOAD_PATH;
    }
}
