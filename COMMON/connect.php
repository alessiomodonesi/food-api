<?php 
Class Database
{
    protected $server = "claudiodressadore";
    protected $db = "sandwiches";
    protected $username = "evomatic";
    protected $password = "evomatic2022";
    protected $server_local = "localhost";
    protected $username_local = "root";
    protected $password_local = "";
    protected $port = "3306";
    public $conn;

    public function connect()
    {
        try
        {
            $this->conn = new mysqli($this->server_local, $this->username_local, $this->password_local, $this->db, $this->port);
        }
        catch (mysqli $ex)
        {
            die ("Error connecting to database $ex\n\n");
        }
        return $this->conn;
    }
}
?>
