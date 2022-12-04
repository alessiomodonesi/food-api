<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/productOffer.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "product=") || !strpos($_SERVER["REQUEST_URI"], "offer=") ) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$product = explode("&", explode("product=" ,$_SERVER['REQUEST_URI'])[1])[0]; 

$offer = explode("&", explode("offer=", $_SERVER['REQUEST_URI'])[1])[0]; 

$ProductOffer = new ProductOffer($db);
$stmt = $ProductOffer->setProductOffer($product, $offer);

if ($stmt > 0)
{
    echo "Association inserted";
}
else {
    echo "Association failed";
}
?>