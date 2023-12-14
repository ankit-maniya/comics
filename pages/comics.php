<!-- Ankit Maniya -->
<!DOCTYPE html>
<html>
<?php
require_once('../configs/Path.php');
require_once('../helpers/ImageHandler.php');
require_once('../database/db_comics.php');
require_once('../database/db_cart.php');
require_once('../database/db_genres.php');
require_once('./components/header.php');
?>

<body>
    <?php
    $activeTab = "comics";
    require_once('./components/navbar.php');
    ?>
    <header class="bg-light-dark fs-3 text-white py-2 text-center mb-3">
        Comics Store - Comics
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-white">All Genres</h1>
                    <ul class="list-group list-group-horizontal flex-nowrap">
                        <a href='comics.php' class='text-white fw-bold text-decoration-none'>
                            <li class='d-flex align-items-center flex-column'>
                                <img src='https://dummyimage.com/512/ffffff/000000&text=ALL' alt='all' class='img-height m-3 shadow'>
                                <span class='badge text-bg-danger'>All</span>
                            </li>
                        </a>
                        <?php
                        $sql = new DBMaster();
                        $serial_no = 0;
                        $sql_response = $sql->execute("select * from tbl_genres");
                        $selectedGenreId = isset($_GET['genre_id']) ? $_GET['genre_id'] : null;
                        $sql_response->forEach(function ($serial_no, $row) use ($selectedGenreId) {
                            $imgUri = ImageHandler::getImgUri($row['genre_image']);
                            $serial_no++;
                            $design =  ($selectedGenreId == $row['genre_id']) ? "text-bg-warning" : "text-bg-primary";
                            echo "<a href='comics.php?genre_id={$row['genre_id']}' class='text-white fw-bold text-decoration-none'><li class='d-flex align-items-center flex-column'>
                                <img src='{$imgUri}' alt='{$row['genre_name']}' class='img-height m-3 shadow'>
                                <span class='badge  {$design}'>{$row['genre_name']}</span>
                            </li></a>";
                        });
                        ?>
                    </ul>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-white">All Comics</h1>
                    <div class="row m-0 g-2 mb-5 pb-4">
                        <?php
                        $sql = new DBMaster();
                        $serial_no = 0;
                        $params = null;

                        $sql_response = $sql->sqlStatement("select * from tbl_genres JOIN tbl_comics ON tbl_genres.genre_id = tbl_comics.genre_id");
                        if (isset($_GET['genre_id'])) {
                            $params = [
                                'genre_id' => $_GET['genre_id']
                            ];
                            $sql_response = $sql->sqlStatement("select * from tbl_genres JOIN tbl_comics ON tbl_genres.genre_id = tbl_comics.genre_id where tbl_genres.genre_id=:genre_id")->params($params);
                        }

                        // Fetch comics with associated genres
                        $sql_response->execute()->forEach(function ($serial_no, $row) {
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
        </div>
    </div>

    <?php
    require_once('./components/footer.php');
    ?>
</body>

</html>