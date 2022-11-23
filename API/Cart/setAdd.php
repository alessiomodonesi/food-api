<?php
include_once dirname(__FILE__) . '/../../DB/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';

$dtbase = new db();
$conn = $dtbase->connection();

$prod_ID = 1;
$cart_ID = 1;

$cart = new Cart();
$queryAddItem = $cart->setCartItemsAdd($prod_ID, $cart_ID);

$result = $conn->query($queryAddItem);
print_r($result);

?>