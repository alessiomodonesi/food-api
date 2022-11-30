<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/tag.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?tag_ID=")) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$tag_ID = explode("?tag_ID=", $_SERVER['REQUEST_URI'])[1]; 

$_tag = new Tag($db);

$stmt = $_tag->getTag($tag_ID);

if ($stmt->num_rows > 0) // Se la funzione getArchiveTag ha ritornato dei record
{
    $tag_arr = array();
    $tag_arr['records'] = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $tag_record = array(
        'tag_ID' => $tag_ID,
        'tag' => $tag
       );
       array_push($tag_arr['records'], $tag_record);
    }
    
    echo json_encode($tag_arr);
    http_response_code(200);
    return json_encode($tag_arr);
}
else {
    echo "\n\nNo record";
}

?>