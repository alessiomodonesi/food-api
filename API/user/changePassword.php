<?php
require("../../COMMON/connect.php");
require("../../MODEL/user.php");
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->email) || empty($data->password) || empty($data->newPassword)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

if ($user->changePassword($data->email, $data->password, $data->newPassword) == 1) {
    http_response_code(201);
    echo json_encode(["message" => "Password changed successfully"]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad credentials"]);
}
