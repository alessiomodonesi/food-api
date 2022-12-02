<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["name"]))
    $name = $_GET["name"];

if (isset($_GET["description"]))
    $description = $_GET["description"];

if (isset($_GET["avariable_quantity"]))
    $avariable_quantity = $_GET["avariable_quantity"];


$controller = new ProductController($conn);
$controller->setIngredient($name, $description, $avariable_quantity);
?>