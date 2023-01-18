<?php
require __DIR__ . '/../../COMMON/connect.php';
require __DIR__ . '/../../MODEL/user.php';
header("Content-type: application/json; charset=UTF-8");

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

$result = $user->getActiveUsers();

if($result->num_rows> 0){
    //$row = $result->fetch_assoc();
    //echo json_encode($row);
    $users = array();
    while($row = $result->fetch_assoc()){
        array_push($users, $row);
    }
    echo json_encode($users);
}
else{
    echo '{"message": "No users found"}';
}
die();
?>