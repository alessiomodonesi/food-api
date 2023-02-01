<?php
header('Content-Type: application/json');
require __DIR__ . '/../../MODEL/user.php';
require __DIR__ . '/../../COMMON/connect.php';

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

echo $user->createColumnCounter();
die();
?>