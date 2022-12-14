<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/allergen.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?ID=")) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    echo json_encode(["messsage" => "Bad request"]);
    die();
}

$ID = explode("?ID=", $_SERVER['REQUEST_URI'])[1]; 

if(empty($ID)){
    http_response_code(400);
    echo json_encode(["messsage" => "No id written"]);
    die(); 
}

$allergen = new Allergen($db);

$stmt = $allergen->getAllergen($ID);

if ($stmt->num_rows > 0) // Se la funzione getArchiveTag ha ritornato dei record
{
    $allergen_arr = array();

    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
        $allergen_arr[] = $record;
    }
    http_response_code(200);
    $json = json_encode($allergen_arr);
    echo $json;
    
    //return $json;
}
else {
    echo json_encode(["message" => "No record"]);
}

?>