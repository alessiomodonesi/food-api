<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/ingredientAllergen.php';

$database = new Database();
$db = $database->connect();

if (!strpos($_SERVER["REQUEST_URI"], "allergen=") || !strpos($_SERVER["REQUEST_URI"], "ingredient=") ) // Controlla se l'URI contiene ?ID
{
    http_response_code(400);
    die(json_encode(array("Message" => "Bad request")));
}

$allergen = explode("&", explode("allergen=", $_SERVER['REQUEST_URI'])[1])[0]; 


$ingredient = explode("&", explode("ingredient=" ,$_SERVER['REQUEST_URI'])[1])[0]; 

$ingredientAllergen = new IngredientAllergen($db);
$stmt = $ingredientAllergen->setIngredientAllergen($ingredient, $allergen);

if ($stmt > 0)
{
    echo "Association inserted";
}
else {
    echo "Association failed";
}
?>