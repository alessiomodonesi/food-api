<?php
require("../../DB/connect.php");
require("../../MODEL/product.php");


$controller = new ProductController($conn);

$controller->CheckIngredient();

?>
