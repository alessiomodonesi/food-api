<?php
header('Content-Type: application/json');
require __DIR__ . '/../../MODEL/user.php';
require __DIR__ . '/../../COMMON/connect.php';

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

$data =  json_decode(file_get_contents("php://input"));

if(empty($data) || empty($data->name) || empty($data->surname)|| empty($data->password) || empty($data->email) || empty($data->year) || empty($data->section)){
    http_response_code(400);
    echo json_encode(["Message" => "Invalid request"]);
    die();
}


$result = $user->registration_Secure($data->name, $data->surname, $data->email, $data->password, $data->year, $data->section);

if($result)
?>