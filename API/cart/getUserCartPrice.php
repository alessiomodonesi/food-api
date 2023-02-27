<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';


if (!strpos($_SERVER["REQUEST_URI"], "user=") || !isset(explode("?user=", $_SERVER["REQUEST_URI"])[1])) {
    http_response_code(400);
    echo json_encode(["message" => "Id missing or empty"]);
    die();
}

$user = explode("?user=", $_SERVER["REQUEST_URI"])[1];

$dtbase = new Database();
$conn = $dtbase->connect();

$cart = new Cart();
$query = $cart->getPriceCartUser($user);

$result = $conn->query($query);
if ($result) {
    $row = $result->fetch_assoc();

    http_response_code(200);
    echo json_encode(["prezzo" => $row['prezzo']]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Couldn't"]);
}
die();
?>