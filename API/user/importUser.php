<?php
require("../../COMMON/connect.php");
require("../../MODEL/user.php");

header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));
//print_r($data[0]);

/*
[nome] => ADRIANA
[cognome] => IACHIM
[classe] => 5E ITIS - ITIA - INFORMATICA
[sezione] => E
[indirizzo_studi] => INFORMATICA
[email] => iachimadriana2@gmail.com
[anno] => 5
{
"nome": "ADRIANA",
"cognome": "IACHIM",
"classe": "5E ITIS - ITIA - INFORMATICA",
"sezione": "E",
"indirizzo_studi": "INFORMATICA",
//"email": "iachimadriana2@gmail.com",
"anno": "5"
}
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

$dataLength = count($data);
$recordsLength = count($records);

//print_r($records[0]);

/*
[id] => 1
[name] => Mattia
[surname] => Gallo
[email] => mattia.gallinaro@iisviolamarchesini.edu.it
[password] => CA71@F
[active] => 1
*/

/*
$update = $user->updateUser($data[3]->id, $data[3]->nome, $data[3]->cognome, $data[3]->email, $data[3]->password, $data[3]->active);
$update = $user->importUser($data[4]->nome, $data[4]->cognome, $data[4]->email);*/
//print_r($records[0]["nome"]);

//echo "DATABASE: " . gettype($records), "\n";
//echo "DATA: " . gettype($data), "\n";


for ($i = 0; $i < $recordsLength; $i++) {
    $presence = false;
    for ($j = 0; $j < $dataLength; $j++) {
        //ultima iterazione
        if ($j == $dataLength - 1 && $data[$j]->anno == "1" && (strtolower($records[$i]["name"]) == strtolower($data[$j]->nome) && strtolower($records[$i]["surname"]) == strtolower($data[$j]->cognome)) == false) {
            echo $data[$j]->nome . " " . $data[$j]->cognome . " non trovato e aggiunto, PRIMINO\n";
        } else if (strtolower($records[$i]["name"]) == strtolower($data[$j]->nome) && strtolower($records[$i]["surname"]) == strtolower($data[$j]->cognome)) {
            echo $data[$j]->nome . " " . $data[$j]->cognome . " presente e aggioranto\n";
            $presence = true;
            break; // trovato, quindi non serve continuare la corrente iterazione del for
        }
    }
    if ($presence == false) {
        echo $records[$i]["name"] . " " . $records[$i]["surname"] . " non trovato e disattivato\n";
    }
}




die();


//IMPORTA O AGGIORNA
for ($i = 0; $i < $importDataLength; $i++) {
    $nontrovato = 0;
    for ($j = 0; $j < $tableLength; $j++) {
        if ($data[$i]->nome == $records[$j]["nome"] && $data[$i]->cognome == $records[$j]["cognome"]) {
            $update = $user->updateUser($data[$i]->id, $data[$i]->nome, $data[$i]->cognome, $data[$i]->email, $data[$i]->password, $data[$i]->active);
            $user->updateOrderUser($data[$i]->id, $data[$i]->section, $data[$i]->year);
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
            $import = $user->importUser($data[$i]->nome, $data[$i]->cognome, $data[$i]->email);
            $user->importOrderUser($data[$i]->id, $data[$i]->section, $data[$i]->year);
            if ($import) {
                http_response_code(201);
                echo json_encode(["message" => "GGGGGG IMPORTATO"]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "MALE MALE"]);
            }
        }
    }
}


//print_r($records);
die();