<?php
    class ProductOffer
    {
        protected $conn;
        protected $table_name = "product_offer";

        protected $product;
        protected $offer;

        public function __construct($db)
        {
            $this->conn = $db;
        }
        
        function setProductOffer($product, $offer)
        {
            $query = "INSERT INTO $this->table_name (product, offer) VALUES (?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $product, $offer);
            $stmt->execute();
            
            return $stmt->affected_rows;
        }
    }
?>
