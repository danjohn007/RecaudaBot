<?php
/**
 * Report Controller
 * Generates reports with filters and exports
 */

class ReportController extends Controller {
    protected $db;
    
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Reportes - ' . APP_NAME];
        
        $this->view('layout/header', $data);
        $this->view('admin/reports/index', $data);
        $this->view('layout/footer');
    }
    
    public function citizens() {
        $this->requireRole('admin');
        
        // Get filters from request
        $filters = [
            'search' => $_GET['search'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];
        
        // Build query
        $sql = "SELECT id, username, email, full_name, phone, curp, role, status, created_at, last_login 
                FROM users WHERE role = 'citizen'";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (full_name LIKE ? OR email LIKE ? OR curp LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND created_at >= ?";
            $params[] = $filters['date_from'] . ' 00:00:00';
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND created_at <= ?";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $citizens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $data = [
            'title' => 'Reporte de Ciudadanos - ' . APP_NAME,
            'citizens' => $citizens,
            'filters' => $filters
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/reports/citizens', $data);
        $this->view('layout/footer');
    }
    
    public function obligations() {
        $this->requireRole('admin');
        
        // Get filters
        $filters = [
            'type' => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];
        
        $obligations = [];
        
        // Get property taxes
        if (empty($filters['type']) || $filters['type'] === 'property_tax') {
            $sql = "SELECT 'property_tax' as type, pt.id, p.cadastral_key as reference, 
                    p.owner_name as citizen, pt.total_amount, pt.status, pt.due_date, pt.paid_date
                    FROM property_taxes pt
                    JOIN properties p ON pt.property_id = p.id";
            
            $where = [];
            $params = [];
            
            if (!empty($filters['status'])) {
                $where[] = "pt.status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $where[] = "pt.due_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $where[] = "pt.due_date <= ?";
                $params[] = $filters['date_to'];
            }
            
            if (!empty($where)) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $obligations = array_merge($obligations, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        
        // Get traffic fines
        if (empty($filters['type']) || $filters['type'] === 'traffic_fine') {
            $sql = "SELECT 'traffic_fine' as type, id, folio as reference, 
                    driver_name as citizen, total_amount, status, 
                    infraction_date as due_date, paid_date
                    FROM traffic_fines";
            
            $where = [];
            $params = [];
            
            if (!empty($filters['status'])) {
                $where[] = "status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $where[] = "infraction_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $where[] = "infraction_date <= ?";
                $params[] = $filters['date_to'];
            }
            
            if (!empty($where)) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $obligations = array_merge($obligations, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        
        // Get civic fines
        if (empty($filters['type']) || $filters['type'] === 'civic_fine') {
            $sql = "SELECT 'civic_fine' as type, id, folio as reference, 
                    citizen_name as citizen, total_amount, status, 
                    infraction_date as due_date, paid_date
                    FROM civic_fines";
            
            $where = [];
            $params = [];
            
            if (!empty($filters['status'])) {
                $where[] = "status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $where[] = "infraction_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $where[] = "infraction_date <= ?";
                $params[] = $filters['date_to'];
            }
            
            if (!empty($where)) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $obligations = array_merge($obligations, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        
        $data = [
            'title' => 'Reporte de Obligaciones Fiscales - ' . APP_NAME,
            'obligations' => $obligations,
            'filters' => $filters
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/reports/obligations', $data);
        $this->view('layout/footer');
    }
    
    public function payments() {
        $this->requireRole('admin');
        
        // Get filters
        $filters = [
            'type' => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];
        
        $sql = "SELECT p.*, u.full_name, u.email 
                FROM payments p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['type'])) {
            $sql .= " AND p.payment_type = ?";
            $params[] = $filters['type'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND p.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND p.paid_at >= ?";
            $params[] = $filters['date_from'] . ' 00:00:00';
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND p.paid_at <= ?";
            $params[] = $filters['date_to'] . ' 23:59:59';
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (u.full_name LIKE ? OR u.email LIKE ? OR p.transaction_id LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY p.paid_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $data = [
            'title' => 'Reporte de Pagos - ' . APP_NAME,
            'payments' => $payments,
            'filters' => $filters
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/reports/payments', $data);
        $this->view('layout/footer');
    }
    
    public function export() {
        $this->requireRole('admin');
        
        $type = $_GET['type'] ?? 'citizens';
        $format = $_GET['format'] ?? 'csv';
        
        // Get the same data as the report
        switch ($type) {
            case 'citizens':
                $data = $this->getCitizensData();
                $filename = 'reporte-ciudadanos';
                break;
            case 'obligations':
                $data = $this->getObligationsData();
                $filename = 'reporte-obligaciones';
                break;
            case 'payments':
                $data = $this->getPaymentsData();
                $filename = 'reporte-pagos';
                break;
            default:
                $this->redirect('/admin/reportes');
                return;
        }
        
        // Export based on format
        switch ($format) {
            case 'csv':
                $this->exportCsv($data, $filename);
                break;
            case 'xml':
                $this->exportXml($data, $filename);
                break;
            case 'excel':
                $this->exportExcel($data, $filename);
                break;
        }
    }
    
    private function exportCsv($data, $filename) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        if (!empty($data)) {
            // Write headers
            fputcsv($output, array_keys($data[0]));
            
            // Write data
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
        }
        
        fclose($output);
        exit;
    }
    
    private function exportXml($data, $filename) {
        header('Content-Type: text/xml; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.xml"');
        
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><report></report>');
        
        foreach ($data as $row) {
            $item = $xml->addChild('item');
            foreach ($row as $key => $value) {
                $item->addChild($key, htmlspecialchars($value));
            }
        }
        
        echo $xml->asXML();
        exit;
    }
    
    private function exportExcel($data, $filename) {
        // For Excel export, we'd need PhpSpreadsheet
        // For now, redirect to CSV
        $_SESSION['info'] = 'Exportación Excel no disponible. Se descargará en formato CSV.';
        $this->exportCsv($data, $filename);
    }
    
    private function getCitizensData() {
        $stmt = $this->db->prepare("
            SELECT id, username, email, full_name, phone, curp, status, created_at 
            FROM users WHERE role = 'citizen' ORDER BY created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getObligationsData() {
        // This would combine all obligation types
        return [];
    }
    
    private function getPaymentsData() {
        $stmt = $this->db->prepare("
            SELECT p.id, u.full_name, u.email, p.payment_type, p.amount, p.payment_method, p.status, p.paid_at
            FROM payments p
            LEFT JOIN users u ON p.user_id = u.id
            ORDER BY p.paid_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function properties() {
        $this->requireRole('admin');
        
        // Get filters
        $filters = [
            'cadastral_key' => $_GET['cadastral_key'] ?? '',
            'owner_name' => $_GET['owner_name'] ?? '',
            'property_type' => $_GET['property_type'] ?? '',
            'min_value' => $_GET['min_value'] ?? ''
        ];
        
        // Build query
        $sql = "SELECT * FROM properties WHERE 1=1";
        $params = [];
        
        if (!empty($filters['cadastral_key'])) {
            $sql .= " AND cadastral_key LIKE ?";
            $params[] = '%' . $filters['cadastral_key'] . '%';
        }
        
        if (!empty($filters['owner_name'])) {
            $sql .= " AND owner_name LIKE ?";
            $params[] = '%' . $filters['owner_name'] . '%';
        }
        
        if (!empty($filters['property_type'])) {
            $sql .= " AND zone_type = ?";
            $params[] = $filters['property_type'];
        }
        
        if (!empty($filters['min_value'])) {
            $sql .= " AND cadastral_value >= ?";
            $params[] = $filters['min_value'];
        }
        
        $sql .= " ORDER BY cadastral_key";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate statistics
        $stats = [
            'total_properties' => count($properties),
            'total_assessed_value' => array_sum(array_column($properties, 'cadastral_value')),
            'avg_land_area' => count($properties) > 0 ? array_sum(array_column($properties, 'area_m2')) / count($properties) : 0,
            'avg_construction_area' => count($properties) > 0 ? array_sum(array_column($properties, 'construction_m2')) / count($properties) : 0
        ];
        
        $data = [
            'title' => 'Reporte de Predios - ' . APP_NAME,
            'properties' => $properties,
            'stats' => $stats,
            'filters' => $filters
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/reports/properties', $data);
        $this->view('layout/footer');
    }
    
    public function licenses() {
        $this->requireRole('admin');
        
        // Get filters
        $filters = [
            'business_name' => $_GET['business_name'] ?? '',
            'owner_name' => $_GET['owner_name'] ?? '',
            'status' => $_GET['status'] ?? '',
            'year' => $_GET['year'] ?? ''
        ];
        
        // Build query
        $sql = "SELECT * FROM business_licenses WHERE 1=1";
        $params = [];
        
        if (!empty($filters['business_name'])) {
            $sql .= " AND business_name LIKE ?";
            $params[] = '%' . $filters['business_name'] . '%';
        }
        
        if (!empty($filters['owner_name'])) {
            $sql .= " AND owner_name LIKE ?";
            $params[] = '%' . $filters['owner_name'] . '%';
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['year'])) {
            $sql .= " AND YEAR(created_at) = ?";
            $params[] = $filters['year'];
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $licenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate statistics
        $stats = [
            'total_licenses' => count($licenses),
            'approved_licenses' => count(array_filter($licenses, fn($l) => $l['status'] === 'approved')),
            'pending_licenses' => count(array_filter($licenses, fn($l) => $l['status'] === 'pending')),
            'expired_licenses' => count(array_filter($licenses, fn($l) => $l['status'] === 'expired'))
        ];
        
        $data = [
            'title' => 'Reporte de Licencias de Funcionamiento - ' . APP_NAME,
            'licenses' => $licenses,
            'stats' => $stats,
            'filters' => $filters
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/reports/licenses', $data);
        $this->view('layout/footer');
    }
    
    public function fines() {
        $this->requireRole('admin');
        
        // Get filters
        $filters = [
            'folio' => $_GET['folio'] ?? '',
            'fine_type' => $_GET['fine_type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'infraction_type' => $_GET['infraction_type'] ?? '',
            'min_amount' => $_GET['min_amount'] ?? '',
            'max_amount' => $_GET['max_amount'] ?? ''
        ];
        
        $fines = [];
        
        // Get traffic fines
        if (empty($filters['fine_type']) || $filters['fine_type'] === 'traffic') {
            $sql = "SELECT 'traffic' as fine_type, id, folio, infraction_date, infraction_type, 
                    driver_name as infractor_name, base_amount, total_amount, status 
                    FROM traffic_fines WHERE 1=1";
            $params = [];
            
            if (!empty($filters['folio'])) {
                $sql .= " AND folio LIKE ?";
                $params[] = '%' . $filters['folio'] . '%';
            }
            
            if (!empty($filters['status'])) {
                $sql .= " AND status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $sql .= " AND infraction_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $sql .= " AND infraction_date <= ?";
                $params[] = $filters['date_to'] . ' 23:59:59';
            }
            
            if (!empty($filters['infraction_type'])) {
                $sql .= " AND infraction_type LIKE ?";
                $params[] = '%' . $filters['infraction_type'] . '%';
            }
            
            if (!empty($filters['min_amount'])) {
                $sql .= " AND total_amount >= ?";
                $params[] = $filters['min_amount'];
            }
            
            if (!empty($filters['max_amount'])) {
                $sql .= " AND total_amount <= ?";
                $params[] = $filters['max_amount'];
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $fines = array_merge($fines, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        
        // Get civic fines
        if (empty($filters['fine_type']) || $filters['fine_type'] === 'civic') {
            $sql = "SELECT 'civic' as fine_type, id, folio, infraction_date, infraction_type, 
                    citizen_name as infractor_name, base_amount, total_amount, status 
                    FROM civic_fines WHERE 1=1";
            $params = [];
            
            if (!empty($filters['folio'])) {
                $sql .= " AND folio LIKE ?";
                $params[] = '%' . $filters['folio'] . '%';
            }
            
            if (!empty($filters['status'])) {
                $sql .= " AND status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $sql .= " AND infraction_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $sql .= " AND infraction_date <= ?";
                $params[] = $filters['date_to'] . ' 23:59:59';
            }
            
            if (!empty($filters['infraction_type'])) {
                $sql .= " AND infraction_type LIKE ?";
                $params[] = '%' . $filters['infraction_type'] . '%';
            }
            
            if (!empty($filters['min_amount'])) {
                $sql .= " AND total_amount >= ?";
                $params[] = $filters['min_amount'];
            }
            
            if (!empty($filters['max_amount'])) {
                $sql .= " AND total_amount <= ?";
                $params[] = $filters['max_amount'];
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $fines = array_merge($fines, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        
        // Calculate statistics
        $stats = [
            'total_fines' => count($fines),
            'pending_fines' => count(array_filter($fines, fn($f) => $f['status'] === 'pending')),
            'paid_fines' => count(array_filter($fines, fn($f) => $f['status'] === 'paid')),
            'total_amount' => array_sum(array_column($fines, 'total_amount')),
            'traffic_fines' => count(array_filter($fines, fn($f) => $f['fine_type'] === 'traffic')),
            'civic_fines' => count(array_filter($fines, fn($f) => $f['fine_type'] === 'civic'))
        ];
        
        $data = [
            'title' => 'Reporte de Multas y Sanciones - ' . APP_NAME,
            'fines' => $fines,
            'stats' => $stats,
            'filters' => $filters
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/reports/fines', $data);
        $this->view('layout/footer');
    }
    
    public function exportProperties() {
        $this->requireRole('admin');
        
        $format = $_GET['format'] ?? 'excel';
        
        // Get filters from request
        $filters = [
            'cadastral_key' => $_GET['cadastral_key'] ?? '',
            'owner_name' => $_GET['owner_name'] ?? '',
            'property_type' => $_GET['property_type'] ?? '',
            'min_value' => $_GET['min_value'] ?? ''
        ];
        
        // Build query
        $sql = "SELECT cadastral_key, owner_name, address, zone_type, area_m2, construction_m2, cadastral_value, status 
                FROM properties WHERE 1=1";
        $params = [];
        
        if (!empty($filters['cadastral_key'])) {
            $sql .= " AND cadastral_key LIKE ?";
            $params[] = '%' . $filters['cadastral_key'] . '%';
        }
        
        if (!empty($filters['owner_name'])) {
            $sql .= " AND owner_name LIKE ?";
            $params[] = '%' . $filters['owner_name'] . '%';
        }
        
        if (!empty($filters['property_type'])) {
            $sql .= " AND zone_type = ?";
            $params[] = $filters['property_type'];
        }
        
        if (!empty($filters['min_value'])) {
            $sql .= " AND cadastral_value >= ?";
            $params[] = $filters['min_value'];
        }
        
        $sql .= " ORDER BY cadastral_key";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($format === 'pdf') {
            $this->exportPropertiesPdf($properties);
        } else {
            $this->exportCsv($properties, 'reporte-predios');
        }
    }
    
    public function exportFines() {
        $this->requireRole('admin');
        
        $format = $_GET['format'] ?? 'excel';
        
        // Get filters from request
        $filters = [
            'folio' => $_GET['folio'] ?? '',
            'fine_type' => $_GET['fine_type'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'infraction_type' => $_GET['infraction_type'] ?? '',
            'min_amount' => $_GET['min_amount'] ?? '',
            'max_amount' => $_GET['max_amount'] ?? ''
        ];
        
        $fines = [];
        
        // Get traffic fines if no specific type or if traffic is selected
        if (empty($filters['fine_type']) || $filters['fine_type'] === 'traffic') {
            $sql = "SELECT 'traffic' as fine_type, folio, infraction_type, infraction_date, 
                           base_amount, total_amount, status, vehicle_plate 
                    FROM traffic_fines WHERE 1=1";
            $params = [];
            
            if (!empty($filters['folio'])) {
                $sql .= " AND folio LIKE ?";
                $params[] = '%' . $filters['folio'] . '%';
            }
            
            if (!empty($filters['status'])) {
                $sql .= " AND status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $sql .= " AND infraction_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $sql .= " AND infraction_date <= ?";
                $params[] = $filters['date_to'];
            }
            
            if (!empty($filters['infraction_type'])) {
                $sql .= " AND infraction_type LIKE ?";
                $params[] = '%' . $filters['infraction_type'] . '%';
            }
            
            if (!empty($filters['min_amount'])) {
                $sql .= " AND total_amount >= ?";
                $params[] = $filters['min_amount'];
            }
            
            if (!empty($filters['max_amount'])) {
                $sql .= " AND total_amount <= ?";
                $params[] = $filters['max_amount'];
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $fines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // Get civic fines if no specific type or if civic is selected
        if (empty($filters['fine_type']) || $filters['fine_type'] === 'civic') {
            $sql = "SELECT 'civic' as fine_type, folio, infraction_type, infraction_date, 
                           base_amount, total_amount, status, location 
                    FROM civic_fines WHERE 1=1";
            $params = [];
            
            if (!empty($filters['folio'])) {
                $sql .= " AND folio LIKE ?";
                $params[] = '%' . $filters['folio'] . '%';
            }
            
            if (!empty($filters['status'])) {
                $sql .= " AND status = ?";
                $params[] = $filters['status'];
            }
            
            if (!empty($filters['date_from'])) {
                $sql .= " AND infraction_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $sql .= " AND infraction_date <= ?";
                $params[] = $filters['date_to'] . ' 23:59:59';
            }
            
            if (!empty($filters['infraction_type'])) {
                $sql .= " AND infraction_type LIKE ?";
                $params[] = '%' . $filters['infraction_type'] . '%';
            }
            
            if (!empty($filters['min_amount'])) {
                $sql .= " AND total_amount >= ?";
                $params[] = $filters['min_amount'];
            }
            
            if (!empty($filters['max_amount'])) {
                $sql .= " AND total_amount <= ?";
                $params[] = $filters['max_amount'];
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $fines = array_merge($fines, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        
        if ($format === 'pdf') {
            $this->exportFinesPdf($fines);
        } else {
            $this->exportCsv($fines, 'reporte-multas');
        }
    }
    
    private function exportPropertiesPdf($properties) {
        // For now, use a simple HTML to PDF approach
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="reporte-predios.pdf"');
        
        // Since we don't have a PDF library, convert to HTML and use browser print
        // In production, you would use a library like TCPDF or DomPDF
        $_SESSION['info'] = 'La exportación PDF requiere una librería adicional. Se descargará en formato Excel.';
        $this->exportCsv($properties, 'reporte-predios');
    }
    
    private function exportFinesPdf($fines) {
        // For now, use a simple HTML to PDF approach
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="reporte-multas.pdf"');
        
        // Since we don't have a PDF library, convert to HTML and use browser print
        // In production, you would use a library like TCPDF or DomPDF
        $_SESSION['info'] = 'La exportación PDF requiere una librería adicional. Se descargará en formato Excel.';
        $this->exportCsv($fines, 'reporte-multas');
    }
}
