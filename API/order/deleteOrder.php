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

$order = new Order($db);

$stmt = $order->delete($id);

if ($stmt === TRUE)
{
    echo "delete carried out";
    http_response_code(200);
    return json_encode(array("Message" => "delete carried out"));
    
}
else {
    echo "\n\nNo record";
    http_response_code(404);
    return json_encode(array("Message" => "No record"));
}
?>