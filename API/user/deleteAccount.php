<?php
require __DIR__ . '/../../MODEL/user.php';
header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$id = explode("?id=", $parts[3])[1];
if (empty($id)) {
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}

$user = new User();

if ($result = $user->deleteUser($id) != false) {
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(["message" => "User not found"]);
}

// DA FINIRE CON LA COMPLETA ELIMINAZIONE DELLA PRESENZA DELL'ACCOUNT
