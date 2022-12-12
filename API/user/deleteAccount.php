<?php
require __DIR__ . '/../../COMMON/connect.php'
require __DIR__ . '/../../MODEL/user.php';
header("Content-type: application/json; charset=UTF-8");

if(!isset($_SERVER['REQUEST_URI'])){
    http_response_code(400);
    echo json_encode(["message" => "INSERT THE GODAMMIT ID"]);
    die();
}

$id = explode("?id=", $_SERVER['REQUEST_URI'])[1];
if (empty($id)) {
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}


$db = new Database();
$db_conn = $db -> connect();
$user = new User($db_conn);

$user->deleteUser($id);

if ($result = $user->deleteUser($id) != false) {
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(["message" => "User not found"]);
}

// DA FINIRE CON LA COMPLETA ELIMINAZIONE DELLA PRESENZA DELL'ACCOUNT
