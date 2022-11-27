<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../../MODEL/ingredientTag.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "tag_ID=") || !strpos($_SERVER["REQUEST_URI"], "ingredient_ID=") ) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$tag_ID = explode("&", explode("tag_ID=" ,$_SERVER['REQUEST_URI'])[1])[0]; 

$ingredient_ID = explode("&", explode("ingredient_ID=", $_SERVER['REQUEST_URI'])[1])[0]; 

$ingredientTag = new IngredientTag($db);
$stmt = $ingredientTag->deleteIngredientTag($ingredient_ID, $tag_ID);

if ($stmt > 0)
{
    http_response_code(200);
    echo "Association deleted";
}
else {
    http_response_code(503);
    echo "Association not deleted";
}
?>