<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\adminController;
use Controllers\apiController;
use Controllers\siteController;
use MVC\Router;

$router = new Router();

$router->get('/', [siteController::class, 'index']);
$router->get('/cart', [siteController::class, 'cart']);
$router->get('/product', [siteController::class, 'product']);
$router->get('/promotions', [siteController::class, 'promotions']);

$router->get('/admin/login', adminController::class, 'admin_login');
$router->post('/admin/login', adminController::class, 'admin_login');
$router->get('/admin', adminController::class, 'admin_index');

$router->get('/admin/productos', adminController::class, 'admin_productos');

$router->get('/api/producto', [apiController::class, 'producto']);
$router->get('/api/productos', [apiController::class, 'productos']);


$router->checkRoutes();
