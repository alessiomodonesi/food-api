<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';

$data = json_decode(file_get_contents('php://input'));

if (empty($data) || empty($data->user)) {
    http_response_code(400);
    echo json_encode(["message" => "Id missing or empty"]);
    die();
}

$dtbase = new Database();
$conn = $dtbase->connect();

$cart = new Cart();
$result = $cart->ClearCart($conn, $data->user);

if ($result) {
    http_response_code(200);
    echo json_encode(["message" => "Cart cleared successfully"]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Couldn't clear Cart"]);
}
die();
?>