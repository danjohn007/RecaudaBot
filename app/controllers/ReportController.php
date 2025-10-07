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
}
