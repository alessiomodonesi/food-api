<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/orderProduct.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?ORDER_ID=")) // Controlla se l'URI contiene ?ORDER_ID
{
    //http_response_code(400);
    echo json_encode(array("Message" => "Bad request"));
    die();
}

$id = explode("?ORDER_ID=" ,$_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?ORDER_ID

$order = new OrderProduct($db);

$stmt = $order->getOrderProduct($id);

if ($stmt->num_rows > 0) // Se la funzione getOrderProduct ha ritornato dei record
{
    $order_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $order_record = array(
        'order' => $order,
        'product' => $product
        //'quantity' => $quantity
       );
       array_push($order_arr, $order_record);
    }
    echo json_encode($order_arr);
    //http_response_code(200);
    return json_encode($order_arr);
}
else {
    echo "\n\nNo record";
    //http_response_code(404);
    return json_encode(array("Message" => "No record"));
}
?>