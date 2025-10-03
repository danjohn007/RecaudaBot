<?php
/**
 * Authentication Controller
 */

class AuthController extends Controller {
    private $userModel;
    private $auditLog;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->auditLog = new AuditLog();
    }
    
    public function showLogin() {
        if ($this->isAuthenticated()) {
            $this->redirect('/perfil');
        }
        
        $data = ['title' => 'Iniciar Sesión - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('auth/login', $data);
        $this->view('layout/footer');
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = $this->userModel->authenticate($username, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            $this->auditLog->log($user['id'], 'login');
            
            if ($user['role'] === 'admin' || $user['role'] === 'municipal_area') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/perfil');
            }
        } else {
            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            $this->redirect('/login');
        }
    }
    
    public function showRegister() {
        if ($this->isAuthenticated()) {
            $this->redirect('/perfil');
        }
        
        $data = ['title' => 'Registrarse - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('auth/register', $data);
        $this->view('layout/footer');
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
        }
        
        $data = [
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'curp' => $_POST['curp'] ?? '',
            'address' => $_POST['address'] ?? ''
        ];
        
        $errors = $this->validate($data, [
            'username' => 'required|min:4|max:50',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'full_name' => 'required|min:3',
            'curp' => 'required'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        if ($this->userModel->existsByEmail($data['email'])) {
            $_SESSION['error'] = 'El correo electrónico ya está registrado';
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        if ($this->userModel->existsByUsername($data['username'])) {
            $_SESSION['error'] = 'El nombre de usuario ya está registrado';
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        $userId = $this->userModel->createUser($data);
        
        if ($userId) {
            $this->auditLog->log($userId, 'user_registered');
            $_SESSION['success'] = 'Registro exitoso. Por favor, inicie sesión.';
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = 'Error al registrar usuario';
            $this->redirect('/register');
        }
    }
    
    public function logout() {
        if ($this->isAuthenticated()) {
            $this->auditLog->log($_SESSION['user_id'], 'logout');
        }
        
        session_destroy();
        $this->redirect('/');
    }
}
