<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["name"]))
    $name = $_GET["name"];

if (isset($_GET["description"]))
    $description = $_GET["description"];

if (isset($_GET["price"]))
    $price = $_GET["price"];

if (isset($_GET["quantity"]))
    $quantity = $_GET["quantity"];


$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);
$controller->setIngredient($name, $description,$price, $quantity);
?>