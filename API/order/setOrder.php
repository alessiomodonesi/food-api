<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';
include_once dirname(__FILE__) . '/../../MODEL/orderProduct.php';

$database = new Database();
$db = $database->connect(); 

$data = json_decode(file_get_contents("php://input")); // Legge dati dalla request body
if (!empty($data)) // Se qualcosa viene letto
{
    $order = new Order($db);
    if (!empty($record = $order->setOrder($data->user, $data->break, $data->status, $data->pickup ,json_encode($data->json))))
    {
        $orderProduct = new OrderProduct($db);
        $orderProduct->setOrderProduct($record->insert_id, json_encode($data->products));
        http_response_code(201);
        echo json_encode(array("Message"=> "Created"));
    }
    else
    {
        http_response_code(503);
        echo json_encode(array("Message"=>'Error'));
    }
}
else
{
    http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
}
die();
?>