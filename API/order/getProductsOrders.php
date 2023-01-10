<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';

$db = new Database();
$db_conn = $db->connect();

/*if(!strpos($_SERVER['REQUEST_URI'], "?BREAK_ID=") && !isset(explode("?BREAK_ID=", $_SERVER['REQUEST_URI'])[1])){
    http_response_code(404);
    echo json_encode(["message" => "Bad Request"]);
}

$id_break = explode("?BREAK_ID=", $_SERVER['REQUEST_URI'])[1];*/

$order = new Order($db_conn);
$result = $order->getOrderByClassAndBreak();

if($result->num_rows > 0){
    $output = array();
    while($row = $result->fetch_assoc()){
        array_push($output, [$row['name'], $row['quantity']]);
    }
    echo json_encode($output);
}
else{
    echo json_encode("Nothing");
}
?>
