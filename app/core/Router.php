<?php
/**
 * Router Class - Handles URL routing with friendly URLs
 */

class Router {
    private $routes = [];
    private $notFound;
    
    public function __construct() {
        $this->notFound = function() {
            header("HTTP/1.0 404 Not Found");
            require_once __DIR__ . '/../views/errors/404.php';
        };
    }
    
    public function add($method, $path, $callback) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }
    
    public function get($path, $callback) {
        $this->add('GET', $path, $callback);
    }
    
    public function post($path, $callback) {
        $this->add('POST', $path, $callback);
    }
    
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        
        // Remove base path - Adjusted for hosting structure
        // For URLs like: https://recaudabot.digital/daniel/recaudabot/public/login
        // We need to remove /daniel/recaudabot/public to get /login
        $script_name = $_SERVER['SCRIPT_NAME']; // Should be /daniel/recaudabot/public/index.php
        $base_path = dirname($script_name); // Should be /daniel/recaudabot/public
        
        if (strpos($uri, $base_path) === 0) {
            $uri = substr($uri, strlen($base_path));
        }
        
        // Ensure URI starts with /
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }
        
        // Debug output (remove after testing)
        // error_log("Router Debug - Original URI: " . $_SERVER['REQUEST_URI']);
        // error_log("Router Debug - Script Name: " . $_SERVER['SCRIPT_NAME']);
        // error_log("Router Debug - Base Path: " . $base_path);
        // error_log("Router Debug - Processed URI: " . $uri);
        
        // Match route
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                return call_user_func_array($route['callback'], $matches);
            }
        }
        
        // No route found
        call_user_func($this->notFound);
    }
}
