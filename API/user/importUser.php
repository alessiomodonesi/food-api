<?php
require("../../COMMON/connect.php");
require("../../MODEL/user.php");

header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));
//print_r($data[0]);

/*
[id] => 1 
[name] => Mattia 
[surname] => Gallo 
[email] => mattia.gallinaro@iisviolamarchesini.edu.it 
[password] => CA71@F 
[active] => 1
*/

if (empty($data)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);

$result = $user->getUsers(); //PRENDO TUTTI GLI UTENTI

$records = array();
while ($row = $result->fetch_assoc()) {
    array_push($records, $row);
}

$importDataLength = count($data);
$tableLength = count($records);

$update = $user->updateUser($data[3]->id, $data[3]->name, $data[3]->surname, $data[3]->email, $data[3]->password, $data[3]->active);
$update = $user->importUser($data[4]->name, $data[4]->surname, $data[4]->email);
//print_r($records[0]["name"]);


//IMPORTA O AGGIORNA
/*for ($i = 0; $i < $importDataLength; $i++) {
    $nontrovato = 0;
    for ($j = 0; $j < $tableLength; $j++) {
        if ($data[$i]->name == $records[$j]["name"] && $data[$i]->surname == $records[$j]["surname"] && $data[$i]->email == $records[$j]["email"]) {
            $update = $user->updateUser($data[$i]->id,$data[$i]->name, $data[$i]->surname, $data[$i]->email, $data[$i]->password, $data[$i]->active);
            if ($update) {
                http_response_code(201);
                echo json_encode(["message" => "GGGGGG AGGIORNATO"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "MALE MALE"]);
            }
            break;
        } else {
            $nontrovato++;
        }

        if ($nontrovato == $tableLength) {
            $import = $user->importUser($data[$i]->name, $data[$i]->surname, $data[$i]->email);
            if ($import) {
                http_response_code(201);
                echo json_encode(["message" => "GGGGGG IMPORTATO"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "MALE MALE"]);
            }
        }
    }
}*/


//print_r($records);
die();
