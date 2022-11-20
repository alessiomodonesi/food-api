<?php
    require("../../db/connectDB.php");
    require("../../model/ProductController.php");

    $controller = new ProductController($conn);
    $controller->CheckIngredient();
?>