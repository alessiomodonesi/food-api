<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/offer.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));


if(empty($data) || empty($data->expiry) || empty($data->id)){
    http_response_code(400);
    echo json_encode(["message" => "Bad request"]);
    die();
}

$Offer = new Offer($db);
$result = $Offer->getArchiveOffer();

while($row = $result->fetch_assoc()){
    if($row["id"] == $data->id){
        if(strtotime($row["start"]) >= strtotime($data->expiry)){
            http_response_code(400);
            echo json_encode(["messgae" => "Date of expiry is not accepted"]);
            die();
        }
    }
}

$expiry = date("Y-m-d H:i:s", strtotime($data->expiry));
$stmt = $Offer->setOfferExpiry($data->id, $expiry);


if ($stmt > 0)
{
    echo "Updated";
}
else {
    echo "Not updated";
}
?>