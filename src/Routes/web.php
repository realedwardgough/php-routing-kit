<?php

namespace App\Routes;

// Router using the following
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
$router->get('/', function(){
   echo View::make('home', [], 'example-layout');
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
$router->group('/admin', function ($router) {
   
   // Default admin view
   $router->get('/', function(){
      echo View::make('Home', [], 'example-layout');
   });

   // Dashboard admin view
   $router->get('/dashboard', function(){
      echo View::make('Home', [], 'example-layout');
   });
});
