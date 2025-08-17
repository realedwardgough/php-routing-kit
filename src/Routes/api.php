<?php

namespace App\Routes;

use DateTime;


/**
 * 
 * Single route define method:
 * - "/" as index in this example
 * 
 * Define as class method, arrow function or standard function call to handle
 * the route action. 
 * 
 */
$router->post('/api/test', function(){
   echo json_encode([
      'Type' => 'Post Test',
      'Status' => 200,
      'Message' => 'Woo!'
   ]);
});