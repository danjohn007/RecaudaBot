<?php
/**
 * License Controller
 */

class LicenseController extends Controller {
    private $licenseModel;
    
    public function __construct() {
        parent::__construct();
        $this->licenseModel = new BusinessLicense();
    }
    
    public function index() {
        $data = ['title' => 'Licencias de Funcionamiento - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('licenses/index', $data);
        $this->view('layout/footer');
    }
    
    public function create() {
        $this->requireAuth();
        $data = ['title' => 'Nueva Licencia de Funcionamiento - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('licenses/create', $data);
        $this->view('layout/footer');
    }
    
    public function store() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/licencias/nueva');
        }
        
        $data = [
            'user_id' => $_SESSION['user_id'],
            'business_name' => $_POST['business_name'] ?? '',
            'business_type' => $_POST['business_type'] ?? '',
            'rfc' => $_POST['rfc'] ?? '',
            'address' => $_POST['address'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'status' => 'pending'
        ];
        
        $licenseId = $this->licenseModel->create($data);
        
        if ($licenseId) {
            $_SESSION['success'] = 'Solicitud de licencia creada exitosamente';
            $this->redirect('/licencias/detalle/' . $licenseId);
        } else {
            $_SESSION['error'] = 'Error al crear solicitud';
            $this->redirect('/licencias/nueva');
        }
    }
    
    public function myLicenses() {
        $this->requireAuth();
        
        $licenses = $this->licenseModel->findByUser($_SESSION['user_id']);
        
        $data = [
            'title' => 'Mis Licencias - ' . APP_NAME,
            'licenses' => $licenses
        ];
        
        $this->view('layout/header', $data);
        $this->view('licenses/my_licenses', $data);
        $this->view('layout/footer');
    }
    
    public function detail($id) {
        $this->requireAuth();
        
        $license = $this->licenseModel->findById($id);
        
        if (!$license || $license['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Licencia no encontrada';
            $this->redirect('/licencias/mis-licencias');
        }
        
        $data = [
            'title' => 'Detalle de Licencia - ' . APP_NAME,
            'license' => $license
        ];
        
        $this->view('layout/header', $data);
        $this->view('licenses/detail', $data);
        $this->view('layout/footer');
    }
    
    public function renew($id) {
        $this->requireAuth();
        
        $license = $this->licenseModel->findById($id);
        
        if (!$license || $license['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Licencia no encontrada';
            $this->redirect('/licencias/mis-licencias');
        }
        
        $data = [
            'title' => 'Renovar Licencia - ' . APP_NAME,
            'license' => $license
        ];
        
        $this->view('layout/header', $data);
        $this->view('licenses/renew', $data);
        $this->view('layout/footer');
    }
    
    public function processRenewal($id) {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/licencias/renovar/' . $id);
        }
        
        $license = $this->licenseModel->findById($id);
        
        if (!$license || $license['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Licencia no encontrada';
            $this->redirect('/licencias/mis-licencias');
        }
        
        $updateData = [
            'status' => 'pending',
            'issue_date' => date('Y-m-d'),
            'expiry_date' => date('Y-m-d', strtotime('+1 year'))
        ];
        
        $this->licenseModel->update($id, $updateData);
        
        $_SESSION['success'] = 'Solicitud de renovación enviada';
        $this->redirect('/licencias/detalle/' . $id);
    }
}
