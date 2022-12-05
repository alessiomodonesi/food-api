<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");


$database = new Database();
$db_connection = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?PRODUCT_ID=")) // Controlla se l'URI contiene ?PRODUCT_ID
{
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
}

$ingredient_id = explode("?PRODUCT_ID=", $_SERVER["REQUEST_URI"])[1];// per ottenere il valore posto dopo di product_id

$controller = new ProductController($db_connection);

$controller->GetProduct($ingredient_id);
?>