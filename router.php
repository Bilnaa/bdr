<?php

class Router
{
    private $routes = [];

    public function add($route, $callback)
    {
        $this->routes[$route] = $callback;
    }

    public function dispatch($requestedUrl)
    {
        // Remove query parameters from the requested URL
        $requestedUrl = strtok($requestedUrl, '?');

        // Check if the requested URL matches any of the defined routes
        foreach ($this->routes as $route => $callback) {
            if ($route === $requestedUrl) {
                // Call the associated callback function
                call_user_func($callback);
                return;
            }
        }

        // No matching route found, send a 404 response
        http_response_code(404);
        echo "404 Not Found";
    }
}
