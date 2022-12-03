<?php
    include_once dirname(__FILE__) . '/../../COMMON/connect.php';
    include_once dirname(__FILE__) . '/../../MODEL/cart.php';

    if (isset($_GET["user"]))
        $user = $_GET["user"];

    $dtbase = new Database();
    $conn = $dtbase->connect();

    $cart = new Cart();
    $queryProductsCart = $cart->getCartItems($user);
    $result = $conn->query($queryProductsCart);
        
        if ($result->num_rows > 0) {
            $productsCart=array();
            while($row = $result->fetch_assoc()) {
                $productCart=array(
                    "product" =>  $row["id"],
                    "quantity" => $row["quantity"],
                    "name" => $row["name"],
                    "price" => $row["price"],
                    "description" => $row["description"]
                );
                array_push($productsCart,$productCart);
            }
        }

    if($productsCart){
        echo (json_encode($productsCart, JSON_PRETTY_PRINT));
        var_dump(http_response_code(200));
    }
    else
        var_dump(http_response_code(404));

    $conn->close();
?>