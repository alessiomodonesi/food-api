<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../config/database.php';
include_once dirname(__FILE__) . '/../models/break.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?BREAK_ID=")) // Controlla se l'URI contiene ?BREAK_ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$id = explode("?BREAK_ID=" ,$_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?BREAK_ID

$break = new Break_($db);

$stmt = $break -> getBreak($id);

if ($stmt->num_rows > 0) // Se la funzione getBreak ha ritornato dei record
{
    $break_arr = array();
    $break_arr['records'] = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record); // importa variabili da un array
       $break_record = array(
        'break_time' => $break_time,
       );
       array_push($break_arr['records'], $break_record); // appende il record all'array che contiene tutti i record
    }
    echo json_encode($break_arr);
    http_response_code(200);
    return json_encode($break_arr);
}
else {
    echo "\n\nNo record";
}
?>
