<?php
require("../../db/connectDB.php");
require("../../model/product.php");

$controller = new Product($conn);
$controller -> GetArchiveIngredients();
?>