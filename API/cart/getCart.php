<?php
include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';

$dtbase = new Database();
$conn = $dtbase->connect();
$user_ID = 1;
$cart = new Cart();
$queryProductsCart = $cart->getCartItems($user_ID);
$result = $conn->query($queryProductsCart);
        
        if ($result->num_rows > 0) {
            $productsCart=array();
            while($row = $result->fetch_assoc()) {
                $productCart=array(
                    "product_ID" =>  $row["ID"],
                    "quantity" => $row["quantity"],
                    "nameProduct" => $row["name"],
                    "price" => $row["price"],
                    "description" => $row["description"]
                );
                array_push($productsCart,$productCart);
            }
        }

if($productsCart){
    echo json_encode($productsCart);
    var_dump(http_response_code(200));
}
else{
    var_dump(http_response_code(404));
}

$conn->close();

?>