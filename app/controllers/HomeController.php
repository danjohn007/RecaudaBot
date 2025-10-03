<?php
/**
 * Home Controller
 */

class HomeController extends Controller {
    
    public function index() {
        $data = [
            'title' => 'Inicio - ' . APP_NAME,
            'isLoggedIn' => $this->isAuthenticated()
        ];
        
        if ($this->isAuthenticated()) {
            $data['user'] = $_SESSION;
        }
        
        $this->view('layout/header', $data);
        $this->view('home/index', $data);
        $this->view('layout/footer');
    }
}
