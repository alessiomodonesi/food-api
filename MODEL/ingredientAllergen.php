<?php
    class IngredientAllergen
    {
        protected $conn;
        protected $table_name = "ingredient_allergen";
        
        protected $ingredient;
        protected $allergen;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        function deleteIngredientAllergen($ingredient, $allergen)
        {
            $query = "DELETE FROM $this->table_name WHERE ingredient = $ingredient AND allergen = $allergen";

            $stmt = $this->conn->query($query);

            return $this->conn->affected_rows;
        }

        function setIngredientAllergen($ingredient, $allergen)
        {
            $query = "INSERT INTO $this->table_name (ingredient, allergen) VALUES (?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ii', $ingredient, $allergen);
            $stmt->execute();
            return $this->conn->affected_rows;
        }
    }
?>