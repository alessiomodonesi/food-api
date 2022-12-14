<?php 
    Class OrderProduct
    {
        protected $conn;
        protected $table_name = "product_order";

        protected $user_ID;
        protected $product_ID;

        public function __construct($db)//assegna la connessione al db alla variabile conn
        {
            $this->conn = $db;
        }

        function setOrderProduct($order_ID, $products) // setta i prodotti di un determinato ordine
        {
            $query = "INSERT INTO $this->table_name (`order`, `product`) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);

            foreach(json_decode($products, true) as $product)
            {
                $stmt->bind_param('ii', $order_ID, $product['ID']); // lega i parametri alla query e le dice quali sono i paramentri
                $stmt->execute();
            }
        }

        function getOrderProduct($order_ID) // Ottiene i record della tabella order_product che hanno come order_ID quello passato alla funzione
        {
            $query = "SELECT * FROM $this->table_name WHERE `order` = $order_ID";

            $stmt = $this->conn->query($query);

            return $stmt;
        }
    }
?>
