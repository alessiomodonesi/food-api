<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';

if (!strpos($_SERVER["REQUEST_URI"], "?id_user=")) // Controlla se l'URI contiene ?USER_ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$id = explode("?id_user=", $_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?USER_ID

$database = new Database();
$db = $database->connect();
$order = new Order($db);

$stmt = $order->getArchiveOrderByUser($id);

if ($stmt->num_rows > 0) // Se la funzione getArchiveOrderBreak ha ritornato dei record
{
    $order_arr = array();
    while ($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
        extract($record);
        $order_record = array(
            'id' => $id,
            'name' => $name,
            'time' => $time,
            'description' => $description,
            'costo' => $costo
        );
        array_push($order_arr, $order_record);
    }
    http_response_code(200);
    echo json_encode($order_arr);
} else {
    http_response_code(404);
    echo json_encode(array("Message" => "No record"));
}
die();
?>