<?php 
Class Database
{
    protected $server = "claudiodressadore.net";
    protected $db = "sandwiches";
    protected $username = "evomatic";
    protected $password = "evomatic2022";
    protected $port = "3306";
    public $conn;

    public function connect()
    {
        try
        {
            $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db, $this->port);
        }
        catch (mysqli $ex)
        {
            die ("Error connecting to database $ex\n\n");
        }
        return $this->conn;
    }
}
?>
