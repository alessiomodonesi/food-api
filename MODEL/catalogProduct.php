<?php 
    Class CatalogProduct
    {
        protected $catalogue_ID;
        protected $product_ID;
        protected $conn;

        protected $table_name = "catalogue_product";

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function getCatalogueProduct($id)
        {
            $query = "SELECT * FROM $this->table_name WHERE catalogue_ID=$id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }
    }
?>