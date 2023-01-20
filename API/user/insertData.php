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
}

$utenti_presenti = $user->getUserClass();
$studenti = array();

while($studente = $utenti_presenti->fetch_assoc()){
    array_push($studenti, $studente);
}

$found = false;
$different_class = false;
$id_person = 0;

$persons_to_add = array();
for ($i = 0; $i < sizeof($people); $i++){
    array_push($persons_to_add, $i);
}
//echo json_encode($persons_to_add);
//echo json_encode($studenti);
//echo json_encode($people);
//echo sizeof($studenti);
//echo sizeof($people);
for($j = 0; $j < sizeof($studenti); $j++){
    for ($i = 0; $i < sizeof($people); $i++) {
        //echo $studenti[$j]['name'] . $people[$i][0] . $studenti[$j]['surname'] . $people[$i][1] . $studenti[$j]['class'] . substr($people[$i][2], 0, 1) . $studenti[$j]['section'] . substr($people[$i][3], 0 , 1) . '<br />';
        $test = intval(substr($people[$i][2], 0 , 1)) - intval($studenti[$j]['class']);//serve affinchè non controlli utenti che abbiano stesso nome ma che sia in anni differenti e quindi poi il controllo dovrà essere posto a 0 <= $test <= 1in modo che la differenza minima sia di un anno, evenutali casi di cambiamento si devono vedere in altro modo (controllando il cambio della sezione) 
        echo 'Valore di test:' . $test . '<br />';
        $result = strcmp($studenti[$j]['name'], $people[$i][0]);
        echo ($result);
        //echo ($studenti[$j]['name'] == $people[$i][0] && $studenti[$j]['surname'] == $people[$i][1] && $studenti[$j]['class'] != substr($people[$i][2], 0, 1) && $studenti[$j]['section'] != substr($people[$i][3], 0, 1));
        if(strcmp($studenti[$j]['name'], $people[$i][0]) == 0  && strcmp($studenti[$j]['surname'], $people[$i][1]) == 0 && strcmp($studenti[$j]['class'] , substr($people[$i][2], 0, 1)) != 0 && strcmp($studenti[$j]['section'] , substr($people[$i][3], 0 , 1)) != 0){
            echo 'Dentro 1';
            $found = true;
            $different_class = true;
            $id_person = $i;
            break;
        }
        else if($studenti[$j]['name'] == $people[$i][0] && $studenti[$j]['surname'] == $people[$i][1] && $studenti[$j]['class'] == substr($people[$i][2], 0, 1) && $studenti[$j]['section'] == substr($people[$i][3], 0 , 1)){
            echo 'Dentro 2';
            $found = true;
            $different_class = false;
            $id_person = $i;
            break;
        }
    }
    if($found && $different_class){
        $id_class = $user->getSingleClass(substr($people[$i][2], 0, 1), $people[$id_person][3]);//aggiungere la rimozione di un collegamento user class prima di inserirne uno nuovo in modo che ogni utente sia collegato ad una sola classe ogni anno
        echo json_encode($id_class);
        $result_modify = $user->addClassUser($studenti[$j]['user'], $id_class['id']);
        //unset($persons_to_add[]->$id_person); devo rimuovere l'id della persona che è già stata modificata o usando la funzione unset ma poi ponendo attenzione agli id già eliminati oppure mettere campo id più id per capire quale elemento eliminare
        echo json_encode($result_modify);
    }
    else if(!$found){
        $result_deactive = $user->deleteUser($studenti[$j]['user']);
        echo json_encode($result_deactive);
    }
    $found = false;
    $different_class = false;
    $id_person = 0;
}



for ($i = 0; $i < sizeof($persons_to_add); $i++) {
    //$id_user = $user->insert_user($people[$j]['name']
    //$result->insert_id; per ottenere l'id dell'ultima persona inserita
    //$id_class = $user->getSingleClass(substr($people[$i][2], 0, 1), $people[$i][3]);
    //$result = $user->addClassUser($id_user, $id_class);
}

/* $user->insert_Table($person);
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

$saved_users = $user->getUserClass();
$real_data = array();

while ($row = $saved_users->fetch_assoc()) {
    array_push($real_data, array($row["name"], $row["surname"], $row['year'], $row['section']));
}

for ($index = 0; $index < sizeof($users); $index++) {
}*/
die();
?>