<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

$database = new Database();
$db_connection = $database->connect();
$controller = new ProductController($db_connection);
$controller->CheckProduct();
?>
