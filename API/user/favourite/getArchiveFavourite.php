<?php

require __DIR__ . '/../../../MODEL/favourite.php';
header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if (empty($parts[5])) {
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}

$favourite = new Favourite();

$result = $favourite->getArchiveFavourite($parts[6]);

$archiveFavourites = array();
for ($i = 0; $i < (count($result)); $i++) {
    $archiveFavourite = array(
        "product" => $result[$i]["pname"],
        "user" => $result[$i]["em"]
    );
    array_push($archiveFavourites, $archiveFavourite);
}

if (empty($archiveFavourites)) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo json_encode($archiveFavourites);
}
