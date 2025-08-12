<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;

$router = new Router();
$router->get('/php-routing-kit/public/', [HomeController::class, 'index']);
$router->get('/php-routing-kit/public/about', [HomeController::class, 'about']);
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);