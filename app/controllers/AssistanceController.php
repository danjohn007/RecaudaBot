<?php
/**
 * Assistance Controller
 */

class AssistanceController extends Controller {
    
    public function index() {
        $data = ['title' => 'Orientación y Asistencia - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('assistance/index', $data);
        $this->view('layout/footer');
    }
    
    public function guides() {
        $sql = "SELECT * FROM help_guides WHERE is_active = 1 ORDER BY category, order_index";
        $guides = $this->db->fetchAll($sql);
        
        $data = [
            'title' => 'Guías de Trámites - ' . APP_NAME,
            'guides' => $guides
        ];
        
        $this->view('layout/header', $data);
        $this->view('assistance/guides', $data);
        $this->view('layout/footer');
    }
    
    public function faq() {
        $sql = "SELECT * FROM faq WHERE is_active = 1 ORDER BY category, order_index";
        $faqs = $this->db->fetchAll($sql);
        
        $data = [
            'title' => 'Preguntas Frecuentes - ' . APP_NAME,
            'faqs' => $faqs
        ];
        
        $this->view('layout/header', $data);
        $this->view('assistance/faq', $data);
        $this->view('layout/footer');
    }
    
    public function calculators() {
        $data = ['title' => 'Calculadoras y Simuladores - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('assistance/calculators', $data);
        $this->view('layout/footer');
    }
    
    public function chatbot() {
        $data = ['title' => 'Asistente Virtual - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('assistance/chatbot', $data);
        $this->view('layout/footer');
    }
}
