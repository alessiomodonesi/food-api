<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["product_id"]))
$product_id = $_GET["product_id"];

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);
$controller->ReactiveProduct($product_id);
?>