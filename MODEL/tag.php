<?php

/**
 * Modello per le API che riguardano i tag
 * Realizzato dal gruppo Rossi, Di Lena, Marchetto G., Lavezzi, Ferrari
 * Classe 5F
 * A.S. 2022-2023
 */

class Tag
{
    protected $conn;
    protected $table_name = 'tag';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getArchiveTag()
    {
        $query = "SELECT id, name FROM $this->table_name";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    /**
     * Per la non possibilità di realizzare un overload dei metodi, è stato necessario scrivere
     * due metodi diversi per realizzare la query dell'API getTag.
     */

    public function getTagWithTagID($tag_id) //getTag in base all'id del tag

    {
        $query = "SELECT id, name FROM $this->table_name WHERE id = $tag_id";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function getTagWithTagName($tag_name) //getTag in base al nome del tag

    {
        $query = "SELECT id, name FROM $this->table_name WHERE name = '$tag_name'";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function createTag($tag_name)
    {
        $query = "INSERT INTO $this->table_name (name) VALUES ('$tag_name')";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function deleteTag($tag_id)
    {
        $query = "DELETE FROM $this->table_name WHERE id=$tag_id";
        $stmt = $this->conn->query($query);
        return $stmt;
    }
}

?>