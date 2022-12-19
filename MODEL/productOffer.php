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
        function getOfferProduct($id){
        $stmt = sprintf("SELECT p.id 
            from product_offer po
            inner join product p on p.id = po.product
            where p.id ",
            $this->conn->real_escape_string($id));

        $result = $this->conn->query($stmt);
        return $result;
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
