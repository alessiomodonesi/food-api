<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["product_id"]))
    $product_id = $_GET["product_id"];

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);
$controller->DeleteProduct($product_id);

/*if (strlen($product) > 2)
$controller->DeleteProduct($product);
else
$controller->SendError(JSON_OK);*/
?>