<?php
require("../../COMMON/connect.php");
require("../../MODEL/user.php");

header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));
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
$update = $user->importUser($data[4]->nome, $data[4]->cognome, $data[4]->email);
*/
//echo "DATABASE: " . gettype($records), "\n";
//echo "DATA: " . gettype($data), "\n";

$newStudents = array(); //array con gli studenti nuovi

$students = array();
$students["new"] = array(); //nuovi studenti


for ($i = 0; $i < $recordsLength; $i++) {
    $presence = false;
    for ($j = 0; $j < $dataLength; $j++) {
        if (
            strtolower($records[$i]["name"]) == strtolower($data[$j]->nome)
            && strtolower($records[$i]["surname"]) == strtolower($data[$j]->cognome)
        ) {
            echo $data[$j]->nome . " " . $data[$j]->cognome . " presente e aggioranto\n";
            $presence = true;
            break; // trovato, quindi non serve continuare la corrente iterazione del for
        }
    }
    if ($presence == false && $records[$i]["active"] == "1") {
        echo $records[$i]["name"] . " " . $records[$i]["surname"] . " non trovato e disattivato\n";
    }
}
//print_r($newStudents);
/*
foreach ($newStudents as $nSTD) {
    echo $nSTD->nome . " " . $nSTD->cognome . " nuovo studente\n";
    $userNew = $user->importUser($nSTD->nome, $nSTD->cognome, $nSTD->email);
}
*/

$result = $user->getUsers(); //PRENDO TUTTI GLI UTENTI
$records = array();
while ($row = $result->fetch_assoc()) {
    array_push($records, $row);
}
$recordsLength = count($records);

for ($i = 0; $i < $dataLength; $i++) {
    $presence = false;
    for ($j = 0; $j < $recordsLength; $j++) {
        if (
            strtolower($records[$j]["name"]) == strtolower($data[$i]->nome)
            && strtolower($records[$j]["surname"]) == strtolower($data[$i]->cognome)
        ) {
            echo $data[$j]->nome . " " . $data[$j]->cognome . " presente e non cambiato\n";
            $presence = true;
            break;
        }
    }
    if ($presence == false) {
        echo $data[$i]->nome . " " . $data[$i]->cognome . " non trovato e aggiunto\n";
    }
}
die();