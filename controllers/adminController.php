<?php

namespace Controllers;

use MVC\Router;

class adminController{
    public static function admin_index(Router $router){
        $router->render('admin_index');
    }

    public static function admin_login(Router $router){
        $router->render('admin_login');
    }

    public static function admin_products(Router $router){
        $router->render('admin_products');
    }
}