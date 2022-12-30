<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../COMMON/connect.php";
require __DIR__ . "/../../MODEL/user.php";

header("Content-type: application/json; charset=UTF-8");

use PhpOffice\PhpSpreadsheet\Spreadsheet;

ob_clean();

$filename = $_FILES['fileTestApi']['name'];

//punto in cui verrá salvato il file
$destination = __DIR__ . "/../../COMMON/" . $filename;

// ottiene l'estensione del file
$extension = pathinfo($filename, PATHINFO_EXTENSION);

$file = $_FILES['fileTestApi']['tmp_name']; //posizione temporanea in cui il file si trova
$size = $_FILES['fileTestApi']['size']; //grandezza del file in byte

move_uploaded_file($file, $destination); //sposta il file nella cartella specificata

$people = array();

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($destination); //carica il file excel data la posizione di esso

$spreadsheet = $reader->getActiveSheet(); //ritorna la tabella corrente del file excel

$db = new Database();
$db_conn = $db->connect();
$user = new User($db_conn);
$user->createTablePersons();

//partendo dalla riga 2 del file excel e colonna A,
//prende il valore di ogni cella, la inserisce nell'array person che 
//contiene i dati della singola persona, li inserisce sulla tabella person
//e li mette nell'array people
for ($row = 2; $row < $spreadsheet->getHighestRow(); $row++) {
    $person = array();
    for ($col = 'A'; $col != $spreadsheet->getHighestColumn(); $col++) {
        $value = $spreadsheet->getCell($col . $row)->getValue();
        if ($col == 'A' || $col == 'B') {
            $value = strtolower($value);
            $value = ucfirst($value);
        }
        array_push($person, $value);
    }
    array_push($people, $person);
    $user->insert_Table($person);
}

$result = $user->getUserFromTable();

$check = false;

$users = array();

while($row = $result->fetch_assoc()){
    array_push($users, array($row["name"], $row["surname"]));
}


for ($index = 0; $index < sizeof($people); $index++) {
    $check = false;
    for ($index2 = 0; $index2 < sizeof($users); $index2++){
        if (strcmp($users[$index2][0],$people[$index][0]) == 0 && strcmp($users[$index2][1],$people[$index][1]) == 0) {
            $check = true;
            break 1;
        }
    }
    if (!$check){
        echo json_encode(["message" => "nope"]);
        $user->insert_User($people[$index][0], $people[$index][1]);
    }
}


die();
?>