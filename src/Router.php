<?php

namespace App;

class Router
{
    protected array $routes = [];

    public function get(string $uri, callable|array $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    protected function addRoute(string $method, string $uri, callable|array $action)
    {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(string $requestUri, string $method)
    {
        $uri = parse_url($requestUri, PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];

            if (is_callable($action)) {
                return call_user_func($action);
            }

            if (is_array($action)) {
                [$class, $method] = $action;
                $controller = new $class;
                return call_user_func([$controller, $method]);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}