<?php

require __DIR__ . '/../../../MODEL/favourite.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->product) || empty($data->user)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$favourite = new Favourite();


if ($favourite->removeFavourite($data->product, $data->user) == 1) {
    http_response_code(201);
    echo json_encode(["message" => "Product removed successfully"]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Product doesn't exist"]);
}
