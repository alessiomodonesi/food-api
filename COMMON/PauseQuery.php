<?php

require __DIR__ . "../../COMMON/connect.php";
require  '../../COMMON/errorHandler.php';

class Pause
{
    private $table_name;

    private $id;
    private $time;
    private $pick_up; //oggetto PickUp

    private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getArchiveBreak()
    {
        // Da rivedere la query
        $sql = "SELECT id,time
            FROM break
            where 1=1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>