<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once dirname(__FILE__) . '/../../COMMON/connect.php';
include_once dirname(__FILE__) . '/../../MODEL/catalog.php';
include_once dirname(__FILE__) . '/../../MODEL/catalogProduct.php';

$database = new Database();
$db = $database->connect();

$catalog = new Catalog($db);

$stmt = $catalog->getArchiveCatalog();

if ($stmt->num_rows > 0) // Se la funzione getArchiveOrder ha ritornato dei record
{
    $catalogProd = new CatalogProduct($db);
    $catalog_arr = array();
    while($record = $stmt->fetch_assoc()) // trasforma una riga in un array e lo fa per tutte le righe di un record
    {
       extract($record);
       $catalog_record = array(
        'ID' => $ID,
        'catalogue_name' => $catalogue_name,
        'validity_start_date' => $validity_start_date,
        'validity_end_date' => $validity_end_date,
        'products' => []
       );
       $productsStmt = $catalogProd->getCatalogueProduct($ID);
    if ($productsStmt->num_rows > 0)
    {
        while($record = $productsStmt->fetch_assoc())
        {
            extract($record);

            $product = array(
                'catalogue_ID' => $catalogue_ID,
                'product_ID' => $product_ID
            );

            array_push($catalog_record['products'], $product);
        }
    array_push($catalog_arr, $catalog_record);
    }
    }
    echo json_encode($catalog_arr, JSON_PRETTY_PRINT);
    return json_encode($catalog_arr);
}
else {
    echo "\n\nNo record";
    http_response_code(404);
    return json_encode(array("Message" => "No record"));
}
?>