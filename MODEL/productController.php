<?php
require("BaseController.php");
class ProductController extends BaseController
{
    public function GetArchieveProduct()
    {
        $sql = "select distinct p.ID, p.name, p.price
                from product p
                order by p.ID;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
    public function CheckIngredient() //Mostro ingredienti disponibili e loro quantità

    {
        $sql = "select distinct i.name as 'Nome ingrediente',i.available_quantity as 'Quantita disponibile'
                from ingredient i
                order by i.ID;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
    public function CheckProduct() //Mostro prodotti disponibili e loro quantità

    {
        $sql = "select distinct p.name as 'Nome prodotto',p.quantity as 'Quantita disponibile'
                from product p
                order by p.ID;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
    public function DeleteIngredient($ingredient_ID) //Non mostra l'ingrediente finito di cui gli si passa l'id--in fase di progettazione

    {

        //delete from ingredient WHERE  ID= '$ingredient_ID';---query per eliminare record ma non si può usare causa FOREIGN KEY
        $sql = "select distinct i.name as 'Nome ingrediente',i.available_quantity as 'Quantita disponibile'
                from ingredient i
                where i.ID<" . $ingredient_ID . " or i.ID>" . $ingredient_ID . ";";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
    public function DeleteProduct()
    {
    }
    public function GetArchiveIngredients($product_ID)
    {
        $sql = "select i.name, pi2.ingredient_quantity, i.available_quantity, i.description
                from product p
                left join product_ingredient pi2 on p.ID = pi2.product_ID
                left join ingredient i on i.ID = pi2.ingredient_ID
                left join category c on c.ID = p.category_ID
                where p.ID = " . $product_ID . " and c.name = 'panino' or c.name = 'piadina';";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
    public function SetIngredient()
    {
    }
    public function SetProduct()
    {
    }
    public function AddIngredient($ingredient)
    {
        $sql = "insert into ingredient(name, description, available_quantity)
        values
        (" . $ingredient["name"] . "," . $ingredient["description"] . "," . $ingredient["available_quantity"] . ")";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
    public function AddProduct($product)
    {
        //insert into product(name, price, description, quantity, category_ID, nutritional_value_ID)
        $sql = "insert into product(name, price, description, quantity, category_ID, nutritional_value_ID)
                values
                (" . $product["name"] . ", " . $product["price"] . ", " . $product["description"] . ", " . $product["quantity"] . ", " . $product["category_ID"] . ", " . $product["nutritional_value_ID"] . ");";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
    }
}
