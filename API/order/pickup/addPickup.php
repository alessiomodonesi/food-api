<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/pickup.php';

$data = json_decode(file_get_contents('php://input'));

if(empty($data) || empty($data->pickup)){
    echo json_encode("bad request");
    die();
}

$db = new Database();
$db_conn = $db->connect();
$pickup = new PickUp($db_conn);

$result = $pickup->addPickup($data->pickup);

if($result == 1){
    echo json_encode("Added");
}
else{
    echo json_encode("Couldn't add");
}
die();
?>