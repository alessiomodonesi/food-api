<?php

require __DIR__ . '/../../MODEL/user.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));
 
if(empty($data->name) || empty($data->surname) || empty($data->email) || empty($data->password)) 
{
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$user = new User();

if($user -> registration($data->name, $data->surname,$data->email, $data->password ) == 1){
    echo json_encode(["message" => "Registration completed"]);
}else{
    echo json_encode(["message" => "Registration failed successfully "]);
}
?>