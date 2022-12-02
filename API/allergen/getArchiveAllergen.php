<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/allergen.php';

$database = new Database();
$db = $database->connect();

$allergen = new Allergen($db);

$stmt = $allergen->getArchiveAllergen();

if ($stmt->num_rows > 0)
{
    $allergen_arr = array();

    while($record = $stmt->fetch_assoc())
    {
       $allergen_arr[] = $record;
    }

    $json = json_encode($allergen_arr);
    echo $json;

    return $json;
}
else {
    echo "\n\nNo record";
}

?>