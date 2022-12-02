<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["product_id"]))
    $product_id = $_GET["product_id"];

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);

$controller->GetArchiveProducts($product_id);
/*if (strlen($ingredient_id) > 2) {
    $controller->GetArchiveIngredients($ingredient_id);
} else {
    $controller->SendError(array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
}*/
?>