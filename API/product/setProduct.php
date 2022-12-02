<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["name"]))
    $name = $_GET["name"];

if (isset($_GET["price"]))
    $price = $_GET["price"];

if (isset($_GET["description"]))
    $description = $_GET["description"];

if (isset($_GET["quantity"]))
    $quantity = $_GET["quantity"];

if (isset($_GET["nutritional_value"]))
    $nutritional_value = $_GET["nutritional_value"];

    
if (isset($_GET["active"]))
$active = $_GET["active"];

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);
$controller->setProduct($name, $price, $description, $quantity, $nutritional_value,$active);
?>