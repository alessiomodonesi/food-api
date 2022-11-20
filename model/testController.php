<?php
    require("baseController.php");
    class TestController extends BaseController
    {   
        public function CheckIngredient() //stampa tutti gli ingredienti
        {
            $sql = "select distinct name as 'Nome ingrediente', available_quantity as 'Quantita disponibile'
                    from ingredient
                    order by ID;";

            $result = $this->conn->query($sql);
            $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        }
        public function CheckProduct() //stampa tutti i prodotti
        {
            $sql = "select distinct name as 'Nome prodotto', quantity as 'Quantita disponibile'
                    from product 
                    order by ID;";

            $result = $this->conn->query($sql);
            $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        }
    }
?>