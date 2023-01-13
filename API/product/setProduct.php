<?php
require("../../COMMON/connect.php");
require("../../MODEL/product.php");



$data = json_decode(file_get_contents('php://input'));

if(empty($data) || empty($data->name) ||empty($data->price) ||empty($data->description) ||empty($data->quantity) || empty($data->nutritional_value) ||empty($data->active)){
    echo json_encode('Bad request');
    die();
}

$database = new Database();
$db_connection = $database->connect();

$controller = new ProductController($db_connection);
$controller->setProduct($data->name, $data->price, $data->description, $data->quantity, $data->nutritional_value,$data->active);
?>