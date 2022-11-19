<?php
require("controller.php");
class Product extends Controller
{
    public function CheckProduct()//Mostro prodotti disponibili e loro quantità
    {
        $sql = "select distinct p.name as 'Nome prodotto',p.quantity as 'Quantita disponibile'
                from product p
                order by p.ID;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
}