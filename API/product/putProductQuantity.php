<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/order.php';
require __DIR__ . '/../../MODEL/product.php';

$data = json_decode(file_get_contents("php://input"));

if(empty($data)){
    echo json_encode(["message" => "Bad Request"]);
}

$db = new Database();
$db_conn = $db->connect();
$product = new ProductController($db_conn);

/*esempio json
{
    "products":
        [
            {"ID": 1, "quantity" : 3, "action" : "set"},
            {"ID": 2, "quantity" : 5, "action" : "add"},
            {"ID": 3, "quantity" : 6, "action" : "remove"}
        ]
}
*/
foreach(json_decode(json_encode($data->products), true) as $single_mod){
    echo json_encode($single_mod, true);
    switch($single_mod['action']){
        case "set":
            $product->setProductQuantity($single_mod['ID'], $single_mod['quantity']);
            break;
        case "add":
            $product->addProductQuantity($single_mod['ID'], $single_mod['quantity']);
            break;
        case "remove":
            $product->removeProductQuantity($single_mod['ID'], $single_mod['quantity']);
            break;
    }
}
die();
?>