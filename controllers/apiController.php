<?php

namespace Controllers;
use MVC\Router;

class loginController {
    public static function login(Router $router){
        echo "Desde el controlador de login";
    }

    public static function register(Router $router){
        echo "Desde el controlador de register";
    }

    public static function recover(Router $router){
        echo "Desde el controlador de recover";
    }

    public static function verify(Router $router){
        echo "Desde el controlador de verify";
    }

    public static function reset(Router $router){
        echo "Desde el controlador de reset";
    }
}