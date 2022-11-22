<?php
require("../../DB/connect.php");
require("../../MODEL/productController.php");


$controller = new ProductController($conn);

$controller->CheckProduct();
?>
