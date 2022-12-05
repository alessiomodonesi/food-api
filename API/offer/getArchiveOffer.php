<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/offer.php';

$database = new Database();
$db = $database->connect();

$offer = new Offer($db);

$stmt = $offer->getArchiveOffer();

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
    echo "\n\nNo record";
}

?>