<?php
// Ankit Maniya
class ImageHandler
{
    public static function handleImageUploadToServer($file)
    {
        $targetDir = Path::getFilePath();

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $timestamp = time();
        $randomString = bin2hex(random_bytes(8));
        $uniqueFilename = $timestamp . "_" . $randomString;

        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        $targetFile = $targetDir . $uniqueFilename . "." . $imageFileType;
        $uploadOk = 1;

        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            return "File is not an image.";
        }

        if (file_exists($targetFile)) {
            return "Sorry, file already exists.";
        }

        if ($file["size"] > 5000000000000) {
            return "Sorry, your file is too large.";
        }

        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            return "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        }

        if ($uploadOk == 0) {
            return "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $uniqueFilename . "." . $imageFileType;
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        }
    }

    public static function removeImage($filename)
    {
        $filePath = Path::getFilePath() . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
            return "Image $filename has been removed.";
        } else {
            return "Image $filename not found.";
        }
    }

    public static function getImgUri($imgName)
    {
        $img = Path::getDomainUri() . "public/images/dummy_400_400.png";
        if ($imgName) {
            $img = Path::getDomainUri() . "public/images/" . $imgName;
        }

        return $img;
    }
}
