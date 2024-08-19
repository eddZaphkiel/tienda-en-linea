<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\loginController;
use Controllers\siteController;
use MVC\Router;

$router = new Router();

$router->get('/', [siteController::class, 'index']);
$router ->get('/cart', [siteController::class, 'cart']);
$router ->get('/product', [siteController::class, 'product']);
$router ->get('/promotions', [siteController::class, 'promotions']);

$router->get('/login', [loginController::class, 'login']);
$router->get('/register', [loginController::class, 'register']);
$router->get('/recover', [loginController::class, 'recover']);
$router->get('/verify', [loginController::class, 'verify']);
$router->get('/reset', [loginController::class, 'reset']);

$router->checkRoutes();