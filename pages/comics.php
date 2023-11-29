<!DOCTYPE html>
<html>
<?php
require_once('../configs/Path.php');
require_once('../helpers/ImageHandler.php');
require_once('./components/header.php');
require_once('../database/db_comics.php');
?>

<body>
    <header>
        Comics Store - Comics
    </header>

    <?php
    $activeTab = "comics";
    require_once('./components/navbar.php');
    ?>

    <div class="container">
        <h1 class="text-center">Welcome to Comics</h1>
        <div class="row m-0 g-2 mb-5 pb-4">
            <?php
            $sql = new DBMaster();
            $serial_no = 0;
            $sql->execute("select * from tbl_genres JOIN tbl_comics ON tbl_genres.genre_id = tbl_comics.genre_id")->forEach(function ($serial_no, $row) {
                $serial_no++;
                $imgUri = ImageHandler::getImgUri($row['comic_image']);

                echo "<div class='col-sm-4'>
                    <div class='card'>
                        <img src='{$imgUri}' class='card-img-top' alt='{$row['comic_title']}'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$row['comic_title']}</h5>
                            <h6 class='card-subtitle mb-2 text-body-secondary'>{$row['genre_name']}</h6>
                            <div>
                                <label>Price:</label>
                                <span class='badge text-bg-primary'>\${$row['comic_price']}</span>
                            </div>
                            <p class='card-text'>{$row['comic_description']}</p>
                            <div class='d-flex justify-content-center'>
                                <a class='btn btn-primary' href='comic_view.php?comic_id={$row['comic_id']}' role='button'>View More</a>
                            </div>
                        </div>
                    </div>
                </div>";
            });
            ?>

        </div>
    </div>

    <?php
    require_once('./components/footer.php');
    ?>
</body>

</html>