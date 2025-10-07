<?php
/**
 * Import Controller
 * Handles mass data imports from Excel, CSV, and XML files
 */

class ImportController extends Controller {
    protected $db;
    private $allowedTypes = ['csv', 'xml', 'xlsx', 'xls'];
    
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Importaciones - ' . APP_NAME];
        
        $this->view('layout/header', $data);
        $this->view('admin/imports/index', $data);
        $this->view('layout/footer');
    }
    
    public function citizens() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Importar Ciudadanos - ' . APP_NAME];
        
        $this->view('layout/header', $data);
        $this->view('admin/imports/citizens', $data);
        $this->view('layout/footer');
    }
    
    public function properties() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Importar Predios - ' . APP_NAME];
        
        $this->view('layout/header', $data);
        $this->view('admin/imports/properties', $data);
        $this->view('layout/footer');
    }
    
    public function taxes() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Importar Impuestos - ' . APP_NAME];
        
        $this->view('layout/header', $data);
        $this->view('admin/imports/taxes', $data);
        $this->view('layout/footer');
    }
    
    public function fines() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Importar Multas - ' . APP_NAME];
        
        $this->view('layout/header', $data);
        $this->view('admin/imports/fines', $data);
        $this->view('layout/footer');
    }
    
    public function payments() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Importar Pagos - ' . APP_NAME];
        
        $this->view('layout/header', $data);
        $this->view('admin/imports/payments', $data);
        $this->view('layout/footer');
    }
    
    public function process() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/importaciones');
        }
        
        $importType = $_POST['import_type'] ?? '';
        
        if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'Error al cargar el archivo';
            $this->redirect('/admin/importaciones');
        }
        
        $file = $_FILES['import_file'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExt, $this->allowedTypes)) {
            $_SESSION['error'] = 'Tipo de archivo no permitido. Use CSV, XML o Excel';
            $this->redirect('/admin/importaciones');
        }
        
        // Process the file based on type
        $result = $this->processFile($file, $fileExt, $importType);
        
        if ($result['success']) {
            $_SESSION['success'] = "Importación exitosa: {$result['imported']} registros importados";
        } else {
            $_SESSION['error'] = "Error en la importación: {$result['message']}";
        }
        
        $this->redirect('/admin/importaciones');
    }
    
    private function processFile($file, $fileExt, $importType) {
        $tempPath = $file['tmp_name'];
        
        switch ($fileExt) {
            case 'csv':
                return $this->processCsv($tempPath, $importType);
            case 'xml':
                return $this->processXml($tempPath, $importType);
            case 'xlsx':
            case 'xls':
                return $this->processExcel($tempPath, $importType);
            default:
                return ['success' => false, 'message' => 'Formato no soportado'];
        }
    }
    
    private function processCsv($filePath, $importType) {
        $imported = 0;
        $errors = [];
        
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Read header row
            $headers = fgetcsv($handle);
            
            // Process each row
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($headers, $row);
                
                try {
                    $this->importRecord($data, $importType);
                    $imported++;
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
            
            fclose($handle);
        }
        
        return [
            'success' => true,
            'imported' => $imported,
            'errors' => $errors
        ];
    }
    
    private function processXml($filePath, $importType) {
        $imported = 0;
        $errors = [];
        
        try {
            $xml = simplexml_load_file($filePath);
            
            foreach ($xml->children() as $record) {
                $data = [];
                foreach ($record as $key => $value) {
                    $data[$key] = (string)$value;
                }
                
                try {
                    $this->importRecord($data, $importType);
                    $imported++;
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
        
        return [
            'success' => true,
            'imported' => $imported,
            'errors' => $errors
        ];
    }
    
    private function processExcel($filePath, $importType) {
        // For Excel files, we'd need a library like PhpSpreadsheet
        // For now, return a message suggesting CSV conversion
        return [
            'success' => false,
            'message' => 'Por favor, convierta el archivo Excel a CSV para importar'
        ];
    }
    
    private function importRecord($data, $importType) {
        switch ($importType) {
            case 'citizens':
                $this->importCitizen($data);
                break;
            case 'properties':
                $this->importProperty($data);
                break;
            case 'taxes':
                $this->importTax($data);
                break;
            case 'fines':
                $this->importFine($data);
                break;
            case 'payments':
                $this->importPayment($data);
                break;
        }
    }
    
    private function importCitizen($data) {
        // Check if user already exists
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? OR curp = ?");
        $stmt->execute([$data['email'], $data['curp'] ?? '']);
        
        if ($stmt->fetch()) {
            throw new Exception("Ciudadano ya existe: " . $data['email']);
        }
        
        // Insert user
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password, full_name, phone, curp, address, role, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'citizen', 'active')
        ");
        
        $username = explode('@', $data['email'])[0];
        $password = password_hash($data['password'] ?? 'temporal123', PASSWORD_DEFAULT);
        
        $stmt->execute([
            $username,
            $data['email'],
            $password,
            $data['full_name'],
            $data['phone'] ?? '',
            $data['curp'] ?? '',
            $data['address'] ?? ''
        ]);
    }
    
    private function importProperty($data) {
        $stmt = $this->db->prepare("
            INSERT INTO properties (cadastral_key, owner_name, address, area_m2, construction_m2, cadastral_value, zone_type)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $data['cadastral_key'],
            $data['owner_name'],
            $data['address'],
            $data['area_m2'] ?? 0,
            $data['construction_m2'] ?? 0,
            $data['cadastral_value'] ?? 0,
            $data['zone_type'] ?? 'residential'
        ]);
    }
    
    private function importTax($data) {
        $stmt = $this->db->prepare("
            INSERT INTO property_taxes (property_id, year, period, base_amount, total_amount, due_date, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $data['property_id'],
            $data['year'],
            $data['period'],
            $data['base_amount'],
            $data['total_amount'],
            $data['due_date'],
            $data['status'] ?? 'pending'
        ]);
    }
    
    private function importFine($data) {
        // Determine table based on fine type
        $table = $data['fine_type'] === 'traffic' ? 'traffic_fines' : 'civic_fines';
        
        $stmt = $this->db->prepare("
            INSERT INTO $table (folio, infraction_date, infraction_type, base_amount, total_amount, status)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $data['folio'],
            $data['infraction_date'],
            $data['infraction_type'],
            $data['base_amount'],
            $data['total_amount'],
            $data['status'] ?? 'pending'
        ]);
    }
    
    private function importPayment($data) {
        $stmt = $this->db->prepare("
            INSERT INTO payments (user_id, payment_type, reference_id, amount, payment_method, status, paid_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $data['user_id'],
            $data['payment_type'],
            $data['reference_id'],
            $data['amount'],
            $data['payment_method'] ?? 'cash',
            $data['status'] ?? 'completed',
            $data['paid_at'] ?? date('Y-m-d H:i:s')
        ]);
    }
    
    public function downloadTemplate() {
        $this->requireRole('admin');
        
        $type = $_GET['type'] ?? 'citizens';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="plantilla-' . $type . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Get headers based on type
        $headers = $this->getTemplateHeaders($type);
        fputcsv($output, $headers);
        
        // Add sample row
        $sampleData = $this->getSampleData($type);
        fputcsv($output, $sampleData);
        
        fclose($output);
        exit;
    }
    
    private function getTemplateHeaders($type) {
        $templates = [
            'citizens' => ['email', 'full_name', 'phone', 'curp', 'address'],
            'properties' => ['cadastral_key', 'owner_name', 'address', 'area_m2', 'construction_m2', 'cadastral_value', 'zone_type'],
            'taxes' => ['property_id', 'year', 'period', 'base_amount', 'total_amount', 'due_date', 'status'],
            'fines' => ['folio', 'fine_type', 'infraction_date', 'infraction_type', 'base_amount', 'total_amount', 'status'],
            'payments' => ['user_id', 'payment_type', 'reference_id', 'amount', 'payment_method', 'status', 'paid_at']
        ];
        
        return $templates[$type] ?? [];
    }
    
    private function getSampleData($type) {
        $samples = [
            'citizens' => ['usuario@ejemplo.com', 'Juan Pérez', '5512345678', 'PEJJ850101HDFLRN01', 'Calle Principal 123'],
            'properties' => ['123-456-789', 'María García', 'Av. Reforma 456', '150.00', '120.00', '850000.00', 'residential'],
            'taxes' => ['1', '2024', 'Q1', '5000.00', '5000.00', '2024-03-31', 'pending'],
            'fines' => ['MUL-2024-001', 'traffic', '2024-01-15 10:30:00', 'Exceso de velocidad', '1000.00', '1000.00', 'pending'],
            'payments' => ['1', 'property_tax', '1', '5000.00', 'card', 'completed', '2024-01-20 14:30:00']
        ];
        
        return $samples[$type] ?? [];
    }
}
