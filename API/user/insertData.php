<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../COMMON/connect.php";
require __DIR__ . "/../../MODEL/user.php";

header("Content-type: application/json; charset=UTF-8");

use PhpOffice\PhpSpreadsheet\Spreadsheet;


ob_clean();



$filename = $_FILES['fileTestApi']['name'];

// destination of the file on the server
$destination = './' . $filename;

// get the file extension
$extension = pathinfo($filename, PATHINFO_EXTENSION);

// the physical file on a temporary uploads directory on the server
$file = $_FILES['fileTestApi']['tmp_name'];
$size = $_FILES['fileTestApi']['size'];

move_uploaded_file($file, $destination);


$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($filename);
$reader->setReadDataOnly(true);
$reader->load($filename);

die();
?>