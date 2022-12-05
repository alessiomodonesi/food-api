<?php

/**
 * API per la creazione di una nuova relazione prodotto-tag
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
**/

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/productTag.php';

$database = new Database();
$db_connection = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data)) {
    $_product_tag = new ProductTag($db_connection);
    if ($_product_tag->setProductTag($data->product_id, $data->tag_id) > 0) {
        http_response_code(201);
        echo json_encode(array("Setting" => "Done"));
    } else {
        http_response_code(503);
        echo json_encode(array("Setting" => 'Error'));
    }
} else {
    http_response_code(400);
    die(json_encode(array("Setting" => "Bad request")));
}

?>
