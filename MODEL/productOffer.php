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
        $stmt = sprintf("SELECT p.id as id
            from product_offer po
            inner join product p on p.id = po.product
            inner join `offer` o on o.id = po.`offer`
            where o.id = %d;",
            $this->conn->real_escape_string($id));

        $result = $this->conn->query($stmt);
        return $result;
        }
        function setProductOffer($product, $offer)
        {
            $query = sprintf("INSERT INTO `product_offer` (product, `offer`)
             VALUES (%d, %d)", 
             $this->conn->real_escape_string($product),
             $this->conn->real_escape_string($offer)
        );

            $stmt = $this->conn->query($query);
            //$stmt->bind_param("ii", $product, $offer);
            //$stmt->execute();
            
            return $stmt;
        }
    }
?>
