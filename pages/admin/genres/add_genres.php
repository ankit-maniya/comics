<?php
//  Ankit Maiya - Admin Side Add Genres
?>

<!DOCTYPE html>
<html>

<?php
require_once('../../../configs/Path.php');
require_once('../../../helpers/ImageHandler.php');
require_once('../../components/header.php');

require_once('../../../database/db_genres.php');

$isUpdate = false;
$errors;
$success;
$inputs = [
    "genre_name" => ""
];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (array_key_exists('genre_id', $_GET)) {
        $isUpdate = true;

        $genre = new Genre();
        $genre->find($_GET['genre_id']);

        if ($genre->getGenreId() > 0) {
            $inputs = array_merge($inputs, [
                "genre_id" => $genre->getGenreId(),
                "genre_name" => $genre->getGenreTitle(),
                "genre_image" => $genre->getGenreImage()
            ]);
        }
    }
}


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

    if (array_key_exists('update_genres_submit', $_POST)) {

        $uploadedFileName = $_POST['up_genre_image'];
        $hasImageError = false;

        if ($_FILES["image"]["size"] !== 0) {
            $result = ImageHandler::handleImageUploadToServer($_FILES["image"]);
            if (strpos($result, "Error") === 0) {
                $hasImageError = true;
            } else {
                if ($_POST['up_genre_image'] !== "dummy_400_400.png") {
                    ImageHandler::removeImage($_POST['up_genre_image']);
                    $uploadedFileName = $result;
                }
            }
        }

        $genre = new Genre(array_merge([
            "genre_id" => "",
            "genre_image" => $uploadedFileName
        ], $_POST));

        if (count($genre->getErrors()) == 0) {

            $genre->update();
            header("Location: index.php");
        } else {
            $errors = $genre->getErrors();
            if ($hasImageError) {
                $errors['genre_image'] = $result;
            }
        }
    }
}
?>

<body>
    <header class="bg-hevy-dark fs-3 text-white py-2 text-center">
        Admin
        <?php
        if ($isUpdate) {
            echo "Update";
        } else {
            echo "Add";
        }
        ?>
        Genres
    </header>

    <?php
    $activeTab = "admin-all-genres";
    require_once('../../components/navbar.php');
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

            <?php
            if ($isUpdate) {
            ?>
                <input type="hidden" class="form-control" id="genre_id" name="genre_id" value='<?php echo isset($_GET['genre_id']) ? $_GET['genre_id'] : 0 ?>' />
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
                if ($isUpdate) {
                ?>
                    <input type="hidden" class="form-control" id="up_genre_image" name="up_genre_image" value='<?php echo isset($inputs["genre_image"]) ? $inputs["genre_image"] : "dummy_400_400.png" ?>' />
                <?php
                }
                ?>
                <?php
                $imgUri = ImageHandler::getImgUri($inputs['genre_image']);
                ?>
                <img src='<?php echo $imgUri ?>' class='img-thumbnail' width='250px' alt='genres'>
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

            <?php
            if ($isUpdate) {
            ?>
                <button type="submit" value="update_genres_submit" name="update_genres_submit" class="btn btn-warning">Update</button>
            <?php
            } else {
            ?>
                <button type="submit" value="add_genres_submit" name="add_genres_submit" class="btn btn-primary">Submit</button>
            <?php
            }
            ?>
        </form>
    </div>

    <?php
    require_once('../../components/footer.php');
    ?>

</body>

</html>