<?php 

namespace Controllers;

use MVC\Router;

class siteController {

    public static function index(Router $router) {
        $router->render('site/index');
    }

    public static function aboutMe(Router $router) {
        $router->render('site/about');
    }

    public static function mySkills(Router $router) {
        echo 'My skills';
    }

    public static function myProjects(Router $router) {
        echo 'My projects';
    }

    public static function contactMe(Router $router) {
        echo 'Contact me';
    }

    public static function blog(Router $router) {
        echo 'Blog';
    }
}