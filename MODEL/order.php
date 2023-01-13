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

    public function getActiveOrdersByClass()
    {
        $sql = "SELECT c.id, c.`year`, c.`section`
        FROM class c 
        WHERE 1=1";

        $classes = $this->conn->query($sql);

        unset($sql);
        $orders = array();
        $year = date("Y");//ottiene l'anno corrente
        while($row =  $classes->fetch_assoc()){

            $sql = sprintf("SELECT c.id as id_classe, c.`year` as anno_classe , c.`section` as sezione, o.id as id_ordine
            FROM `order` o
            INNER JOIN `user` u on u.id = o.`user`
            INNER JOIN user_class uc on uc.`user` = u.id
            INNER JOIN class c on c.id = uc.class
            WHERE c.`year` =  %d and c.`section` = '%s' and o.status = 1 and uc.`year` = %d or uc.`year` = %d;  ",
            $this->conn->real_escape_string($row['year']),
            $this->conn->real_escape_string($row['section']),
            $this->conn->real_escape_string($year - 1),
            $this->conn->real_escape_string($year),
            )
        ;

            $result = $this->conn->query($sql);
            while($row_col = $result->fetch_assoc()){
                array_push($orders, $row_col);
            }
            unset($sql);
            unset($result);
        }

        return $orders;
    }

    public function getActiveOrdersByPickup(){
        $sql = "SELECT p.id, p.name
        FROM pickup p
        WHERE 1=1";

        $pickup_points = $this->conn->query($sql);

        unset($sql);
        $orders =  array();
        while($row = $pickup_points->fetch_assoc()){
            $sql = sprintf("SELECT p.name as Punto_di_consegna, o.id as Id_Ordine , concat(u.name ,' ', u.surname) as Utente
            FROM `order` o
            INNER JOIN pickup p on p.id = o.pickup
            INNER JOIN `user` u on u.id = o.`user`
            WHERE o.status = 1 and p.id = %d",
            $this->conn->real_escape_string($row['id']));

            $result = $this->conn->query($sql);

            unset($sql);
            while($single_ord = $result->fetch_assoc()){
                array_push($orders, $single_ord);
            }
            unset($result);
        }
        return $orders;
    }
    public function getActiveOrdersByBreak(){
        $sql = "SELECT b.id , b.time
        FROM break b
        WHERE 1=1";

        $break_times = $this->conn->query($sql);

        unset($sql);
        $orders = array();
        while($time =  $break_times->fetch_assoc()){
            $sql = sprintf("SELECT b.time as Orario_della_ricreazione,  o.id as Id_Ordine, concat(u.name , u.surname) as Utente
            FROM `order` o 
            INNER JOIN break b on b.id = o.break
            INNER JOIN `user` u on u.id = o.`user`
            WHERE o.status = 1 and b.id = %d", 
            $this->conn->real_escape_string($time['id']));

            $result = $this->conn->query($sql);
            unset($sql);
            while($single_ord = $result->fetch_assoc()){
                array_push($orders, $single_ord);
            }
            unset($result);

        }
        return $orders;
    }
}
?>