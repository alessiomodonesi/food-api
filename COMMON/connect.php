<?php 
Class Database
{
    protected $serverName = "localhost";
    protected $dbName = "sandwiches";
    protected $username = "root";
    protected $password = "";
    public $conn;

    public function connect()
    {
        try
        {
            $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->dbName);
        }
        catch (mysqli $ex)
        {
            die ("Error connecting to database $ex\n\n");
        }
        return $this->conn;
    }
}
?>
