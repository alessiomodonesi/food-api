<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class PickUp
{
    protected $conn;

    
    public function __construct($db)
    {
        $this->conn=$db;
    }

    /*private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }*/


    public function getArchivePickup()
    {
        // Da rivedere la query
        $sql = "SELECT id,name
            FROM pickup
            WHERE 1=1";

        return $this->conn->query($sql);

        /*$stmt = $this->conn->prepare($sql);

        return $stmt->execute();*/
    }
}
