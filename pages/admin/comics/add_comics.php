<?php
//  Ankit Maiya - Admin Side add comics
?>

<!DOCTYPE html>
<html>

<?php
include_once '../../../configs/Path.php';
include_once '../../components/header.php';

require('../../../database/db_comics.php');

$errors;
$inputs = [
    "comic_title" => "",
    "comic_price" => "",
    "comic_description" => "",
    "comic_stock_quantity" => "",
    "genre_id" => "",
    "comic_author_name" => "",
    "comic_author_email" => "",
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists('add_comics_submit', $_POST)) {
        $inputs = array_merge($inputs, $_POST);
        $comic = new Comic(array_merge([
            "comic_title" => "",
            "comic_price" => "",
            "comic_description" => "",
            "comic_stock_quantity" => "",
            "genre_id" => "",
            "comic_author_name" => "",
            "comic_author_email" => "",
        ], $_POST));


        if ($comic->hasError()) {
            $errors = $comic->getErrors();
        } else {
            // echo "<pre>";
            // print_r($comic);
            // die();
            $comic->insert();
            header("Location: add_comics.php");
        }
    }
}
?>

<body>
    <header>
        Admin Add Comics
    </header>

    <?php
    $activeTab = "admin-add-comics";
    include_once '../../components/navbar.php';
    ?>

    <div class="container my-5">
        <form id="add_comics" name="add_comics" method="post" action="add_comics.php">
            <div class="mb-3">
                <label for="comic_title" class="form-label">Comic Title</label>
                <input type="text" class="form-control" id="comic_title" name="comic_title" value='<?php echo isset($inputs["comic_title"]) ? $inputs["comic_title"] : "" ?>' />
                <?php
                if (isset($errors) && key_exists('comic_title', $errors)) {
                ?>
                    <div class="alert alert-danger" role="alert">
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
                    $sql->execute("select * from tbl_genres")->forEach(function ($serial_no, $row) {
                        $genreId = $row["genre_id"];
                        $genreName = $row["genre_name"];
                        echo "<option value='$genreId'>$genreName</option>";
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

            <button type="submit" value="add_comics_submit" name="add_comics_submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php
    include_once '../../components/footer.php';
    ?>

</body>

</html>