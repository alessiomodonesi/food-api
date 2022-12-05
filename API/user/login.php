<?php
require __DIR__ . '/../../MODEL/user.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id) || empty($data->email) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$user = new User();

if ($user->login($data->id, $data->email, $data->password) == 1) {
    echo json_encode(["message" => "Logged in successfully"]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad credentials"]);
}
