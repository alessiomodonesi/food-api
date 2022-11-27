<?php
    class IngredientTag
    {
        protected $conn;
        protected $table_name = "ingredient_tag";
        
        protected $ingredient_ID;
        protected $tag_ID;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        function deleteIngredientTag($ingredient_ID, $tag_ID)
        {
            $query = "DELETE FROM $this->table_name WHERE ingredient_ID = $ingredient_ID AND tag_ID = $tag_ID";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function setIngredientTag($ingredient_ID, $tag_ID)
        {
            $query = "INSERT INTO $this->table_name (ingredient_ID, tag_ID) VALUES (?, ?)";

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