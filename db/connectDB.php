<?php
    define("DB_HOST", "localhost"); 
    define("DB_USERNAME", "root"); 
    define("DB_DATABASE_NAME", "sandwiches"); 
    define("DB_PORT", "3306"); 
    define("DB_PASSWORD", "");

    $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME, DB_PORT);
    echo var_dump($connection);

    if($connection === false)
        die("<script>console.log('Errore di connessione')<script>");
    
    echo "<script>console.log('Connessione avvenuta con successo')</script>";
?>