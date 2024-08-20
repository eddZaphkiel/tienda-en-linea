<?php

namespace Controllers;

use Model\Producto;

class apiController {
    public static function productos(){
        $productos = Producto::all();
        header('Content-Type: application/json');
        echo json_encode($productos);
    }
}