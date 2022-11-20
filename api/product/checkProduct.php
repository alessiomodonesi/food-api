<?php
    require("../../db/connectDB.php");
    require("../../model/testController.php");

    $controller = new TestController($conn);
    $controller->CheckProduct();
?>