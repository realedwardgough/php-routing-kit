<?php

namespace App\Config;

class Router
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
     * Handle route executing and completion
     * 
     * @param string $requestUri
     * @param string $method
     */
    public function dispatch(string $requestUri, string $method)
    {
        $uri = $this->normalizeUri(parse_url($requestUri, PHP_URL_PATH));

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
