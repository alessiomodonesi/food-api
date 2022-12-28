<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../COMMON/connect.php";
require __DIR__ . "/../../MODEL/user.php";

header("Content-type: application/json; charset=UTF-8");

use PhpOffice\PhpSpreadsheet\Spreadsheet;


ob_clean();


$file_name = basename($_SERVER['REQUEST_URI']);

$file_test = explode('.', $_FILES[$file_name]["name"]);

echo json_encode($file_name);

/*$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx();
            $writer->save($file_name);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename='.$file_name.'');
            $writer->save("php://output");
            exit();*/

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

$loaded = $reader->load($data);

$d = $reader->getSheet(0)->toArray();

echo $data;
die();
?>