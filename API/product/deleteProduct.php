<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["product"]))
$product = $_GET["product"];

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);

if (strlen($product) > 2)
    $controller->DeleteProduct($product);
else
    $controller->SendError(JSON_OK);
?>