<?php

/**
 * API per ottenere le relazione prodotto-tag
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
 **/

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
//header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/productTag.php';

$database = new Database();
$db_connection = $database->connect();
$_product_tag = new ProductTag($db_connection);

if (isset($_GET['product_id']) == true) {
    $stmt = $_product_tag->getArchiveProductTagWithProductID($_GET['product_id']);
    //httpResponse(201);
    getResponse($stmt);

} else if (isset($_GET['tag_id']) == true) {
    $stmt = $_product_tag->getArchiveProductTagWithTagID($_GET['tag_id']);
    //httpResponse(201);
    getResponse($stmt);

} else {
    $stmt = $_product_tag->getArchiveProductTag();
    httpResponse(201);
    getResponse($stmt);
}

/*
 * Funzione per inviare al client la risposta della query effettuata.
 */

function getResponse($stmt)
{
    if ($stmt->num_rows > 0) {
        $tag_array = array();
        while ($record = mysqli_fetch_assoc($stmt)) // Trasforma una riga in un array e lo fa per tutte le righe di un record.
        {
            $tag_array[] = $record;
        }
        $json = json_encode($tag_array);
        //httpResponse(200);
        echo $json;
        return $json;
    } else {
        httpResponse(204);
    }
}

/*
 * Funzione che fa ritornare il codice HTTP di risposta e una risposta testuale in JSON.
 */

function httpResponse($code)
{
    switch ($code) {
        case 200:
            http_response_code(200);
            break;
        case 201:
            http_response_code(201);
            echo json_encode(array("Message" => "Created"));
            break;
        case 204:
            http_response_code(204);
            echo "No record";
        case 400:
            http_response_code(400);
            die(json_encode(array("Message" => "Bad request")));
        case 503:
            http_response_code(503);
            echo json_encode(array("Message" => 'Error'));
            break;

    }
}


?>