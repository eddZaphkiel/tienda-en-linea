<?php

namespace Controllers;

use Model\Producto;

class apiController {
    public static function producto(){
        header('Content-Type: application/json');

        if(!isset($_GET['id'])){
            echo "false";
        }

        $id = $_GET['id'];

        $producto = Producto::getProduct($id);
        debug($producto);
        echo json_encode($producto); 
    }

    public static function productos(){
        header('Content-Type: application/json');

        $productos = Producto::getAllProducts();
        debug($productos);
        echo json_encode($productos);
    }
}