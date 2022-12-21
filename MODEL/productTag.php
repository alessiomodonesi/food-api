<?php

/**
 * Modello per le API che riguardano la tabella di mezzo prodotto-tag
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
 */

class ProductTag
{
    protected $conn;
    protected $table_name = 'product_tag';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    /**
     * Per la non possibilità di realizzare un overload dei metodi, è stato necessario scrivere
     * tre metodi diversi per realizzare la query dell'API getArchiveProductTag.
     **/

    public function getArchiveProductTag()
    {
        $query = "SELECT product, tag FROM $this->table_name";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function getArchiveProductTagWithProductID($product_id)
    {
        $query = "SELECT product, tag FROM $this->table_name WHERE product=$product_id";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function getArchiveProductTagWithTagID($tag_id)
    {
        $query = "SELECT product, tag FROM $this->table_name WHERE tag=$tag_id";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function setProductTag($product_id, $tag_id)
    {
        $query = "INSERT INTO $this->table_name (product, tag) VALUES($product_id, $tag_id)";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function deleteProductTag($product_id, $tag_id)
    {
        $query = "DELETE FROM $this->table_name WHERE product = $product_id AND tag = $tag_id";
        $stmt = $this->conn->query($query);
        return $stmt;
    }
    public function GetTagFromProduct($product_id){
        $query = sprintf("SELECT pt.tag
        from product p
        inner join product_tag pt on pt.product =  p.id
        where p.id = %d",
        $this->conn->real_escape_string($product_id));
        $stmt = $this->conn->query($query);
        return $stmt;
    }
}

?>