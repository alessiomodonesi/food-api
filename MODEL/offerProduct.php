<?php
    class OfferProduct
    {
        protected $conn;
        protected $table_name = "offer_category";

        protected $offer_ID;
        protected $category_ID;

        public function __construct($db)
        {
            $this->conn = $db;
        }
        

        function setOfferCategory($offer_ID, $category_ID)
        {
            $query = "INSERT INTO $this->table_name (offer_ID, category_ID) VALUES (?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $offer_ID, $category_ID);
            $stmt->execute();
            
            return $stmt->affected_rows;
        }
    }
?>
