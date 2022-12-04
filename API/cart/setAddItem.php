<?php
    include_once dirname(__FILE__) . '/../../COMMON/connect.php';
    include_once dirname(__FILE__) . '/../../MODEL/cart.php';

    if (isset($_GET["prod"]))
        $prod = $_GET["prod"];

    if (isset($_GET["user"]))
        $user = $_GET["user"];

    $dtbase = new Database();
    $conn = $dtbase->connect();

    $cart = new Cart();
    $queryAddItem = $cart->addItem($prod, $user);

    $result = $conn->query($queryAddItem);
    print_r($result);
?>