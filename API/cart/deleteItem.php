<?php
include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/cart.php';

$dtbase = new Database();
$conn = $dtbase->connect();

$prod_ID = 1;
$user_ID = 1;
// $cart_ID = 1;

$cart = new Cart();
$queryDelete = $cart->deleteItem($prod_ID, $user_ID);

$result = $conn->query($queryDelete);
print_r($result);


?>