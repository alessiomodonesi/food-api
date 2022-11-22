<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../config/database.php';
include_once dirname(__FILE__) . '/../models/order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$stmt = $order->getArchiveOrder();

if ($stmt->num_rows > 0) // Se la funzione getArchiveOrder ha ritornato dei record
{
    $order_arr = array();
    $order_arr['records'] = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $order_record = array(
        'ID' => $ID,
        'user_ID' => $user_ID,
        'total_price' => $total_price,
        'date_hour_sale' => $date_hour_sale,
        'break_ID' => $break_ID,
        'status_ID' => $status_ID,
        'pickup_ID' => $pickup_ID,
        'json' => json_decode($json)
       );
       array_push($order_arr['records'], $order_record);
    }
    echo json_encode($order_arr);
    return json_encode($order_arr);
}
else {
    echo "\n\nNo record";
}
?>
