<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';

$data = json_decode(file_get_contents('php://input'));

if(empty($data) || empty($data->user) || empty($data->quantity)){
    http_response_code(404);
    echo json_encode(["message" => "Invalid request."]);
    die();
}

$db = new Database();
$conn = $db->connect();

$cart = new Cart();

$sql = sprintf("SELECT * 
FROM cart 
WHERE user = %d and product = %d" , 
$conn->real_escape_string($data->user), 
$conn->real_escape_string($data->prod));

$result = $conn->query($sql);


if($result->num_rows == 0) {
    $result = $conn->query($cart->addItem($data->prod, $data->user, $data->quantity));
    if($result == false){
        http_response_code(500);
        echo json_encode(["message" => "Could not add product to cart"]);
    }else{
        http_response_code(200);
        echo json_encode(["message" => "Product added successfully"]);
    }
}
else{
    $sql = sprintf("UPDATE cart
        SET quantity = quantity + %d
        WHERE user = %d and product = %d" ,
        $conn->real_escape_string($data->quantity), 
        $conn->real_escape_string($data->user), 
        $conn->real_escape_string($data->prod));
    
    $result = $conn->query($sql);
    if($result == false){
        http_response_code(500);
        echo json_encode(["message" => "Could not add product to cart"]);
    }else{
        http_response_code(200);
        echo json_encode(["message" => "Product added successfully"]);
    }
}
die();
?>