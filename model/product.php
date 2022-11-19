<?php
require("controller.php");

class Product extends Controller
{
    public function GetArchiveProducts()
    {
        $sql = "select distinct p.ID, p.name, p.price
                from product p
                order by p.ID;";

        $result = $this->conn->query($sql);
        $this->sendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }

    public function GetArchiveIngredients()
    {
        $sql = "select distinct i.ID, i.name
                from ingredient i
                order by i.ID;";

        $result = $this->conn->query($sql);
        $this->sendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
}