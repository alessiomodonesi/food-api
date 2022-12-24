<?php
class Database
{
    //credentials evomatic
    private $server = "192.168.100.1";
    private $user = "itis";
    private $passwd = "itis23K..";
    private $db = "smart_sandwich_5f";

    //credentials localhost
    private $server_local = "localhost";
    private $user_local = "root";
    private $passwd_local = "";
    private $db_local = "sandwiches";

    //common credentials
    private $port = "3306";
    public $conn;

    public function connect() //effettua la connessione al server

    {
        try {
            $this->conn = new mysqli($this->server_local, $this->user_local, $this->passwd_local, $this->db_local, $this->port);
        }
        //la classe mysqli non estende l'interfaccia Throwable e non può essere usata come un'eccezione. 
        catch (Exception $ex) {
            die("Error connecting to database $ex\n\n");
        }
        return $this->conn;
    }
}