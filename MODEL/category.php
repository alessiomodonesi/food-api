<?php

/**
 * Modello per le API che riguardano le categorie
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
 */

class Category
{
    protected $conn;
    protected $category_table_name = 'category';
    protected $product_table_name = 'product';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getArchiveCategory()
    {
        $query = "SELECT ID, name, iva_tax FROM $this->category_table_name";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    /**
     * Per la non possibilità di realizzare un overload dei metodi, è stato necessario scrivere
     * due metodi diversi per realizzare la query dell'API getCategory.
     */

    public function getCategoryWithCategoryID($category_id) //getCategory in base all'ID della categoria

    {
        $query = "SELECT ID, name, iva_tax FROM $this->category_table_name WHERE ID = $category_id";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function getCategoryWithCategoryName($category_name) //getCategory in base al nome della categoria

    {
        $query = "SELECT ID, name, iva_tax FROM $this->category_table_name WHERE name = '$category_name'";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function createCategory($category_name, $iva_tax)
    {
        $query = "INSERT INTO $this->category_table_name (name, iva_tax) VALUES ('$category_name', $iva_tax)";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function setProductCategory($category_ID, $product_ID)
    {
        $query = "UPDATE $this->product_table_name SET category_ID = $category_ID WHERE ID = $product_ID";
        $stmt = $this->conn->query($query);
        return $stmt;
    }
}