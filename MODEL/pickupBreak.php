<?php
class PickupBreak{
    protected $conn;
    protected $table_name='pickup_break';

    public $break_time;
    
    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function getPickupBreakId($id) // Ottiene l'associazione pickup, break che ha il break_id passato alla funzione   
    {
        $query = "SELECT pickup, break FROM $this->table_name WHERE break = $id";

        $stmt = $this->conn->query($query);

        return $stmt;
    }
    
    public function getPickupIdBreak($id) // Ottiene l'associazione pickup, break che ha il pickup_id passato alla funzione  
    {
        $query = "SELECT pickup, break FROM $this->table_name WHERE pickup = $id";

        $stmt = $this->conn->query($query);

        return $stmt;
    }
}
?>