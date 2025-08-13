<?php

// Require autoloader
require __DIR__ . '/../vendor/autoload.php';

// Routing control
use App\Config\Route;
$router = new Route();

// Include the base routing file
require __DIR__ . '/../src/Routes/web.php';

//  Handle distpatch of route->view to screen
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);