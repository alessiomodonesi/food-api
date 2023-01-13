<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';

$db = new Database();
$db_conn = $db->connect();
$order = new Order($db_conn);

$result = $order->getActiveOrdersByBreak();
echo json_encode($result);
die();
?>