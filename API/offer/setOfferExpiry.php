<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/offer.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "ID=") || !strpos($_SERVER["REQUEST_URI"], "expiry=") ) 
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$ID = explode("&", explode("ID=" ,$_SERVER['REQUEST_URI'])[1])[0]; 

$expiry = explode("&", explode("expiry=", $_SERVER['REQUEST_URI'])[1])[0]; 

$Offer = new Offer($db);

$expiry = date("Y-m-d H:i:s", $expiry);
$stmt = $Offer->setOfferExpiry($ID, $expiry);


if ($stmt > 0)
{
    echo "Updated";
}
else {
    echo "Not updated";
}
?>