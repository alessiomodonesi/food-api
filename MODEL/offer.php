<?php
    class Offer
    {
        protected $table_name = "special_offer";
        protected $conn;

        protected $title;
        protected $description;
        protected $offer_code;
        protected $validity_start_date;
        protected $validity_end_date;

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

        function createOffer($title, $description, $offer_code, $validity_start_date, $validity_end_date)
        {
            $query = "INSERT INTO special_offer (title, description, offer_code, validity_start_date, validity_end_date) VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssss', $title, $description, $offer_code, $validity_start_date, $validity_end_date);

            if($stmt->execute()){
                return $stmt;
            }else{
                echo("Error: " . $stmt->error . "\n");
                return "";
            }
        }

        function setOfferValidity($ID, $validity_start_date, $validity_end_date)
        {
            $query = "UPDATE $this->table_name SET validity_start_date = $validity_start_date, validity_end_date = $validity_end_date WHERE ID = $ID";

            $stmt = $this->conn->query($query);

            return $stmt;
        }
    }
?>