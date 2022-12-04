<?php
require("base.php");
class ProductController extends BaseController
{
    public function GetProduct($product_id) //mostra un singolo prodotto
    {
        $sql = "SELECT distinct p.id as 'ID',p.name as 'Nome prodotto', p.price as 'Prezzo', t.name as 'Tag'
                from product p
                left join product_tag pt on pt.product=p.id
                left join tag t on t.id=pt.tag
                where p.id = ". $product_id . ";";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function GetArchiveProducts() //mostra tutti i prodotti
    {
        $sql = "SELECT distinct p.id as 'ID',p.name as 'Nome prodotto', p.price as 'Prezzo', t.name as 'Tag'
                from product p
                left join product_tag pt on pt.product=p.id
                left join tag t on t.id=pt.tag
                ";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function GetArchiveIngredients()
    {
        $sql = "select i.id as 'ID',i.name as 'Nome ingrediente', i.quantity as 'Quantita', i.description as 'Descrizione',p.name as 'Prodotto in cui e contenuto'
                from ingredient i
                left join product_ingredient pi on pi.ingredient=i.id
                left join product p on p.id=pi.product 
                ";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }

    public function GetIngredient($ingredient_ID){
        $sql = "select i.id as 'ID',i.name as 'Nome ingrediente', i.quantity as 'Quantita', i.description as 'Descrizione',p.name as 'Prodotto in cui e contenuto'
                from ingredient i
                left join product_ingredient pi on pi.ingredient=i.id
                left join product p on p.id=pi.product 
                where i.id =". $ingredient_ID . ";";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }

    public function CheckIngredient() //Mostro ingredienti disponibili e loro quantità

    {
        $sql = "select distinct i.name, i.price,i.quantity
                from ingredient i
                order by i.id;";

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    public function CheckProduct() //Mostro prodotti disponibili e loro quantità

    {
        $sql = "select distinct p.id,p.name, p.quantity, nv.kcal
                from product p
                left join nutritional_value nv on nv.id= p.nutritional_value
                where p.active=1;";

        /*$sql = "select distinct p.name, p.quantity
        from product p
        order by p.ID;";*/

        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }
    //DA RIVEDERE POTREBBE ESSERE INUTILE
    /*public function DeleteIngredient($ingredient_ID) //Non mostra l'ingrediente finito di cui gli si passa l'id--in fase di progettazione

    {
        //delete from ingredient WHERE  ID= '$ingredient_ID';---query per eliminare record ma non si può usare causa FOREIGN KEY
        $sql = "select distinct i.name, i.available_quantity
        from ingredient i
        where i.ID<" . $ingredient_ID . " or i.ID>" . $ingredient_ID . ";";
        

        $sql = "update ingredient i
                set i.active = 0
                where i.ID=" . $ingredient_ID . ";";
        $result = $this->conn->query($sql);
        $this->CheckIngredient();
    }*/
    public function setIngredient($name, $description, $price,$quantity)
    {
        $sql = "insert into ingredient(name, description, price,quantity)
        values
        (" . $name . "," . $description . "," . $price . "," . $quantity . ");";

        $this->conn->query($sql);
        $this->CheckIngredient();
    }
    public function setProduct($name, $price, $description, $quantity, $nutritional_value,$active)
    {
        $sql = "insert into product(name, price, description, quantity, nutritional_value,active)
                values
                (" . $name . ", " . $price . ", " . $description . ", " . $quantity . ", " .$nutritional_value . ", " .$active . ");";

        $this->conn->query($sql);
        $this->CheckProduct();
    }

    public function DeleteProduct($product_ID)
    {
        $sql = "update product p
                set p.active = 0
                where p.id = " . $product_ID . ";";

        $result = $this->conn->query($sql);
        $nRows = mysqli_affected_rows($this->conn); //ottiene il numero di righe cambiato dopo una query
        $this->SendState($result, JSON_OK);
        $this->CheckProduct();
    }

    public function ReActiveProduct($product_ID)
    {
        $sql = "update product p
                set p.active = 1
                where p.id = " . $product_ID . ";";

        $result = $this->conn->query($sql);
        $nRows = mysqli_affected_rows($this->conn);
        $this->SendState($result, JSON_OK);
        $this->CheckProduct();
    }
}