<?php
    class Offer
    {
        protected $table_name = "offer";
        protected $conn;

        protected $price;
        protected $expiry;
        protected $description;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        function getArchiveOffer()//ritorna tutte le offerte attive e non
        {
            $query = "SELECT * FROM $this->table_name";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getOffer($ID)//ritorna una specifica offerta
        {
            $query = "SELECT * FROM $this->table_name WHERE ID = $ID";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function createOffer($price,$start ,$expiry, $description)//crea una nuova offerta con validitá di 1 settimana
        {
            $query = "INSERT INTO $this->table_name (price, start, expiry, description) VALUES (?,?, ?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('siis', $price, $start, $expiry, $description);

            if($stmt->execute()){
                return $stmt;
            }else{
                echo("Error: " . $stmt->error . "\n");
                return "";
            }
        }

        function setOfferExpiry($ID, $expiry)
        {
            $query = "UPDATE $this->table_name SET expiry = '$expiry' WHERE ID = $ID";

            $stmt = $this->conn->query($query);

            return $this->conn->affected_rows;
        }
    }
?>