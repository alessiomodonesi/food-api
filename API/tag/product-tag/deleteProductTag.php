<?php

/**
 * API per eliminare una relazione prodotto-tag
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
**/

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/productTag.php';

$database = new Database();
$db_connection = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data)) {
    $_product_tag = new ProductTag($db_connection);
    if ($_product_tag->deleteProductTag($data->product_id, $data->tag_id) > 0) {
        http_response_code(200);
        echo json_encode(array("Deletion" => "Done"));
    } else {
        http_response_code(503);
        echo json_encode(array("Deletion" => 'Error'));
    }
} else {
    http_response_code(400);
    die(json_encode(array("Deletion" => "Bad request")));
}


?>