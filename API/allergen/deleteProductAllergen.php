<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/productAllergen.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "allergen=") || !strpos($_SERVER["REQUEST_URI"], "product=") ) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$allergen = explode("&", explode("allergen=" ,$_SERVER['REQUEST_URI'])[1])[0]; 

$product = explode("&", explode("product=", $_SERVER['REQUEST_URI'])[1])[0]; 

$productAllergen = new ProductAllergen($db);
$stmt = $productAllergen->deleteProductAllergen($product, $allergen);

if ($stmt > 0)
{
    http_response_code(200);
    echo "Association deleted";
}
else {
    http_response_code(503);
    echo "Association not deleted";
}
?>