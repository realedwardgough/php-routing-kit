<?php

namespace App\Config;

class Route
{
   protected array $routes = [];
   protected string $groupPrefix = '';

   /**
    * Handle get method requests
    * 
    * @param string $uri
    * @param callable|array $action
    * @return void
    */
   public function get(string $uri, callable|array $action)
   {
      $this->addRoute('GET', $uri, $action);
   }

   /**
    * Handle post method requests
    * 
    * @param string $uri
    * @param callable|array $action
    * @return void
    */
   public function post(string $uri, callable|array $action)
   {
      $this->addRoute('POST', $uri, $action);
   }

   /**
    * Store the require in routes with method and uri, then store against action
    * 
    * @param string $method
    * @param string $uri
    * @param callable|array $action
    * @return void
    */
   protected function addRoute(string $method, string $uri, callable|array $action)
   {
      // Handle wildcard routes specially
      if ($uri === '*') {
         $this->routes[$method]['*'] = $action;
         return;
      }
      $prefix = $this->groupPrefix ? '/' . trim($this->groupPrefix, '/') : '';
      $path   = $uri !== '/' ? '/' . trim($uri, '/') : '';
      $fullUri = $this->normalizeUri($prefix . $path ?: '/');
      $this->routes[$method][$fullUri] = $action;
   }

   /**
    * Handle when uri has prefix group
    * 
    * @param string $prefix
    * @param callable $callback
    * @return void
    */
   public function group(string $prefix, callable $callback)
   {
      $previousPrefix = $this->groupPrefix;
      $this->groupPrefix = rtrim($previousPrefix . '/' . trim($prefix, '/'), '/');
      $callback($this);
      $this->groupPrefix = $previousPrefix;
   }

   /**
    * Always remove trailing slash except for root
    * 
    * @param string $uri
    * @return string
    */
   protected function normalizeUri(string $uri): string
   {
      return $uri === '/' ? '/' : rtrim($uri, '/');
   }

   /**
    * Convert route pattern to regex and extract parameter names
    * 
    * @param string $route
    * @return array
    */
   protected function parseRoute(string $route): array
   {
      $parameterNames = [];
      
      // Extract parameter names
      preg_match_all('/\{([^}]+)\}/', $route, $matches);
      if (!empty($matches[1])) {
         $parameterNames = $matches[1];
      }
      
      // Convert route pattern to regex
      $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
      $pattern = '#^' . $pattern . '$#';
      
      return [$pattern, $parameterNames];
   }

   /**
    * Match request URI against route patterns and extract parameters
    * 
    * @param string $requestUri
    * @param string $method
    * @return array|null
    */
   protected function matchRoute(string $requestUri, string $method): ?array
   {
       if (!isset($this->routes[$method])) {
           return null;
       }
       $wildcardRoute = null;
       foreach ($this->routes[$method] as $route => $action) {
         // Store wildcard route for later use
         if ($route === '*') {
            $wildcardRoute = [$action, []];
            continue;
         }
         // Check for exact match first (no parameters)
         if ($route === $requestUri) {
            return [$action, []];
         }
         // Check for parameter match
         if (strpos($route, '{') !== false) {
            [$pattern, $parameterNames] = $this->parseRoute($route);
             
            if (preg_match($pattern, $requestUri, $matches)) {
               array_shift($matches); // Remove full match
               
               // Combine parameter names with values
               $parameters = [];
               foreach ($parameterNames as $index => $name) {
                  $parameters[$name] = $matches[$index] ?? null;
               }
               
               return [$action, $parameters];
            }
         }
       }

       // Return wildcard route if no other matches found
       return $wildcardRoute;
   }

   /**
    * Handle route executing and completion
    * 
    * @param string $requestUri
    * @param string $method
    */
   public function dispatch(string $requestUri, string $method)
   {
      $uri = $this->normalizeUri(parse_url($requestUri, PHP_URL_PATH));
      $match = $this->matchRoute($uri, $method);
      if ($match) {
         [$action, $parameters] = $match;
         if (is_callable($action)) {
            // Pass parameters as individual arguments to the closure
            return call_user_func_array($action, array_values($parameters));
         }
         if (is_array($action)) {
            [$class, $method] = $action;
            $controller = new $class;
            // Pass parameters as individual arguments to the controller method
            return call_user_func_array([$controller, $method], array_values($parameters));
         }
      }
      // Default 404 response if no wildcard route is defined
      http_response_code(404);
      echo "404 Not Found";
   }

}