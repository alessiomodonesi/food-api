<?php
require("../../COMMON/connect.php");
require("../../MODEL/user.php");

header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->email) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

$result = $user->login($data->email, $data->password);

if ($result != false) {
    http_response_code(200);
    $user->resetCounter($result);
    echo json_encode(["response" => true, "userID" => $result]);
} else {
    unset($result);
    $result = $user->checkCounterEmail($data->email);
    if($result != -1){
        if($result['counter'] >= 4){
            $user->deleteUser($result['id']);
        }else{
            $user->increaseCounter($result['id']);
        }
    }
    http_response_code(401);
    echo json_encode(["response" => false]);
}
die();
?>