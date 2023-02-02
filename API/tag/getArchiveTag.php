<?php

/**
 * API per la ottenere tutti i tag presenti nel database
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/tag.php';

$database = new Database();
$db_connection = $database->connect();

$_category = new Tag($db_connection);
$stmt = $_category->getArchiveTag();

if ($stmt->num_rows > 0) {
    $tag_array = array();
    while ($record = mysqli_fetch_assoc($stmt)) // Trasforma una riga in un array e lo fa per tutte le righe di un record.
    {
        $tag_array[] = $record;
    }
    $json = json_encode($tag_array);
    echo $json;
    return $json;
} else {
    echo "No record";
    http_response_code(204);
}

?>