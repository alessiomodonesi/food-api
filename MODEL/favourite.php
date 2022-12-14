<?php

require __DIR__ . "/../COMMON/errorHandler.php";
set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Favourite
{
    protected $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getArchiveFavourite($id)
    {
        $sql = sprintf("SELECT product.name as pname, product.id, user.email as em
                FROM favourite
                INNER JOIN product ON product.id = favourite.product
                INNER JOIN user ON user.id = favourite.`user`
                WHERE user.id = %d",
                $this->conn->real_escape_string($id));

        $result = $this->conn->query($sql);
        return $result;
    }

    public function setFavourite($product_id, $user_id)
    {
        $date = date("Y-m-d h:i:s");

        $favourite = $this->getArchiveFavourite($user_id);

        while($row = $favourite->fetch_assoc()){
            if($row['id'] == $product_id){
                return -1;
            }
        }

        $sql = sprintf("INSERT INTO favourite (user, product)
                VALUES (%d, %d)",
                $this->conn->real_escape_string($user_id),
                $this->conn->real_escape_string($product_id));

        $stmt = $this->conn->query($sql);

        return $stmt;
    }

    public function removeFavourite($product_id, $user_id)
    {
        $sql = sprintf("DELETE FROM favourite
                WHERE product = %d AND user = %d",
                $this->conn->real_escape_string($product_id),
                $this->conn->real_escape_string($user_id));

        $stmt = $this->conn->query($sql);

        return $stmt;
    }
}
