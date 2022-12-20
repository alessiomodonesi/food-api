<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?ID=")) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$id = explode("?ID=" ,$_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?ID

if(empty($id)){
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$order = new Order($db);

$stmt = $order->setStatus($id);

if ($stmt === TRUE)
{
    echo json_encode(array("Message" => "status set on 1"));
    http_response_code(200);
    //return json_encode(array("Message" => "status set on 1"));
}
else {
    http_response_code(404);
    echo json_encode(array("Message" => "No record"));
    //return json_encode(array("Message" => "No record"));
}
die();
?>