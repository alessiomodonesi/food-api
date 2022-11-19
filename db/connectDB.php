<?php
    // Properties
    define("DB_HOST", "localhost"); //da cambiare con l'host del server
    define("DB_USERNAME", "root"); //da cambiare con l'username del server
    define("DB_DATABASE_NAME", "sandwiches"); //eventualmente da cambiare con nuovo nome del db
    define("DB_PORT", "3306"); //non dovrebbe cambiare
    define("DB_PASSWORD", ""); //da settare se necessaria

    //Connection
    $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME, DB_PORT);
    echo var_dump($connection);

    if($connection === false)
    {
        die("<script>console.log('Errore di connessione!')<script>");
    }

    echo "<script>console.log('Connessione avvenuta con successo!')</script>";
?>