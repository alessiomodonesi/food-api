<?php
    class Tag
    {
        protected $conn;
        protected $table_name = "tag";
        protected $middle_table_name = "ingredient_tag";

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

            if($stmt->execute()){
                return $stmt;
            }else{
                return "";
            }
        }

        function deleteIngredientTag($ingredient_ID, $tag_ID)
        {
            $query = "DELETE FROM $this->middle_table_name WHERE ingredient_ID = $ingredient_ID AND tag_ID = $tag_ID";

            $stmt = $this->conn->query($query);

            return $stmt;
        }


        function getTag($id)
        {
            $query = "SELECT * FROM $this->table_name WHERE ID = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function setIngredientTag($ingredient_ID, $tag_ID)
        {
            $query = "INSERT INTO $this->middle_table_name (ingredient_ID, tag_ID) VALUES (?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ii', $ingredient_ID, $tag_ID);

            if($stmt->execute()){
                return $stmt;
            }else{
                return "";
            }
        }
    }
?>