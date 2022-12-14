<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/offer.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?ID=")) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$ID = explode("?ID=", $_SERVER['REQUEST_URI'])[1]; 

if(empty($ID)){
    http_response_code(400);
    echo json_encode(["message" => "Id is empty"]);
    die();
}

$offer = new Offer($db);

$stmt = $offer->getOffer($ID);

if ($stmt->num_rows > 0) 
{
    $offer_arr = array();

    while($record = $stmt->fetch_assoc())
    {
       $offer_arr[] = $record;
    }

    $json = json_encode($offer_arr);
    echo $json;

    return $json;
}
else {
    http_response_code(400);
    echo json_encode(["message" => "No record found"]);
}
die();
?>