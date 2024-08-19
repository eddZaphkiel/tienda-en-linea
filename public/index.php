<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\siteController;
use MVC\Router;

$router = new Router();
// This will be a site for a scholl registration
$router->get('/', [siteController::class, 'inicio']);

$router->checkRoutes();