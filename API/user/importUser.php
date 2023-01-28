<?php
require("../../COMMON/connect.php"); // richiediamo il file di connessione al database
require("../../MODEL/user.php"); // richiediamo il file che contiene la classe per la gestione degli utenti

header("Content-type: application/json; charset=UTF-8"); // impostiamo il tipo di risposta in formato JSON e l'encoding in UTF-8

$data = json_decode(file_get_contents("php://input")); // decodifichiamo i dati in formato JSON ricevuti dalla richiesta
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

if (empty($data)) { // se i dati ricevuti sono vuoti
    http_response_code(400); // impostiamo il codice di risposta HTTP a 400 (richiesta non valida)
    echo json_encode(["message" => "Fill every field"]); // inviamo un messaggio di errore al client
    die(); // interrompiamo l'esecuzione del codice
}

$db = new Database(); // creiamo un'istanza della classe per la connessione al database
$db_conn = $db->connect(); // effettuiamo la connessione al database
$user = new User($db_conn); // creiamo un'istanza della classe per la gestione degli utenti passando la connessione al database

$result = $user->getUsers(); // eseguiamo la funzione per ottenere tutti gli utenti presenti nel database
$records = array(); // creiamo un array vuoto per contenere i record degli utenti
while ($row = $result->fetch_assoc()) { // per ogni riga del risultato
    array_push($records, $row); // aggiungiamo la riga all'array di record
}
$dataLength = count($data); // otteniamo la lunghezza dei dati ricevuti
$recordsLength = count($records); // otteniamo la lunghezza dei record degli utenti
/*
[id] => 1
[name] => Mattia
[surname] => Gallo
[email] => mattia.gallinaro@iisviolamarchesini.edu.it
[password] => CA71@F
[active] => 1
*/

// Prendo tutte le classi esistenti
$result = $user->GetArchieveClass();
$classes = array();

// Inserisco tutte le classi in un array
while ($row = $result->fetch_assoc()) {
    array_push($classes, $row);
}

// Ciclo per ogni record presente nell'array $records
for ($i = 0; $i < $recordsLength; $i++) {
    // Imposto una variabile booleana per verificare se un record esiste o meno
    $presence = false;
    // Ciclo per ogni elemento dell'array $data
    for ($j = 0; $j < $dataLength; $j++) {
        // Se il nome e il cognome del record corrente corrispondono a quelli dell'elemento corrente
        if (strtolower($records[$i]["name"]) == strtolower($data[$j]->nome) && strtolower($records[$i]["surname"]) == strtolower($data[$j]->cognome)) {
            // Stampo un messaggio che indica che l'elemento è stato trovato e aggiornato
            echo $data[$j]->nome . " " . $data[$j]->cognome . " presente e aggiornato\n";
            // Imposto la variabile $presence a vera
            $presence = true;
            // Aggiorno l'utente con i nuovi dati
            $user->updateUser($records[$i]["id"], $data[$j]->nome, $data[$j]->cognome, $data[$j]->email, "", 1);

            // Prendo l'utente con i nuovi dati
            $result = $user->GetUserFromCredentials($data[$j]->nome, $data[$j]->cognome);
            $studente = array();
            while ($row = $result->fetch_assoc()) {
                array_push($studente, $row);
            }
            // Assegno l'ID dello studente alla variabile $studenteID
            $studenteID = $studente[0]["id"];

            // Ciclo per ogni classe presente nell'array $classes
            for ($x = 0; $x < count($classes); $x++) {
                // Se l'anno e la sezione della classe corrente corrispondono a quelli dell'elemento corrente
                if ($classes[$x]["year"] == $data[$j]->anno && $classes[$x]["section"] == $data[$j]->sezione) {
                    // Assegno lo studente alla classe
                    $user->UpdateClassUser($studenteID, $classes[$x]["id"]);
                    // Interrompo il ciclo
                    break;
                }
            }
            // Interrompo il ciclo interno
            break;
        }
    }
    if ($presence == false && $records[$i]["active"] == "1") {
        // Se la variabile $presence è falsa E la proprietà "active" dell'elemento corrente dell'array $records è uguale a "1" allora... Stampiamo un messaggio che indica che l'utente non è stato trovato e verrà disattivato
        echo $records[$i]["name"] . " " . $records[$i]["surname"] . " non trovato e disattivato\n";
        // Chiamiamo il metodo disactiveUser dell'oggetto $user, passando come parametro l'id dell'utente corrente
        $user->disactiveUser($records[$i]["id"]);
    }
}

// Variabile che contiene il risultato della funzione GetTotalUsers() dell'oggetto $user
$result = $user->getUsers();
// Creo un array vuoto per contenere i record
$records = array();

// Fetch associativo dei record
while ($row = $result->fetch_assoc()) {
    // Inserisco ogni record nell'array
    array_push($records, $row);
}

// Variabile che contiene la lunghezza dell'array dei record
$recordsLength = count($records);

// Ciclo che itera per ogni elemento dell'array $data
for ($i = 0; $i < $dataLength; $i++) {
    // Variabile che indica se un utente è già presente nell'elenco degli utenti
    $presence = false;
    // Ciclo che itera per ogni elemento dell'array $records
    for ($j = 0; $j < $recordsLength; $j++) {
        // Se il nome e il cognome dell'utente corrispondono a quelli del record corrente
        if (
            strtolower($records[$j]["name"]) == strtolower($data[$i]->nome)
            && strtolower($records[$j]["surname"]) == strtolower($data[$i]->cognome)
        ) {
            // Stampa un messaggio che indica che l'utente è già presente e non è stato modificato
            echo $data[$j]->nome . " " . $data[$j]->cognome . " presente e non cambiato\n";
            // Imposta la variabile $presence a true
            $presence = true;
            // Interrompe il ciclo
            break;
        }
    }
    // Se l'utente non è presente nell'elenco degli utenti
    if ($presence == false) {
        // Stampa un messaggio che indica che l'utente non è stato trovato e verrà aggiunto
        echo $data[$i]->nome . " " . $data[$i]->cognome . " non trovato e aggiunto\n";
        // Chiama la funzione importUser() dell'oggetto $user per importare l'utente con i suoi dati
        $user->importUser($data[$i]->nome, $data[$i]->cognome, $data[$i]->email);


        // Inizializziamo una variabile chiamata $result che contiene il risultato della funzione GetUserFromCredentials passando come parametri i valori contenuti in $data[$i]->nome e $data[$i]->cognome
        $result = $user->GetUserFromCredentials($data[$i]->nome, $data[$i]->cognome);
        // Inizializziamo un array vuoto chiamato $studente
        $studente = array();
        // Utilizziamo un ciclo while per andare a prendere ogni riga del risultato ottenuto dalla funzione GetUserFromCredentials e aggiungerlo all'array $studente
        while ($row = $result->fetch_assoc()) {
            array_push($studente, $row);
        }
        // Utilizziamo la funzione print_r per stampare l'id dello studente presente nella prima posizione dell'array $studente
        //print_r($studente[0]["id"]);
        // Inizializziamo una variabile chiamata $studenteID che contiene l'id dello studente presente nella prima posizione dell'array $studente
        $studenteID = $studente[0]["id"];
        // Utilizziamo un ciclo for per scorrere l'array $classes
        for ($x = 0; $x < count($classes); $x++) {
            // Utilizziamo un if per controllare se l'anno e la sezione dell'elemento corrente dell'array $classes sono uguali ai valori contenuti in $data[$i]->anno e $data[$i]->sezione
            if ($classes[$x]["year"] == $data[$i]->anno && $classes[$x]["section"] == $data[$i]->sezione) {
                // Utilizziamo la funzione addClassUser per associare la classe allo studente
                $user->addClassUser($studenteID, $classes[$x]["id"]);
                // Interrompiamo il ciclo una volta trovata la classe corretta
                break;
            }
        }
    }
}
die();