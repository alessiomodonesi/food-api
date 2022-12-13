<?php
class Database
{
    //credentials evomatic - richiede vpn + accesso
    protected $server_evomatic = "192.168.100.1";
    protected $user_evomatic = "itis";
    protected $passwd_evomatic = "itis23K..";

    //credentials claudiodressadore
    protected $server_claudio = "claudiodressadore.net";
    protected $user_claudio = "evomatic";
    protected $passwd_claudio = "evomatic2022";

    //credentials localhost
    protected $server_local = "localhost";
    protected $user_local = "root";
    protected $passwd_local = "";

    //common credentials
    protected $db = "sandwiches";
    protected $port = "3306";
    public $conn;

    public function connect()
    {
        try {
            $this->conn = new mysqli($this->server_claudio, $this->user_claudio, $this->passwd_claudio, $this->db, $this->port);
        } catch (mysqli $ex) {
            die("Error connecting to database $ex\n\n");
        }
        return $this->conn;
    }
}