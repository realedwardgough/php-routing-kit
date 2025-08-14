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
   echo View::make('example', [], 'example-layout');
});


/**
 * 
 * Single route define method with parameter:
 * - "/page/{id}" as URI with id as parameter
 * 
 * Define as class method, arrow function or standard function call to handle
 * the route action. 
 * 
 */
$router->get('/page/{id}', function($id = 0){
   echo View::make('example-with-parameter', ['id' => $id], 'example-layout');
});


/**
 * 
 * Grouped route define method:
 * - "/grouped" as it's defined group prefix
 * 
 * Define as seen below and follow the principles from above for each route, 
 * you do not need to specify the prefix again within the group.
 * 
 */
$router->group('/grouped', function ($router) {
   
   // Essentially "/grouped"
   $router->get('/', function(){
      echo View::make('example', [], 'example-layout');
   });

   // Child of grouped seen as "/grouped/example"
   $router->get('/example', function(){
      echo View::make('example', [], 'example-layout');
   });
});


/**
 * 
 * 404/catch-all route define method:
 * - "*" and handled last for clarity
 * 
 * Define as seen below and follow the principles from above for each route, 
 * you do not need to specify the prefix again within the group.
 * 
 */
$router->get('*', function(){
   http_response_code(404);
   echo View::make('404', [], 'example-layout');
});