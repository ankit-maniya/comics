<?php
//  Ankit Maiya - all comics
?>

<!DOCTYPE html>
<html>

<?php
require_once('../../../configs/Path.php');
require_once('../../../helpers/ImageHandler.php');
require_once('../../components/header.php');

require_once('../../../database/db_comics.php');

$errors;
$success;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['comic_id']) && isset($_GET['comic_image'])) {
        $comic = new Comic(array_merge([
            "comic_id" => "",
            "comic_image" => "",
        ], $_GET));

        if ($comic->hasError()) {
            $errors = $comic->getErrors();
        } else {
            $record = $comic->delete();

            if ($record > 0) {
                ImageHandler::removeImage($_GET['comic_image']);
                $success = "Comic Deleted Successfully!";
            }

            header("Location: index.php");
        }
    }
}
?>

<body>
    <?php
    $activeTab = "admin-all-comics";
    require_once('../../components/navbar.php');
    ?>
    <header class="bg-light-dark fs-3 text-white py-2 text-center mb-3">
        Admin All Comics
    </header>
    <div class="container">
        <?php
        if (isset($errors) && key_exists('genre_id', $errors)) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['genre_id'] ?>
            </div>
        <?php
        }
        ?>
        <a class='btn btn-primary my-2' href='add_comics.php' role='button'>Add Comics</a>
        <div class="table-responsive mb-5">
            <table class="table align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">Title</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center">Image</th>
                        <th scope="col" class="text-center">Description</th>
                        <th scope="col" class="text-center">Stock Quantity</th>
                        <th scope="col" class="text-center">Genere</th>
                        <th scope="col" class="text-center">Author Name</th>
                        <th scope="col" class="text-center">Author Email</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $sql = new DBMaster();
                    $serial_no = 0;
                    $sql->execute("select * from tbl_genres JOIN tbl_comics ON tbl_genres.genre_id = tbl_comics.genre_id")->forEach(function ($serial_no, $row) {
                        $serial_no++;
                        $imgUri = ImageHandler::getImgUri($row['comic_image']);

                        echo "
                    <tr>
                        <th scope='row'>{$serial_no}</th>
                        <td>{$row['comic_title']}</td>
                        <td>{$row['comic_price']}</td>
                        <td><img src='{$imgUri}' class='img-thumbnail' width='250px' alt='comics'></td>
                        <td>{$row['comic_description']}</td>
                        <td>{$row['comic_stock_quantity']}</td>
                        <td>{$row['genre_name']}</td>
                        <td>{$row['comic_author_name']}</td>
                        <td>{$row['comic_author_email']}</td>
                        <td>
                            <a class='btn btn-warning' href='add_comics.php?comic_id={$row['comic_id']}' role='button'>Edit</a>
                            <a class='btn btn-danger' href='?comic_id={$row['comic_id']}&&comic_image={$row['comic_image']}' role='button'>Delete</a>
                        </td>
                    </tr>";
                    });
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    require_once('../../components/footer.php');
    ?>

</body>

</html>