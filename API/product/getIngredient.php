<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");


$database = new Database();
$db_connection = $database->connect();

if(!strpos($_SERVER["REQUEST_URI"], "?INGREDIENT_ID=")){

    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
}

$ingredient_ID = explode("?INGREDIENT_ID=", $_SERVER["REQUEST_URI"])[1];

$controller = new ProductController($db_connection);

$controller->GetIngredient($ingredient_ID);
?>