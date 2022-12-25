<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/pickup.php';

$database = new Database();
$db = $database->connect();

$pickup = new PickUp($db);

$stmt = $pickup->getArchivePickup();

if ($stmt->num_rows > 0)
{
    $pickup_array = array();
    while($record = $stmt->fetch_assoc())
    {
        //extract($record);
        $pickup_array[] = $record;
    }

    http_response_code(200);
    echo json_encode($pickup_array, JSON_PRETTY_PRINT);
}
else
{
    echo "No records";
}
?>