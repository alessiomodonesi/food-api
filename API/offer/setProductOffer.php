<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/productOffer.php';

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->connect();


if(empty($data) || empty($data->product) || empty($data->offer)){
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$ProductOffer = new ProductOffer($db);

$stmt = $ProductOffer->getOfferProduct($data->offer);

if($stmt->num_rows > 0){
    while($row = $stmt->fetch_assoc()){
        if($row["id"] == $data->product){
            http_response_code(400);
            echo json_encode(["message" => "Already exists"]);
            die();
        }
    }
}

$result = $ProductOffer->setProductOffer($data->product, $data->offer);
if ($stmt)
{
    echo "Association inserted";
}
else {
    echo "Association failed";
}
?>