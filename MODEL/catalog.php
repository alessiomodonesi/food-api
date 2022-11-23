<?php 
    Class Catalog
    {
        protected $ID;
        protected $catalogue_name;
        protected $validity_start_date;
        protected $validity_end_date;
        protected $conn;

        protected $table_name = "catalog";

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function getArchiveCatalog() // tutti
        {
            $query = "SELECT * FROM $this->table_name WHERE 1=1";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        public function getCatalog($id) // catalogo con id passato alla funzione
        {
            $query = "SELECT * FROM $this->table_name WHERE ID = $id";
            
            $stmt = $this->conn->query($query);

            return $stmt;
        }

        public function getArchiveProductInCatalog($catalog_id) // tutti i prodotti in un catalogo
        {
            $query = "SELECT * FROM $this->table_name WHERE ID=$catalog_id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }
    }
?>