<?php 

namespace Controllers;

use MVC\Router;

class siteController  { 
    public static function index(Router $router){
        $router->render('site/index/_index');
    }

    public static function cart(Router $router){
        echo "Carrito desde el router";
    }

    public static function product(Router $router){
        echo "Producto desde el router";
    }

    public static function promotions(Router $router){
        echo "Promociones desde el router";
    }


}