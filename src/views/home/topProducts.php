<?php

require_once('controllers/ProductController.php');
require_once("views/shared/objectCards/lg.php");
require_once('helpers/ProductHelper.php');
$TopProducts = ProductController::getPopular(2);

foreach ($TopProducts as $key => $product) {
    echo "<div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12 py-3\">";
    echo Lg::generate(
        [
            "title" => $product["Title"],
            "price" => number_format($product['Price'], 2),
            "duration" => ProductHelper::getDurationTimer($product),
            "productId" => $product["ProductId"],
            "track" => ($product["Tracked"] !== null),
            "winning" => ($product["Buyer"] === ($_SESSION['authenticated']['Username'] ?? false))
        ],
        FileController::get($product["ProductId"], "ProductId", 1)
    );
    echo "</div>";
}
