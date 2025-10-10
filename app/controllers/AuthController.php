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
            $_SESSION['role'] = $user['role']; // Consistent key
            
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
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'full_name' => $_POST['full_name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'curp' => $_POST['curp'] ?? '',
            'address' => $_POST['address'] ?? ''
        ];
        
        // Generate username from email
        $baseUsername = explode('@', $data['email'])[0];
        $data['username'] = $baseUsername;
        
        // Check for duplicate username and append number if needed
        $counter = 1;
        while ($this->userModel->existsByUsername($data['username'])) {
            $data['username'] = $baseUsername . $counter;
            $counter++;
        }
        
        $errors = $this->validate($data, [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'full_name' => 'required|min:3',
            'phone' => 'required',
            'curp' => 'required'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        // Validate CAPTCHA
        $captchaAnswer = isset($_POST['captcha_answer']) ? (int)$_POST['captcha_answer'] : 0;
        $captchaSum = isset($_POST['captcha_sum']) ? (int)$_POST['captcha_sum'] : 0;
        
        if ($captchaAnswer !== $captchaSum || $captchaSum === 0) {
            $_SESSION['error'] = 'La verificación de seguridad es incorrecta';
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        // Validate phone is 10 digits
        if (!preg_match('/^\d{10}$/', $data['phone'])) {
            $_SESSION['error'] = 'El teléfono debe tener exactamente 10 dígitos';
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        if ($this->userModel->existsByEmail($data['email'])) {
            $_SESSION['error'] = 'El correo electrónico ya está registrado';
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        // Check for duplicate CURP
        if ($this->userModel->existsByCurp($data['curp'])) {
            $_SESSION['error'] = 'El CURP ya está registrado en el sistema';
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
        
        $userId = $this->userModel->createUser($data);
        
        if ($userId) {
            $this->auditLog->log($userId, 'user_registered');
            $_SESSION['success'] = 'Registro exitoso. Por favor, inicie sesión.';
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = 'Error al registrar usuario. Por favor, intente nuevamente.';
            $_SESSION['old'] = $data;
            $this->redirect('/register');
        }
    }
    
    public function logout() {
        // Store user info for logging before destroying session
        $user_id = $_SESSION['user_id'] ?? null;
        
        // Log audit if user is authenticated
        if ($this->isAuthenticated() && $user_id) {
            try {
                $this->auditLog->log($user_id, 'logout');
            } catch (Exception $e) {
                // Continue even if audit log fails
                error_log("Audit log failed: " . $e->getMessage());
            }
        }
        
        // Clear all session data
        $_SESSION = array();
        
        // Destroy session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
        
        // Start new session for flash messages
        session_start();
        $_SESSION['success'] = 'Sesión cerrada correctamente';
        
        // Render logout confirmation page instead of direct redirect
        $data = [
            'title' => 'Sesión Cerrada - ' . APP_NAME,
            'message' => 'Has cerrado sesión correctamente. Serás redirigido a la página principal donde puedes registrarte o iniciar sesión nuevamente.',
            'redirect_url' => BASE_URL,
            'redirect_delay' => 3
        ];
        
        $this->view('layout/header', $data);
        $this->view('auth/logout_success', $data);
        $this->view('layout/footer');
    }
}
