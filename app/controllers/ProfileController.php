<?php
/**
 * Profile Controller
 */

class ProfileController extends Controller {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }
    
    public function index() {
        $this->requireAuth();
        
        $user = $this->userModel->findById($_SESSION['user_id']);
        
        $data = [
            'title' => 'Mi Perfil - ' . APP_NAME,
            'user' => $user
        ];
        
        $this->view('layout/header', $data);
        $this->view('profile/index', $data);
        $this->view('layout/footer');
    }
    
    public function update() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/perfil');
        }
        
        $data = [
            'full_name' => $_POST['full_name'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'address' => $_POST['address'] ?? ''
        ];
        
        $this->userModel->update($_SESSION['user_id'], $data);
        $_SESSION['full_name'] = $data['full_name'];
        
        $_SESSION['success'] = 'Perfil actualizado';
        $this->redirect('/perfil');
    }
    
    public function changePassword() {
        $this->requireAuth();
        
        $data = ['title' => 'Cambiar Contraseña - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('profile/change_password', $data);
        $this->view('layout/footer');
    }
    
    public function updatePassword() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/perfil/cambiar-password');
        }
        
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        $user = $this->userModel->findById($_SESSION['user_id']);
        
        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error'] = 'Contraseña actual incorrecta';
            $this->redirect('/perfil/cambiar-password');
        }
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            $this->redirect('/perfil/cambiar-password');
        }
        
        if (strlen($newPassword) < 8) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 8 caracteres';
            $this->redirect('/perfil/cambiar-password');
        }
        
        $this->userModel->updatePassword($_SESSION['user_id'], $newPassword);
        
        $_SESSION['success'] = 'Contraseña actualizada';
        $this->redirect('/perfil');
    }
}
