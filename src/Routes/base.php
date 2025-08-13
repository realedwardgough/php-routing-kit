<?php

namespace App\Routes;

// Router using the following
use App\Controllers\LoadController;
use App\Config\View;

/**
 * 
 * Single route define method:
 * - "/" as index in this example
 * 
 * Define as class method, arrow function or standard function call to handle
 * the route action. 
 * 
 */
$router->get('/php-routing-kit/public', function(){
   echo View::make('Home', [], 'Layout-Example');
});


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
   echo View::make('Home', [], 'Layout-Example');
});
