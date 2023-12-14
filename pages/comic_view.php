<!-- Ankit Maniya -->
<!DOCTYPE html>
<html>
<?php

require_once('../configs/Path.php');
require_once('../helpers/ImageHandler.php');
require_once('./components/header.php');
require_once('../database/db_comics.php');
require_once('../database/db_cart.php');

$comicsDetail = [
    "comic_title" => "",
    "comic_price" => "",
    "comic_image" => "",
    "comic_description" => "",
    "comic_stock_quantity" => "",
    "genre_id" => "",
    "genre_name" => "",
    "genre_image" => "",
    "comic_author_name" => "",
    "comic_author_email" => "",
];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (array_key_exists('comic_id', $_GET)) {

        $comic = new Comic();
        $comic->find($_GET['comic_id']);

        if ($comic->getComicId() > 0) {
            $comicsDetail = array_merge($comicsDetail, [
                "comic_title" => $comic->getComicTitle(),
                "comic_price" => $comic->getComicPrice(),
                "comic_image" => $comic->getComicImage(),
                "comic_description" => $comic->getComicDescription(),
                "comic_stock_quantity" => $comic->getComicStockQuantity(),
                "genre_id" => $comic->getGenreId(),
                "genre_name" => $comic->getGenreName(),
                "genre_image" => $comic->getGenreImage(),
                "comic_author_name" => $comic->getComicAuthorName(),
                "comic_author_email" => $comic->getComicAuthorEmail(),
            ]);
        }
    }
}


?>

<body>

    <?php
    $activeTab = "comics";
    require_once('./components/navbar.php');
    ?>

    <header class="bg-light-dark fs-3 text-white py-2 text-center">
        Comics Store - Comics Detail View
    </header>

    <?php
    if (empty($comicsDetail['comic_title']) || is_null($comicsDetail['comic_title'])) {
        $title = "Comic not found";
        require_once('./components/not_found.php');
    } else {
    ?>
        <div class="container mb-5 pb-5">
            <h1 class="text-center"><?php echo $comicsDetail['comic_title'] ?></h1>
            <div class='card my-3'>
                <div class='row g-0'>
                    <?php
                    $imgUri = ImageHandler::getImgUri($comicsDetail['comic_image']);
                    echo "
                
                    <div class='col-md-4'>
                        <img src='{$imgUri}' class='img-fluid rounded-start' alt='{$comicsDetail['comic_title']}'>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$comicsDetail['comic_title']}</h5>
                            <h6 class='card-subtitle mb-2 text-body-secondary'>{$comicsDetail['genre_name']}</h6>
                            <div>
                                <label class='fw-bold'>Price:</label>
                                <span class='badge text-bg-primary'>\${$comicsDetail['comic_price']}</span>
                            </div>
                            <div>
                                <label class='fw-bold'>Description:</label>
                                <span class='card-text'>{$comicsDetail['comic_description']}</span>
                            </div>
                            <div>
                                <label class='fw-bold'>Stock Quantity:</label>
                                <span class='card-text'>{$comicsDetail['comic_stock_quantity']}</span>
                            </div>
                            <div>
                                <label class='fw-bold'>Genre:</label>
                                <span class='card-text'>{$comicsDetail['genre_name']}</span>
                            </div>
                            <div>
                                <label class='fw-bold'>Author Name:</label>
                                <span class='card-text'>{$comicsDetail['comic_author_name']}</span>
                            </div>
                            <div>
                                <label class='fw-bold'>Author Email:</label>
                                <span class='card-text'>{$comicsDetail['comic_author_email']}</span>
                            </div>
                            <form method='post' action='cart.php?comic_id={$_GET['comic_id']}'>
                                  <button type='submit' name='add_to_cart' class='btn btn-primary'>Add to Cart</button>
                            </form>

                        </div>
                    </div>
                    ";
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <?php
    require_once('./components/footer.php');

    ?>

</body>

</html>