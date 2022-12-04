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

        function getArchiveOffer()
        {
            $query = "SELECT * FROM $this->table_name";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getOffer($ID)
        {
            $query = "SELECT * FROM $this->table_name WHERE ID = $ID";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function createOffer($price, $expiry, $description)
        {
            $query = "INSERT INTO $this->table_name (price, expiry, description) VALUES (?, ?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sss', $price, $expiry, $description);

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