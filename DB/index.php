<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$server = "192.168.100.1";
$server_local = "127.0.0.1";

$db = "smart_sandwich_5f";
$db_local = "sandwiches";

$user = "itis";
$user_local = "root";

$passwd = "itis23K..";
$passwd_local = "";

$port = "3306";

echo "test iniziale";

try {
    $conn = new mysqli($server, $user, $passwd, $db, $port);
} catch (mysqli $ex) {
    echo "Error connecting to database $ex\n\n";
}

echo "test post connect";

$query = "SELECT * FROM `order`";
$stmt = $conn->query($query);

echo "test post query";

$order_arr = array();
while ($record = $stmt->fetch_assoc()) {
    extract($record);
    $order_record = array(
        'id' => $id,
        'user' => $user,
        'created' => $created,
        'pickup' => $pickup,
        'break' => $break,
        'status' => $status,
        'json' => json_decode($json)
    );
    array_push($order_arr, $order_record);
}
echo json_encode($order_arr, JSON_PRETTY_PRINT);

echo "test finale";
