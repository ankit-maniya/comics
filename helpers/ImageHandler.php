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

        // Generate a unique filename
        $timestamp = time();
        $randomString = bin2hex(random_bytes(8)); // Adjust the number of bytes for your needs
        $uniqueFilename = $timestamp . "_" . $randomString;

        // Get the file extension
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        // Combine the unique filename with the original file extension
        $targetFile = $targetDir . $uniqueFilename . "." . $imageFileType;
        $uploadOk = 1;

        // Check if the file is an actual image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            return "File is not an image.";
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            return "Sorry, file already exists.";
        }

        // Check file size (you can adjust the size as needed)
        if ($file["size"] > 5000000000000) {
            return "Sorry, your file is too large.";
        }

        // Allow only certain file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            return "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        }

        // Check if $uploadOk is set to 0 by an error
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
}
