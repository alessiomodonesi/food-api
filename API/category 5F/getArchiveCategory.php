<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/category.php';

$database = new Database();
$db_connection = $database->connect();

$_category = new Category($db_connection);
$stmt = $_category->getArchiveCategory();

if($stmt->num_rows > 0)
{
    $category_array = array();
    while($record = mysqli_fetch_assoc($stmt)) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       $category_array[] = $record;
    }
    $json = json_encode($category_array);
    echo $json;
    return $json;
}
else{
    echo "No record";
}

?>