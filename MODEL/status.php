<?php
    class Status{

        protected $conn;
        protected $table_name = "status";

        protected $description;

        public function __construct($db)
        {
            $this->conn=$db;
        }

        public function getStatus($id) // Ottiene lo status che ha come id quello passato alla funzione
        {
            $query = "SELECT description FROM $this->table_name WHERE ID = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

    }
?>
