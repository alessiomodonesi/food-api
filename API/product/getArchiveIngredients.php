<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");

if (!isset($_GET["panino"]) || empty($_GET['panino'])){
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
    die();
}

$panino = $_GET['panino'];

$database = new Database();
$db_connection = $database->connect();


$controller = new ProductController($db_connection);


if (!empty($_GET['panino']))
    $controller->GetArchiveIngredients($panino);
else
    $controller->SendError(JSON_OK);
?>
