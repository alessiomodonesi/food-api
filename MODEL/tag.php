<?php
    class Tag
    {
        protected $conn;
        protected $table_name = "tag";

        protected $tag;


        public function __construct($db)
        {
            $this->conn = $db; 
        }
        
        function getArchiveTag()
        {
            $query = "SELECT * FROM $this->table_name";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function createTag($tag)
        {
            $query = "INSERT INTO $this->table_name (tag) VALUES (?)";

            $stmt = $this->conn->prepare($query);

            $stmt->bind_param('s', $tag);
            $stmt->execute();
            
            return $this->conn->affected_rows;
        }

        function getTag($id)
        {
            $query = "SELECT * FROM $this->table_name WHERE tag_ID = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        
    }
?>