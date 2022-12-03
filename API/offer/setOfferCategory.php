<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/offerCategory.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "category_ID=") || !strpos($_SERVER["REQUEST_URI"], "offer_ID=") ) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$category_ID = explode("&", explode("category_ID=", $_SERVER['REQUEST_URI'])[1])[0]; 


$offer_ID = explode("&", explode("offer_ID=" ,$_SERVER['REQUEST_URI'])[1])[0]; 

$OfferCategory = new OfferCategory($db);
$stmt = $OfferCategory->setOfferCategory($offer_ID, $category_ID);

if ($stmt > 0)
{
    echo "Association inserted";
}
else {
    echo "Association failed";
}
?>