<?php 
    Class Order
    {
        protected $conn;
        protected $table_name = "`order`";

        protected $user_ID;
        protected $total_price;
        protected $date_hour_sale;
        protected $break_ID;
        protected $status_ID;
        protected $pickup_ID;
        protected $json;


        //chi deve calcolare il prezzo totale del carrello? quelli che fanno il carrello

        public function __construct($db)
        {
            $this->conn = $db;
        }

        function getArchiveOrder() // Ottiene tutti gli ordini
        {
            $query = "SELECT * FROM $this->table_name";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getOrder($id) // Ottiene l'ordine con l'id passato alla funzione
        {
            $query = "SELECT * FROM $this->table_name WHERE id = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getArchiveOrderStatus($id) // Ottiene gli ordini in base allo stato
        {
            $query = "SELECT * FROM $this->table_name WHERE status = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getArchiveOrderBreak($id) // Ottiene gli ordini in base alla ricreazione
        {
            $query = "SELECT * FROM $this->table_name WHERE break = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function getArchiveOrderUser($id) // Ottiene gli ordini in base alla ricreazione
        {
            $query = "SELECT * FROM $this->table_name WHERE user = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        function delete($id){ // Annulla un ordine

            $query = "UPDATE $this->table_name SET status = 3 WHERE id = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }

        
        function setStatus($id){ // setta lo stato di un ordine a 2, pronto

            $query = "UPDATE $this->table_name SET status = 2 WHERE id = $id";

            $stmt = $this->conn->query($query);

            return $stmt;
        }


        /*
            Esempio body da passare alla funzione

            {
                "user_ID": 1,
                "total_price": 15.50,
                "break_ID": 1,
                "status_ID": 1,
                "pickup_ID": 1,
                "products": [
                        {"ID": 1, "quantity": 1},
                        {"ID": 2, "quantity": 1},
                        {"ID": 3, "quantity": 2}
                    ],
                "json": {
                "user_ID": 1,
                "total_price": 15.50,
                "break_ID": 1,
                "status_ID": 1,
                "pickup_ID": 1,
                "products": [
                        {"name": "panino al prosciutto", "price": 3, "quantity":1},
                        {"name": "panino al salame", "price": 3, "quantity":1},
                        {"name": "panino proteico", "price": 3, "quantity":2}
                    ]
                }
            }
        */
        /*
        'id' => $id,
        'user' => $user,
        'created' => $created,
        'pickup' => $pickup,
        'break' => $break,
        'status' => $status,
        'json' => json_decode($json)
        */
        function setOrder($user_ID, $break_ID, $status_ID, $pickup_ID, $json){ // Crea un ordine di vetrina

            $query = "INSERT INTO $this->table_name (`user`,break, status, pickup, json)
                      VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('iiiis', $user_ID,  $break_ID, $status_ID, $pickup_ID, $json);
            if ($stmt->execute())
            {
                return $stmt;
            }
            else
            {
                return "";
            }
        }
        function getProductsOrder(){
        $sql = "SELECT po.product, p.name ,count(po.product) as 'quantity'
        from product_order po
        inner join `order` o on o.id = po.`order`
        inner join product p on p.id = po.product 
        where o.status = 1 and o.created > Now() - interval 6 hour and o.created < Now() + interval 6 hour 
        group by po.product ;";

        $result = $this->conn->query($sql);

        return $result;
        }

        function getOrderByClassAndBreak(){
        $sql = "SELECT c.id, c.`year` , c.`section` , o.break , count(po.product) as quantity, po.product  
            from product_order po 
            inner join `order` o on o.id = po.`order`
            inner join user_class uc on uc.`user` = o.`user` 
            inner join class c on c.id = uc.class 
            group by c.id , o.break ;";

        $result = $this->conn->query($sql);

        return $result;
        }
        
    }
?>