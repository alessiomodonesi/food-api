<?php
require __DIR__ . '/../../vendor/autoload.php';
header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);
