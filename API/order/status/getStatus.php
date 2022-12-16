<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/status.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "?STATUS_ID="))
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$id = explode("?STATUS_ID=" ,$_SERVER['REQUEST_URI'])[1];

if(empty($id)){
    http_response_code(400);
    echo json_encode(["Message" => "No id found"]);
    die();
}

$status = new Status($db);

$stmt = $status -> getStatus($id);

if ($stmt->num_rows > 0)
{
    $status_arr = array();
    while($record = $stmt->fetch_assoc())
    {
       extract($record);
       $status_record = array(
        'description' => $description,
       );
       array_push($status_arr, $status_record);
    }
    http_response_code(200);
    echo json_encode($status_arr, JSON_PRETTY_PRINT);
    //return json_encode($status_arr);
}
else {
    http_response_code(404);
    echo json_encode(["Message" => "No record"]);
    
    //return json_encode(array("Message" => "No record"));
}
die();
?>