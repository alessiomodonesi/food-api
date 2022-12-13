<?php

require __DIR__ . "/../../../COMMON/connect.php";
require __DIR__ . '/../../../MODEL/favourite.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->product) || empty($data->user)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}


$db = new Database();
$db_conn = $db->connect();
$favourite = new Favourite($db_conn);

$result = $favourite->removeFavourite($data->product, $data->user);

if ($result == 1) {
    http_response_code(201);
    echo json_encode(["message" => "Product removed successfully"]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Product doesn't exist"]);
}
