<?php
    include_once dirname(__FILE__) . '/../../COMMON/connect.php';
    include_once dirname(__FILE__) . '/../../MODEL/cart.php';

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data) || empty($data->prod) || empty($data->user)){
        http_response_code(400);
        echo json_encode(["message" => "Bad request"]);
        die();
    }

    $dtbase = new Database();
    $conn = $dtbase->connect();

    $cart = new Cart();
    $queryRemoveItem = $cart->setCartItemsRemove($data->prod, $data->user);

    $result = $conn->query($queryRemoveItem);
    if($result){
    http_response_code(200);
    echo json_encode(["Message" => "item deleted"]);
    }
    else{
    http_response_code(400);
    echo json_encode(["message" => "item non removed"]);
    }
    die();
?>