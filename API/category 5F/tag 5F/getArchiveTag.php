<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/tag.php';

$database = new Database();
$db = $database->connect();

$_tag = new Tag($db);

$stmt = $_tag->getArchiveTag();

if ($stmt->num_rows > 0)
{
    $tag_arr = array();
    $tag_arr['records'] = array();
    while($record = $stmt->fetch_assoc())
    {
       extract($record);
       $tag_record = array(
        'tag_ID' => $tag_ID,
        'tag' => $tag
       );
       array_push($tag_arr['records'], $tag_record);
    }
    echo json_encode($tag_arr);
    return json_encode($tag_arr);
}
else {
    echo "\n\nNo record";
}

?>