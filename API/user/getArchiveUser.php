<?php
header('Content-Type: application/json;');

require __DIR__ . "/../../COMMON/connect.php";
require __DIR__ . "/../../MODEL/user.php";

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

$result = $user->getArchiveUser();
$utenti = array();
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        array_push($utenti, $row);
    }
    echo json_encode($utenti);
}
else{
    echo json_encode(["message" => "Error"]);
}
die();
?>