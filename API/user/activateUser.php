<?php
require("../../COMMON/connect.php");
require("../../MODEL/user.php");

header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

$result = $user->activateUser($data->id);

if ($result) {
    http_response_code(200);
    echo json_encode(["response" => true, "message" => "activated"]);
} else {
    http_response_code(401);
    echo json_encode(["response" => false]);
}
die();
?>