<?php
require('../../db/connectDB.php');

class CheckIngredient
{

    public function Get_ingredient()
    {
        $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME, DB_PORT);
        echo print_r($conn);

        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);

        $sql = "
            select i.name, pi2.ingredient_quantity, i.available_quantity, i.description
            from product p
            left join product_ingredient pi2 on p.ID = pi2.product_ID
            left join ingredient i on i.ID = pi2.ingredient_ID
            where p.name = 'panino proteico';
            ";


        $result = $conn->query($sql);

        $array=array();

        while($row = $result->fetch_assoc()) {
            $array=$row;   
        }

        print_r($array);


        $conn->close();
    }
}
?>