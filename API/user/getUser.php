<?php
require("../../COMMON/connect.php");
require ('../../MODEL/user.php');
header("Content-type: application/json; charset=UTF-8");

if(!isset($_GET['id'])){
    http_response_code(400);
    echo json_encode(["message" => "Insert the id param"]);
    exit();
}

$id = explode("?id=", $_SERVER["REQUEST_URI"])[1];

if (empty($id)) {
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}

$db = new Database();
$db_conn = $db->connect();

$user = new User($db_conn);

$user->getUser($id);

?>
