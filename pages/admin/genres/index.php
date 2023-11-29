<?php
//  Ankit Maiya - all genres
?>

<!DOCTYPE html>
<html>

<?php
include_once '../../../configs/Path.php';
include_once '../../components/header.php';

require('../../../database/db_genres.php');

$errors;
$success;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['genre_id']) && isset($_GET['genre_image'])) {
        $genre = new Genre(array_merge([
            "genre_id" => "",
            "genre_image" => "",
        ], $_GET));

        if ($genre->hasError()) {
            $errors = $genre->getErrors();
        } else {
            $record = $genre->delete();

            if ($record > 0) {
                ImageHandler::removeImage($_GET['genre_image']);
                $success = "Genre Deleted Successfully!";
            }
            header("Location: index.php");
        }
    }
}
?>

<body>
    <header>
        Admin All Genres
    </header>

    <?php
    $activeTab = "admin-all-genres";
    include_once '../../components/navbar.php';
    ?>
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
        <a class='btn btn-primary my-2' href='add_genres.php' role='button'>Add Genre</a>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">Genre Name</th>
                        <th scope="col" class="text-center">Genre Image</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $sql = new DBMaster();
                    $serial_no = 0;
                    $sql->execute("select * from tbl_genres")->forEach(function ($serial_no, $row) {
                        $img = $row['genre_image'];
                        if ($img) {
                            $img = Path::getDomainUri() . "public/uploads/" . $img;
                        } else {
                            $img = Path::getDomainUri() . "public/images/dummy_400_400.png";
                        }
                        $serial_no++;
                        echo "
                    <tr>
                        <th scope='row'>{$serial_no}</th>
                        <td>{$row['genre_name']}</td>
                        <td><img src='{$img}' class='img-thumbnail' width='250px' alt='genres'></td>
                        <td>
                        <a class='btn btn-warning' href='add_genres.php?genre_id={$row['genre_id']}' role='button'>Edit</a>
                            <a class='btn btn-danger' href='?genre_id={$row['genre_id']}&&genre_image={$row['genre_image']}' role='button'>Delete</a>
                        </td>
                    </tr>";
                    });
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    include_once '../../components/footer.php';
    ?>

</body>

</html>