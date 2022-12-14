<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/productAllergen.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(empty($data) || empty($data->product) || empty($data->allergen)){
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}


$productAllergen = new ProductAllergen($db);
$stmt = $productAllergen->setProductAllergen($data->product, $data->allergen);

if ($stmt > 0)
{
    http_response_code(200);
    echo json_encode(["message" => "Association inserted"]);
}
else {
    http_response_code(400);
    echo json_encode(["message" => "Association not inserted"]);
}
?>