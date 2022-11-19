<?php
require("BaseController.php");
class ProductController extends BaseController
{
    public function CheckIngredient()//Mostro ingredienti disponibili e loro quantità
    {
        $sql = "select distinct i.name as 'Nome ingrediente',i.available_quantity as 'Quantita disponibile'
                from ingredient i
                order by i.ID;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
    public function CheckProduct()//Mostro prodotti disponibili e loro quantità
    {
        $sql = "select distinct p.name as 'Nome prodotto',p.quantity as 'Quantita disponibile'
                from product p
                order by p.ID;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
}