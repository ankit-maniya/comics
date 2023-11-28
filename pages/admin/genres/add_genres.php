<?php
//  Ankit Maiya - Admin Side Add Genres
?>

<!DOCTYPE html>
<html>

<?php
include_once '../../../configs/Path.php';
include_once '../../../helpers/ImageHandler.php';
include_once '../../components/header.php';

require('../../../database/db_genres.php');

$errors;
$success;
$inputs = [
    "genre_name" => ""
];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists('add_genres_submit', $_POST)) {
        $inputs = array_merge($inputs, $_POST);

        $uploadedFileName = "";
        $hasImageError = false;

        if ($_FILES["image"]["size"] !== 0) {
            $result = ImageHandler::handleImageUploadToServer($_FILES["image"]);
            if (strpos($result, "Error") === 0) {
                $hasImageError = true;
            } else {
                $uploadedFileName = $result;
            }
        }

        $genre = new Genre(array_merge([
            "genre_name" => "",
            "genre_image" => $uploadedFileName,
        ], $_POST));

        if ($genre->hasError()) {
            $errors = $genre->getErrors();
            if ($hasImageError) {
                $errors['genre_image'] = $result;
            }
        } else {
            $genre->insert();
            $success = "Genre Added Successfully!";
            header("Location: add_genres.php");
        }
    }
}
?>

<body>
    <header>
        Admin Add Genres
    </header>

    <?php
    $activeTab = "admin-add-genres";
    include_once '../../components/navbar.php';
    ?>

    <div class="container my-5">
        <form id="add_genre" name="add_genre" method="post" action="add_genres.php" enctype="multipart/form-data">
            <?php
            if (isset($success)) {
            ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success ?>
                </div>
            <?php
            }
            ?>
            <div class="mb-3">
                <label for="genre_name" class="form-label">Genre Title</label>
                <input type="text" class="form-control" id="genre_name" name="genre_name" value='<?php echo isset($inputs["genre_name"]) ? $inputs["genre_name"] : "" ?>' />
                <?php
                if (isset($errors) && key_exists('genre_name', $errors)) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['genre_name'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Genre Image</label>
                <input class="form-control" type="file" id="genre_image" name="image">
                <?php
                if (isset($errors) && key_exists('genre_image', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['genre_image'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <button type="submit" value="add_genres_submit" name="add_genres_submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php
    include_once '../../components/footer.php';
    ?>

</body>

</html>