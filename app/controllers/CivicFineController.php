<?php
/**
 * Civic Fine Controller
 */

class CivicFineController extends Controller {
    private $fineModel;
    
    public function __construct() {
        parent::__construct();
        $this->fineModel = new CivicFine();
    }
    
    public function index() {
        $data = ['title' => 'Multas Cívicas - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('civic_fines/index', $data);
        $this->view('layout/footer');
    }
    
    public function consult() {
        $data = ['title' => 'Consultar Multas Cívicas - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('civic_fines/consult', $data);
        $this->view('layout/footer');
    }
    
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/multas-civicas/consultar');
        }
        
        $searchTerm = $_POST['search'] ?? '';
        $fines = $this->fineModel->searchFines($searchTerm);
        
        $data = [
            'title' => 'Resultados de Búsqueda - ' . APP_NAME,
            'fines' => $fines,
            'searchTerm' => $searchTerm
        ];
        
        $this->view('layout/header', $data);
        $this->view('civic_fines/search_results', $data);
        $this->view('layout/footer');
    }
    
    public function detail($id) {
        $fine = $this->fineModel->findById($id);
        
        if (!$fine) {
            $_SESSION['error'] = 'Multa no encontrada';
            $this->redirect('/multas-civicas');
        }
        
        $data = [
            'title' => 'Detalle de Multa Cívica - ' . APP_NAME,
            'fine' => $fine
        ];
        
        $this->view('layout/header', $data);
        $this->view('civic_fines/detail', $data);
        $this->view('layout/footer');
    }
    
    public function pay($id) {
        $this->requireAuth();
        $this->redirect('/pagos/procesar/civic_fine/' . $id);
    }
}
