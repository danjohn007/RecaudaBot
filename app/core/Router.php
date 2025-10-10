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
        
        // Remove base path - improved detection
        $script_name = $_SERVER['SCRIPT_NAME'];
        $base_path = dirname($script_name);
        
        // Handle different scenarios
        if ($base_path === '/' || $base_path === '\\') {
            $base_path = '';
        }
        
        // Remove /public from base path if present
        $base_path = str_replace('/public', '', $base_path);
        
        if (!empty($base_path) && strpos($uri, $base_path) === 0) {
            $uri = substr($uri, strlen($base_path));
        }
        
        // Handle /public prefix in URI
        if (strpos($uri, '/public') === 0) {
            $uri = substr($uri, 7); // Remove '/public'
        }
        
        // Ensure URI starts with /
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }
        
        // Remove trailing slash (except for root)
        if (strlen($uri) > 1 && substr($uri, -1) === '/') {
            $uri = substr($uri, 0, -1);
        }
        
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
