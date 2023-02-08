<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/productTag.php';

if(!isset($_GET['tag_id'])){
    http_response_code(400);
    echo json_encode("Inserisci un id");
    die();
}

$id = $_GET['tag_id'];

$db = new Database();
$db_conn = $db->connect();
$product_tag = new ProductTag($db_conn);

$result = $product_tag->getActiveProductsByTag($id);

if($result->num_rows > 0){
    $products = array();
    while($row = $result->fetch_assoc()){
        array_push($products, $row);
    }
    http_response_code(200);
    echo json_encode($products);
}else{
    http_response_code(201);
    echo json_encode("No products found");
}
die();
?>