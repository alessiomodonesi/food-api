<?php
require("../../DB/connect.php");
require("../../MODEL/productController.php");

if (isset($_GET["ingrediente"]))
    $ingredient_ID = $_GET["ingrediente"];

$controller = new ProductController($conn);

$controller->DeleteIngredient($ingredient_ID);
?>
