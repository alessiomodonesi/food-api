<?php

require __DIR__ . "/../../../COMMON/connect.php";
require __DIR__ . '/../../../MODEL/favourite.php';
header("Content-type: application/json; charset=UTF-8");


if(!isset($_GET['id'])){
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}

$id = explode("?id=", $_SERVER["REQUEST_URI"])[1];

if(empty($id)){ 
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}

$db = new Database();
$db_conn = $db->connect();
$favourite = new Favourite($db_conn);

$result = $favourite->getArchiveFavourite($id);

if ($result->num_rows > 0) {
    $json_arr = array();
    while ($row = $result->fetch_assoc()) {
        array_push($json_arr, array('product' => $row['pname'], 'id_product' => $row['id'], 'email' => $row['em']));
    }
    http_response_code(200);
    echo json_encode($json_arr, JSON_PRETTY_PRINT);
}
else{
    http_response_code(404);
    echo json_encode(["message" => "No record found"]);
}

die();
