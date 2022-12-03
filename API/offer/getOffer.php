<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/offer.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?ID=")) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$ID = explode("?ID=", $_SERVER['REQUEST_URI'])[1]; 

$offer = new Offer($db);

$stmt = $offer->getOffer($ID);

if ($stmt->num_rows > 0) 
{
    $offer_arr = array();
    $offer_arr['records'] = array();
    while($record = $stmt->fetch_assoc()) 
    {
       extract($record);
       $offer_record = array(
        'ID' => $ID,
        'title' => $title,
        'description' => $description,
        'validity_start_date' => $validity_start_date,
        'validity_end_dae' => $validity_end_date
       );
       array_push($offer_arr['records'], $offer_record);
    }
    
    echo json_encode($offer_arr);
    http_response_code(200);
    return json_encode($offer_arr);
}
else {
    echo "\n\nNo record";
}

?>