<?php
class Database
{
    //credentials evomatic
    protected $server = "192.168.100.1";
    protected $user = "itis";
    protected $passwd = "itis23K..";
    protected $db = "smart_sandwich_5f";

    //credentials localhost
    protected $server_local = "localhost";
    protected $user_local = "root";
    protected $passwd_local = "";
    protected $db_local = "sandwiches";

    //common credentials
    protected $port = "3306";
    public $conn;

    public function connect()//effettua la connessione al server
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