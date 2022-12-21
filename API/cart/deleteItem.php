<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';


if((!strpos($_SERVER["REQUEST_URI"], "user=") || !strpos($_SERVER["REQUEST_URI"], "product="))){
    http_response_code(400);
    echo json_encode(["message" => "Id missing or empty"]);
    die();
}

$user = explode("&product=",explode("?user=",$_SERVER["REQUEST_URI"])[1])[0];
$prod = explode("&product=", $_SERVER["REQUEST_URI"])[1];

if($user == null || $prod == null){
    http_response_code(400);
    echo json_encode(["message" => "empty id"]);
    die();
}



$dtbase = new Database();
$conn = $dtbase->connect();

$cart = new Cart();
$queryDelete = $cart->deleteItem($prod, $user);

$result = $conn->query($queryDelete);
if ($result) {
    http_response_code(200);
    echo json_encode(["message" => "Item deleted"]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Couldn't delete the item"]);
}
die();
?>