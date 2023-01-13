<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/user.php';

$data = json_decode(file_get_contents('php://input'));

if(empty($data) || empty($data->year) || empty($data->section)){
    echo json_encode("Bad request");
    die();
}

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);


?>