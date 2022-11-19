<?php
    // Properties
    define("DB_HOST", "localhost");
    define("DB_USERNAME", "root");
    define("DB_DATABASE_NAME", "sandwiches");
    define("DB_PORT", "3306");
    define("DB_PASSWORD", "");

    //Connection
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME, DB_PORT);
    //echo print_r($conn);

    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);
?>