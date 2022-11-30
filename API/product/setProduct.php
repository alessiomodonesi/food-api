<?php
require("../../DB/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["name"]))
    $name = $_GET["name"];

if (isset($_GET["price"]))
    $price = $_GET["price"];

if (isset($_GET["description"]))
    $description = $_GET["description"];

if (isset($_GET["quantity"]))
    $quantity = $_GET["quantity"];

if (isset($_GET["category_ID"]))
    $category_ID = $_GET["category_ID"];

if (isset($_GET["nutritional_value_ID"]))
    $nutritional_value_ID = $_GET["nutritional_value_ID"];

$controller = new ProductController($conn);
$controller->setProduct($name, $price, $description, $quantity, $category_ID, $nutritional_value_ID);
?>