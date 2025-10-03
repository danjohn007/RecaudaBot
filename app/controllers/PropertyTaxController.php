<?php
/**
 * Property Tax Controller
 */

class PropertyTaxController extends Controller {
    private $propertyModel;
    private $propertyTaxModel;
    
    public function __construct() {
        parent::__construct();
        $this->propertyModel = new Property();
        $this->propertyTaxModel = new PropertyTax();
    }
    
    public function index() {
        $data = ['title' => 'Impuesto Predial - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('property_tax/index', $data);
        $this->view('layout/footer');
    }
    
    public function consult() {
        $data = ['title' => 'Consultar Impuesto Predial - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('property_tax/consult', $data);
        $this->view('layout/footer');
    }
    
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/impuesto-predial/consultar');
        }
        
        $searchTerm = $_POST['search'] ?? '';
        
        $property = $this->propertyModel->findByCadastralKey($searchTerm);
        
        if (!$property) {
            $properties = $this->propertyModel->searchProperties($searchTerm);
            if (count($properties) === 1) {
                $property = $properties[0];
            } else if (count($properties) > 1) {
                $data = [
                    'title' => 'Resultados de Búsqueda - ' . APP_NAME,
                    'properties' => $properties
                ];
                $this->view('layout/header', $data);
                $this->view('property_tax/search_results', $data);
                $this->view('layout/footer');
                return;
            } else {
                $_SESSION['error'] = 'No se encontró el predio';
                $this->redirect('/impuesto-predial/consultar');
                return;
            }
        }
        
        $taxes = $this->propertyTaxModel->findByProperty($property['id']);
        
        $data = [
            'title' => 'Detalle de Impuesto Predial - ' . APP_NAME,
            'property' => $property,
            'taxes' => $taxes
        ];
        
        $this->view('layout/header', $data);
        $this->view('property_tax/detail', $data);
        $this->view('layout/footer');
    }
    
    public function detail($id) {
        $tax = $this->propertyTaxModel->getTaxWithDetails($id);
        
        if (!$tax) {
            $_SESSION['error'] = 'Impuesto no encontrado';
            $this->redirect('/impuesto-predial');
        }
        
        $data = [
            'title' => 'Detalle de Impuesto - ' . APP_NAME,
            'tax' => $tax
        ];
        
        $this->view('layout/header', $data);
        $this->view('property_tax/tax_detail', $data);
        $this->view('layout/footer');
    }
    
    public function pay($id) {
        $this->requireAuth();
        $this->redirect('/pagos/procesar/property_tax/' . $id);
    }
}
