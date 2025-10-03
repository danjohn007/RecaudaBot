<?php
/**
 * Traffic Fine Controller
 */

class TrafficFineController extends Controller {
    private $fineModel;
    
    public function __construct() {
        parent::__construct();
        $this->fineModel = new TrafficFine();
    }
    
    public function index() {
        $data = ['title' => 'Multas de Tránsito - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('traffic_fines/index', $data);
        $this->view('layout/footer');
    }
    
    public function consult() {
        $data = ['title' => 'Consultar Multas de Tránsito - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('traffic_fines/consult', $data);
        $this->view('layout/footer');
    }
    
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/multas-transito/consultar');
        }
        
        $searchTerm = $_POST['search'] ?? '';
        $fines = $this->fineModel->searchFines($searchTerm);
        
        $data = [
            'title' => 'Resultados de Búsqueda - ' . APP_NAME,
            'fines' => $fines,
            'searchTerm' => $searchTerm
        ];
        
        $this->view('layout/header', $data);
        $this->view('traffic_fines/search_results', $data);
        $this->view('layout/footer');
    }
    
    public function detail($id) {
        $fine = $this->fineModel->getFineWithEvidence($id);
        
        if (!$fine) {
            $_SESSION['error'] = 'Multa no encontrada';
            $this->redirect('/multas-transito');
        }
        
        $discount = $this->fineModel->calculateDiscount($id);
        
        $data = [
            'title' => 'Detalle de Multa - ' . APP_NAME,
            'fine' => $fine,
            'discount' => $discount
        ];
        
        $this->view('layout/header', $data);
        $this->view('traffic_fines/detail', $data);
        $this->view('layout/footer');
    }
    
    public function appeal($id) {
        $this->requireAuth();
        
        $fine = $this->fineModel->findById($id);
        
        if (!$fine) {
            $_SESSION['error'] = 'Multa no encontrada';
            $this->redirect('/multas-transito');
        }
        
        $data = [
            'title' => 'Impugnar Multa - ' . APP_NAME,
            'fine' => $fine
        ];
        
        $this->view('layout/header', $data);
        $this->view('traffic_fines/appeal', $data);
        $this->view('layout/footer');
    }
    
    public function submitAppeal($id) {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/multas-transito/impugnar/' . $id);
        }
        
        $fine = $this->fineModel->findById($id);
        
        if (!$fine) {
            $_SESSION['error'] = 'Multa no encontrada';
            $this->redirect('/multas-transito');
        }
        
        $appealData = [
            'fine_id' => $id,
            'user_id' => $_SESSION['user_id'],
            'reason' => $_POST['reason'] ?? '',
            'evidence_description' => $_POST['evidence_description'] ?? '',
            'status' => 'pending'
        ];
        
        $appealModel = new Model();
        $appealModel->table = 'fine_appeals';
        $appealModel->create($appealData);
        
        $this->fineModel->update($id, ['status' => 'appealed']);
        
        $_SESSION['success'] = 'Impugnación enviada exitosamente';
        $this->redirect('/multas-transito/detalle/' . $id);
    }
    
    public function pay($id) {
        $this->requireAuth();
        $this->redirect('/pagos/procesar/traffic_fine/' . $id);
    }
}
