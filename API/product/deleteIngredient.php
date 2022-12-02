<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (isset($_GET["ingrediente"]))
    $ingredient_ID = $_GET["ingrediente"];

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);

//$controller->DeleteIngredient($ingredient_ID);
?>
