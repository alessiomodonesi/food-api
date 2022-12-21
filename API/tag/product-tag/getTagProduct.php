<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/productTag.php';

$database = new Database();
$db_connection = $database->connect();
$_product_tag = new ProductTag($db_connection);


if(!isset($_GET['product_id'])){
    http_response_code(400);
    echo json_encode(["message" => "No id found"]);
}

$stmt = $_product_tag->GetTagFromProduct($_GET['product_id']);

if ($stmt->num_rows > 0) {
    $product_tag_array = array();

    while($record = mysqli_fetch_assoc($stmt))
    {
        $product_tag_array[] = $record;
    }

    $json = json_encode($product_tag_array);
    echo $json;
    return $json;
}
else{
    echo 'No record';
}
?>