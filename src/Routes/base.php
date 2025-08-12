<?php

namespace App\Routes;

// Router using the following
use App\Controllers\LoadController;


/**
 * 
 * Single route define method:
 * - "/" as index in this example
 * 
 * Define as class method, arrow function or standard function call to handle
 * the route action. 
 * 
 */
$router->get('/php-routing-kit/public', [LoadController::class, 'index']);


/**
 * 
 * Grouped route define method:
 * - "/admin" as it's defined group prefix
 * 
 * Define as seen below and follow the principles from above for each route, 
 * you do not need to specify the prefix again within the group.
 * 
 */
$router->group('/php-routing-kit/public/admin', function ($router) {
   $router->get('/dashboard', [LoadController::class, 'dashboard']);
});
