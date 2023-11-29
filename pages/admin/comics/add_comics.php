<?php
//  Ankit Maiya - Admin Side add comics
?>

<!DOCTYPE html>
<html>

<?php
require_once('../../../configs/Path.php');
require_once('../../../helpers/ImageHandler.php');
require_once('../../components/header.php');

require_once('../../../database/db_comics.php');

$isUpdate = false;
$errors;
$inputs = [
    "comic_title" => "",
    "comic_price" => "",
    "comic_image" => "",
    "comic_description" => "",
    "comic_stock_quantity" => "",
    "genre_id" => "",
    "comic_author_name" => "",
    "comic_author_email" => "",
];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (array_key_exists('comic_id', $_GET)) {
        $isUpdate = true;

        $comic = new Comic();
        $comic->find($_GET['comic_id']);

        if ($comic->getComicId() > 0) {
            $inputs = array_merge($inputs, [
                "comic_title" => $comic->getComicTitle(),
                "comic_price" => $comic->getComicPrice(),
                "comic_image" => $comic->getComicImage(),
                "comic_description" => $comic->getComicDescription(),
                "comic_stock_quantity" => $comic->getComicStockQuantity(),
                "genre_id" => $comic->getGenreId(),
                "comic_author_name" => $comic->getComicAuthorName(),
                "comic_author_email" => $comic->getComicAuthorEmail(),
            ]);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists('add_comics_submit', $_POST)) {
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

        $comic = new Comic(array_merge([
            "comic_title" => "",
            "comic_price" => "",
            "comic_image" => $uploadedFileName,
            "comic_description" => "",
            "comic_stock_quantity" => "",
            "genre_id" => "",
            "comic_author_name" => "",
            "comic_author_email" => "",
        ], $_POST));

        if ($comic->hasError()) {
            $errors = $comic->getErrors();
            if ($hasImageError) {
                $errors['comic_image'] = $result;
            }
        } else {
            $comic->insert();
            header("Location: add_comics.php");
        }
    }

    if (array_key_exists('update_comics_submit', $_POST)) {

        $uploadedFileName = $_POST['up_comic_image'];
        $hasImageError = false;

        if ($_FILES["image"]["size"] !== 0) {
            $result = ImageHandler::handleImageUploadToServer($_FILES["image"]);
            if (strpos($result, "Error") === 0) {
                $hasImageError = true;
            } else {
                if ($_POST['up_comic_image'] !== "dummy_400_400.png") {
                    ImageHandler::removeImage($_POST['up_comic_image']);
                    $uploadedFileName = $result;
                }
            }
        }

        $comic = new Comic(array_merge([
            "comic_id" => "",
            "comic_image" => $uploadedFileName
        ], $_POST));

        if (count($comic->getErrors()) == 0) {

            $comic->update();
            header("Location: index.php");
        } else {
            $errors = $comic->getErrors();
            if ($hasImageError) {
                $errors['comic_image'] = $result;
            }
        }
    }
}

?>

<body>
    <header>
        Admin
        <?php
        if ($isUpdate) {
            echo "Update";
        } else {
            echo "Add";
        }
        ?>
        Comics
    </header>

    <?php
    $activeTab = "admin-all-comics";
    require_once('../../components/navbar.php');
    ?>

    <div class="container my-5">
        <form id="add_comics" name="add_comics" method="post" action="add_comics.php" enctype="multipart/form-data">
            <?php
            if ($isUpdate) {
            ?>
                <input type="hidden" class="form-control" id="comic_id" name="comic_id" value='<?php echo isset($_GET['comic_id']) ? $_GET['comic_id'] : 0 ?>' />
            <?php
            }
            ?>
            <div class="mb-3">
                <label for="comic_title" class="form-label">Comic Title</label>
                <input type="text" class="form-control" id="comic_title" name="comic_title" value='<?php echo isset($inputs["comic_title"]) ? $inputs["comic_title"] : "" ?>' />
                <?php
                if (isset($errors) && key_exists('comic_title', $errors)) {
                ?>
                    <div class="alert alert-danger" role="">
                        <?php echo $errors['comic_title'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="genre_id" class="form-label">Genre</label>
                <select class="form-select" id="genre_id" name="genre_id">
                    <option selected value="">Select Genere</option>
                    <?php
                    $sql = new DBMaster();
                    $serial_no = 0;
                    $selectedGenreId = isset($inputs["genre_id"]) ? $inputs["genre_id"] : null;
                    $sql->execute("select * from tbl_genres")->forEach(function ($serial_no, $row) use ($selectedGenreId) {
                        $genreId = $row["genre_id"];
                        $genreName = $row["genre_name"];
                        $selectedStr = "";
                        if ($genreId == $selectedGenreId) {
                            $selectedStr = " selected";
                        }
                        echo "<option value='$genreId' $selectedStr>$genreName</option>";
                    });
                    ?>
                </select>
                <?php
                if (isset($errors) && key_exists('genre_id', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['genre_id'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="comic_price" class="form-label">Comic Price</label>
                <input type="number" class="form-control" id="comic_price" name="comic_price" value='<?php echo isset($inputs["comic_price"]) ? $inputs["comic_price"] : "" ?>' />
                <?php
                if (isset($errors) && key_exists('comic_price', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['comic_price'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Comic Image</label>
                <input class="form-control" type="file" id="comic_image" name="image">
                <?php
                if ($isUpdate) {
                ?>
                    <input type="hidden" class="form-control" id="up_comic_image" name="up_comic_image" value='<?php echo isset($inputs["comic_image"]) ? $inputs["comic_image"] : "dummy_400_400.png" ?>' />
                <?php
                }
                ?>
                <?php
                $imgUri = ImageHandler::getImgUri($inputs['comic_image']);
                ?>
                <img src='<?php echo $imgUri ?>' class='img-thumbnail' width='250px' alt='comics'>
                <?php
                if (isset($errors) && key_exists('comic_image', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['comic_image'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="comic_description" class="form-label">Comic Description</label>
                <textarea class="form-control" rows="3" id="comic_description" name="comic_description"><?php echo isset($inputs["comic_description"]) ? $inputs["comic_description"] : "" ?></textarea>
                <?php
                if (isset($errors) && key_exists('comic_description', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['comic_description'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="comic_stock_quantity" class="form-label">Stock Quntity</label>
                <input type="number" class="form-control" id="comic_stock_quantity" name="comic_stock_quantity" value='<?php echo isset($inputs["comic_stock_quantity"]) ? $inputs["comic_stock_quantity"] : 0 ?>' />
                <?php
                if (isset($errors) && key_exists('comic_stock_quantity', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['comic_stock_quantity'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="comic_author_name" class="form-label">Author Name</label>
                <input type="text" class="form-control" id="comic_author_name" name="comic_author_name" value='<?php echo isset($inputs["comic_author_name"]) ? $inputs["comic_author_name"] : 0 ?>' />
                <?php
                if (isset($errors) && key_exists('comic_author_name', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['comic_author_name'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="comic_author_email" class="form-label">Author Email</label>
                <input type="email" class="form-control" id="comic_author_email" name="comic_author_email" value='<?php echo isset($inputs["comic_author_email"]) ? $inputs["comic_author_email"] : 0 ?>' />
                <?php
                if (isset($errors) && key_exists('comic_author_email', $errors)) {
                ?>
                    <div class="alert alert-danger mt-1" role="alert">
                        <?php echo $errors['comic_author_email'] ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <?php
            if ($isUpdate) {
            ?>
                <button type="submit" value="update_comics_submit" name="update_comics_submit" class="btn btn-warning">Update</button>
            <?php
            } else {
            ?>
                <button type="submit" value="add_comics_submit" name="add_comics_submit" class="btn btn-primary">Submit</button>
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