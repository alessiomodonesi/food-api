<?php

/**
 * API per ottenere un tag in base al nome o all'ID
 * Versione dell'API che prende i parametri in ingresso da file JSON
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/tag.php';

$database = new Database();
$db_connection = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data)) {
    $_tag = new Tag($db_connection);

    /*
     * Verifico se nel file JSON in ingresso esiste una delle due proprietà "tag_ID" o "tag_name" e 
     * eventualmente richiamo dal modello il metodo che esegue la query al database più adatta.
     */

    if (property_exists($data, 'tag_ID') == true) {
        $stmt = $_tag->getTagWithTagID($data->tag_ID);
        httpResponse(201);
        getResponse($stmt);
    } else if (property_exists($data, 'tag_name') == true) {
        $stmt = $_tag->getTagWithTagName($data->tag_name);
        httpResponse(201);
        getResponse($stmt);
    } else {
        httpResponse(400);
    }
} else {
    httpResponse(503);
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
        httpResponse(200);
        echo $json;
        return $json;
    } else {
        echo "No record";
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