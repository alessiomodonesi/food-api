<?php
    class Allergen
    {
        protected $conn;
        protected $table_name = "allergen";

        protected $name;


        public function __construct($db)
        {
            $this->conn = $db; 
        }
        
        function getArchiveAllergen()
        {
            $query = "SELECT * FROM $this->table_name";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function createAllergen($name)
        {
            $query = "INSERT INTO $this->table_name (name) VALUES (?)";

            $stmt = $this->conn->prepare($query);

            $stmt->bind_param('s', $name);
            $stmt->execute();
            
            return $this->conn->affected_rows;
        }

        function getAllergen($id)
        {
            $query = "SELECT * FROM $this->table_name WHERE ID = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        
    }
?>