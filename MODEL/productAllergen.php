<?php
    class ProductAllergen
    {
        protected $conn;
        protected $table_name = "product_allergen";
        
        protected $product;
        protected $allergen;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        function deleteProductAllergen($product, $allergen)
        {
            $query = "DELETE FROM $this->table_name WHERE product = $product AND allergen = $allergen";

            $stmt = $this->conn->query($query);

            return $this->conn->affected_rows;
        }

        function setProductAllergen($product, $allergen)
        {
            $query = "INSERT INTO $this->table_name (product, allergen) VALUES (?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ii', $product, $allergen);
            $stmt->execute();
            return $this->conn->affected_rows;
        }
    }
?>