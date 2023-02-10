<?php
require __DIR__ . '/../../COMMON/connect.php';
require __DIR__ . '/../../MODEL/user.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->name) || empty($data->surname) || empty($data->email) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

if ($user->registration($data->name, $data->surname, $data->email, $data->password) == true) {
    $userID = $user->login($data->email, $data->password);
    echo json_encode(["message" => "Registration completed", "userID" => $userID]);
} else {
    echo json_encode(["message" => "Registration failed successfully "]);
}
?>