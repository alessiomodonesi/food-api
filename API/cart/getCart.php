<?php
include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';
include_once dirname(__FILE__) . '/../../MODEL/base.php';

if (!isset($_GET['user']) || ($user = explode("?user=", $_SERVER['REQUEST_URI'])[1]) == null) {
    http_response_code(400);
    echo json_encode(["message" => "No user id has been written"]);
    die();
}

//$user = explode("?user=" , $_SERVER['REQUEST_URI'])[1];

$dtbase = new Database();
$conn = $dtbase->connect();

$cart = new Cart();
$queryProductsCart = $cart->getCartItems($user);
$result = $conn->query($queryProductsCart);



if (mysqli_num_rows($result) > 0) {
    $productsCart = array();
    while ($row = $result->fetch_assoc()) {
        $productCart = array(
            "product" => $row["id"],
            "quantity" => $row["quantity"],
            "name" => $row["name"],
            "price" => $row["price"],
            "description" => $row["description"]
        );
        array_push($productsCart, $productCart);
    }
    http_response_code(200);
    $base = new BaseController($conn);
    $base->SendOutput($productsCart, JSON_OK);
    //echo (json_encode($productsCart, JSON_PRETTY_PRINT));
} else {
    http_response_code(400);
    echo json_encode(["message" => "No record found"]);
}


$conn->close();
die();
?>