<?php
/**
 * Base Controller Class
 */

class Controller {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
    
    protected function json($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
    
    protected function redirect($url) {
        // Use PUBLIC_URL for internal redirects
        if (strpos($url, 'http') !== 0) {
            $url = PUBLIC_URL . $url;
        }
        header('Location: ' . $url);
        exit;
    }
    
    protected function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }
    
    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
    
    protected function hasRole($role) {
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }
    
    protected function requireRole($role) {
        $this->requireAuth();
        if (!$this->hasRole($role)) {
            $this->redirect('/unauthorized');
        }
    }
    
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $ruleList = explode('|', $rule);
            
            foreach ($ruleList as $r) {
                if ($r === 'required' && empty($data[$field])) {
                    $errors[$field] = "El campo $field es requerido";
                }
                if (strpos($r, 'min:') === 0) {
                    $min = (int)substr($r, 4);
                    if (strlen($data[$field]) < $min) {
                        $errors[$field] = "El campo $field debe tener al menos $min caracteres";
                    }
                }
                if (strpos($r, 'max:') === 0) {
                    $max = (int)substr($r, 4);
                    if (strlen($data[$field]) > $max) {
                        $errors[$field] = "El campo $field no debe exceder $max caracteres";
                    }
                }
                if ($r === 'email' && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "El campo $field debe ser un email válido";
                }
            }
        }
        
        return $errors;
    }
}
