<?php
include_once dirname(__FILE__) . '/../config/database.php';
include_once dirname(__FILE__) . '/../models/catalog.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?ID=")) // Controlla se l'URI contiene ?STATUS_ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$id = explode("?ID=" ,$_SERVER['REQUEST_URI'])[1]; // Viene ricavato quello che c'è dopo ?STATUS_ID

$catalogue = new Catalog($db);

$queryProductsCatalogue = $catalogue->getCatalog($id);    
     
if ($queryProductsCatalogue->num_rows > 0) {
    $catalogue_arr=array();

    while($record = $queryProductsCatalogue->fetch_assoc()) 
    {
        extract($record);
        $catalogue_record = array(
            'catalogue_name' => $catalogue_name,
            'validity_start_date' => $validity_start_date,
            'validity_end_date' => $validity_end_date,
            );
        array_push($catalogue_arr, $catalogue_record);
    }
    echo json_encode($catalogue_arr, JSON_PRETTY_PRINT);
    http_response_code(200);
    return json_encode($catalogue_arr, JSON_PRETTY_PRINT);
}
else
{
    echo 'No record';
    http_response_code(404);
    return json_encode(array("Message" => "No record"));
}

$conn->close();

?>