<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Pause
{
    private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getArchiveBreak()
    {
        $sql = "SELECT id,time
            FROM break
            where 1=1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBreakByPickup($pickup_id) 
    {
        $sql = "SELECT break.time, pickup.name
                FROM pickup_break
                INNER JOIN break ON break.id = pickup_break.break
                INNER JOIN pickup ON pickup.id = pickup_break.pickup
                WHERE pickup_break.pickup = :pickup_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':pickup_id', $pickup_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}