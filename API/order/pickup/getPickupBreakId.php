<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/pickupBreak.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?BREAK_ID=")) // Controlla se l'URI contiene ?BREAK_ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$id = explode("?BREAK_ID=" ,$_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?BREAK_ID

if(empty($id)){
    http_response_code(400);
    echo json_encode(["Message" => "No id found"]);
    die();
}

$order = new PickupBreak($db);

$stmt = $order->getPickupBreakId($id);

if ($stmt->num_rows > 0) // Se la funzione getArchiveOrder ha ritornato dei record
{
    $pickupBreak_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $pickupBreak_record = array(
        'pickup' => $pickup,
        'break' => $break,
       );
       array_push($pickupBreak_arr, $pickupBreak_record);
    }
    http_response_code(200);
    echo json_encode($pickupBreak_arr, JSON_PRETTY_PRINT);
    //return json_encode($pickupBreak_arr);
}
else {
    http_response_code(404);
    echo json_encode(["message" => "No record"]);
    //return json_encode(array("Message" => "No record"));
}
die();
?>