<?php
class Connect
{
    private $dbConnection = null;

    public function __construct()
    {
        $host = "claudiodressadore.net";
        $port = "3306";
        $db   = "sandwiches";
        $user = "evomatic";
        $pass = "evomatic2022";

        try {
            $this->dbConnection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
