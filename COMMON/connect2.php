<?php
class Connect
{
    private $conn = null;

    public function __construct()
    {
        //credentials evomatic
        $server_evomatic = "192.168.100.1";
        $user_evomatic = "itis";
        $passwd_evomatic = "itis23K..";

        //credentials claudiodressadore
        $server_claudio = "claudiodressadore.net";
        $user_claudio = "evomatic";
        $passwd_claudio = "evomatic2022";

        //credentials localhost
        $server_local = "localhost";
        $user_local = "root";
        $passwd_local = "";

        //common credentials
        $db = "sandwiches";
        $port = "3306";

        try {
            $this->conn = new PDO(
                "mysql:host=$server_claudio;port=$port;charset=utf8mb4;dbname=$db",
                $user_claudio,
                $passwd_claudio
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
