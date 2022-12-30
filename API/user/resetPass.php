<?php
require __DIR__ . "/../../COMMON/connect.php";
require __DIR__ . "/../../MODEL/user.php";

header("Content-type: application/json; charset=UTF-8");


$data = json_decode(file_get_contents("php://input"));


if (empty($data->email) || $data->email == "") {
    http_response_code(400);
    echo json_encode(["message" => "Insert the email param"]);
    die();
}


$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);
$state = $user->ResetPassword($data->email);

if ($state != false) {
    http_response_code(200);
    echo json_encode(["message" => "Passowrd resetted"]);
} else {
    /*
    http_response_code(400);
    echo json_encode(["message" => "Error"]);
    */
    //c'è già una risposta se qualcosa non va nella funzione resetPassword()
}
die();
?>