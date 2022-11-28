<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/offer.php';

$database = new Database();
$db = $database->connect();

$offer = new Offer($db);

$stmt = $offer->getArchiveOffer();

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
        'offer_code' => $offer_code,
        'validity_start_date' => $validity_start_date,
        'validity_end_date' => $validity_end_date
       );
       array_push($offer_arr['records'], $offer_record);
    }
    echo json_encode($offer_arr);
    return json_encode($offer_arr);
}
else {
    echo "\n\nNo record";
}

?>