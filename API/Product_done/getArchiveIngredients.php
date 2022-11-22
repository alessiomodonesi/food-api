<?php
require("../../DB/connect.php");
require("../../MODEL/productController.php");

if (isset($_GET["panino"]))
    $panino = $_GET["panino"];

$controller = new ProductController($conn);

if (strlen($panino) > 2) {
    $controller->GetArchiveIngredients($panino);
} else {
    $controller->SendError(array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
}
?>
