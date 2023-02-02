<?php

// Recuperiamo i dati inviati tramite il metodo POST
$data = json_decode(file_get_contents("php://input")); //con questa funzione decodifichiamo i dati inviati tramite il metodo POST in formato JSON
if (empty($data) || empty($data->mail) || empty($data->password)) { //verifichiamo che i dati siano stati passati correttamente
    echo json_encode(["message" => "Riempi tutti i campi"]); //se i campi non sono stati compilati correttamente, inviamo un messaggio di errore
    die();
}

$server_db = "localhost"; // Indirizzo del server
$user_db = "utente12"; // Nome utente per accedere al database
$passwd_db = "passWor4d"; // Password per accedere al database
$db_name = "DB_test"; // Nome del database
$port = "3306";
$conn;

try {
    $conn = new mysqli($server_db, $user_db, $passwd_db, $db_name, $port); //creiamo una nuova connessione al database utilizzando la classe mysqli
} catch (Exception $ex) {
    die("Error connecting to database $ex\n\n"); //se c'è un errore durante la connessione al database, visualizziamo un messaggio di errore
}

$query = "SELECT email, password FROM user_table WHERE email='$data->mail' AND password='$data->password'"; //creiamo la query per verificare se l'utente esiste nel database
$result = $conn->query($query); //eseguiamo la query

$response = null;
if ($result->fetch_assoc() > 0) { //controlliamo se l'utente esiste nel database
    $response = true;
} else {
    $response = false;
}

echo $response; //inviamo la risposta
/*
In questo codice, utilizziamo la classe mysqli per creare una connessione al database DB_test.
Utilizziamo la funzione json_decode() per decodificare i dati inviati tramite il metodo POST 
in formato JSON e verifichiamo che i dati siano stati passati correttamente. Creiamo quindi 
una query per verificare se l'utente esiste nel database con le credenziali fornite. La query 
viene eseguita utilizzando la funzione query() dell'oggetto $conn. Viene quindi controllato se 
l'utente esiste nel database utilizzando la funzione fetch_assoc(). Se l'utente esiste, la risposta 
viene impostata su true, altrimenti su false. Infine, la risposta viene inviata con la funzione echo.



La funzione file_get_contents("php://input") in PHP consente di leggere i dati inviati in 
una richiesta HTTP, come ad esempio i dati inviati in una richiesta POST. La stringa "php://input" 
è una sorgente di lettura speciale che consente di accedere ai dati della richiesta, 
indipendentemente dal tipo di richiesta (GET, POST, ecc.). Questo può essere utile per 
lavorare con dati inviati in formato raw, come ad esempio in una richiesta JSON.



La funzione fetch_assoc() è un metodo di estensione delle funzioni di estrazione dei risultati 
delle query in PHP 7.4. Consente di estrarre una riga dal set di risultati come un array associativo, 
dove i nomi delle colonne diventano le chiavi dell'array e i valori delle colonne diventano i valori dell'array.

Questa funzione è particolarmente utile quando si lavora con database e si vogliono estrarre i 
dati dalle query per elaborarli in modo efficiente. Invece di utilizzare la funzione fetch_row() 
che restituisce un array numerico, fetch_assoc() restituisce un array associativo che consente 
di accedere ai valori della riga utilizzando i nomi delle colonne come chiavi.

Esempio:
$result = mysqli_query($conn, "SELECT * FROM users");

while ($row = mysqli_fetch_assoc($result)) {
    echo $row["username"] . " - " . $row["email"];
}

In questo esempio si estraggono i dati dalla query eseguita e 
si stampa l'username e l'email per ogni riga.



La funzione query() è un metodo della classe mysqli in PHP 7.4. consente di eseguire una 
query SQL su un database MySQL. Questa funzione restituisce un oggetto di tipo mysqli_result 
che contiene i risultati della query, se la query è stata eseguita con successo. In caso contrario,
 restituisce FALSE.
*/
?>