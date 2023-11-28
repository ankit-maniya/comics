<?php
//  Ankit Maiya - all comics
?>

<!DOCTYPE html>
<html>

<?php
include_once '../../../configs/Path.php';
include_once '../../components/header.php';

require('../../../database/db_comics.php');
?>

<body>
    <header>
        Admin All Comics
    </header>

    <?php
    $activeTab = "admin-all-comics";
    include_once '../../components/navbar.php';
    ?>
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
                    $img = $row['comic_image'];
                    if ($img) {
                        $img = Path::getDomainUri() . "public/uploads/" . $img;
                    } else {
                        $img = Path::getDomainUri() . "public/images/dummy_400_400.png";
                    }

                    echo "
                    <tr>
                        <th scope='row'>{$serial_no}</th>
                        <td>{$row['comic_title']}</td>
                        <td>{$row['comic_price']}</td>
                        <td><img src='{$img}' class='img-thumbnail' width='250px' alt='comics'></td>
                        <td>{$row['comic_description']}</td>
                        <td>{$row['comic_stock_quantity']}</td>
                        <td>{$row['genre_name']}</td>
                        <td>{$row['comic_author_name']}</td>
                        <td>{$row['comic_author_email']}</td>
                        <td>
                            <a class='btn btn-warning' href='#' role='button'>Edit</a>
                            <a class='btn btn-danger' href='#' role='button'>Delete</a>
                        </td>
                    </tr>";
                });
                ?>
            </tbody>
        </table>
    </div>
    <?php
    include_once '../../components/footer.php';
    ?>

</body>

</html>