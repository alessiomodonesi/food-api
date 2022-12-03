<?php
include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';

$dtbase = new Database();
$conn = $dtbase->connect();
//print_r($conn);

$prod_ID = 1;
$user_ID = 1;
// $cart_ID = 1;

$cart = new Cart();
$queryRemoveItem = $cart->setCartItemsRemove($prod_ID, $user_ID);

$result = $conn->query($queryRemoveItem);
print_r($result);

?>