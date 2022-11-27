<?php
    class Offer
    {
        protected $table_name = "special_offer";
        protected $conn;

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
            $query = "INSERT INTO $this->table_name (title, description, offer_code, validity_start_date, validity_end_date)
                      VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssss", $title, $description, $offer_code, $validity_start_date, $validity_end_date)

            if($stmt->execute()){
                return $stmt;
            }else{
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