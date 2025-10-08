<?php
/**
 * Admin Controller
 */

class AdminController extends Controller {
    private $userModel;
    private $paymentModel;
    private $auditLog;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->paymentModel = new Payment();
        $this->auditLog = new AuditLog();
    }
    
    public function dashboard() {
        $this->requireRole('admin');
        
        // Get statistics
        $stats = $this->getStatistics();
        
        $data = [
            'title' => 'Dashboard Administrativo - ' . APP_NAME,
            'stats' => $stats
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/dashboard', $data);
        $this->view('layout/footer');
    }
    
    private function getStatistics() {
        $today = date('Y-m-d');
        $thisMonth = date('Y-m-01');
        $thisYear = date('Y-01-01');
        
        // Get database connection
        $db = Database::getInstance()->getConnection();
        
        // Total revenue
        $totalRevenue = $this->paymentModel->getTotalRevenue();
        $monthRevenue = $this->paymentModel->getTotalRevenue($thisMonth, date('Y-m-t'));
        $yearRevenue = $this->paymentModel->getTotalRevenue($thisYear, date('Y-12-31'));
        
        // Revenue by type
        $revenueByType = $this->paymentModel->getRevenueByType($thisMonth, date('Y-m-t'));
        
        // Total users
        $totalUsers = $this->userModel->count();
        
        // Today's transactions
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM payments WHERE DATE(paid_at) = CURDATE() AND status = 'completed'");
        $stmt->execute();
        $todayTransactions = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Pending items
        $propertyTaxModel = new PropertyTax();
        $pendingTaxes = $propertyTaxModel->count("status IN ('pending', 'overdue')");
        
        $trafficFineModel = new TrafficFine();
        $pendingTrafficFines = $trafficFineModel->count("status = 'pending'");
        
        $civicFineModel = new CivicFine();
        $pendingCivicFines = $civicFineModel->count("status = 'pending'");
        
        $licenseModel = new BusinessLicense();
        $pendingLicenses = $licenseModel->count("status = 'pending'");
        
        // Monthly trend for the last 6 months
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = date('Y-m-01', strtotime("-$i months"));
            $monthEnd = date('Y-m-t', strtotime("-$i months"));
            $monthlyTrend[] = $this->paymentModel->getTotalRevenue($monthStart, $monthEnd);
        }
        
        // User registration trend for the last 6 months
        $userRegistrationTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = date('Y-m-01', strtotime("-$i months"));
            $monthEnd = date('Y-m-t', strtotime("-$i months"));
            $stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE created_at BETWEEN ? AND ? AND role = 'citizen'");
            $stmt->execute([$monthStart . ' 00:00:00', $monthEnd . ' 23:59:59']);
            $userRegistrationTrend[] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
        }
        
        // Get pending payment amounts by type
        // Pending property taxes amount
        $stmt = $db->prepare("SELECT COALESCE(SUM(total_amount), 0) as total FROM property_taxes WHERE status IN ('pending', 'overdue')");
        $stmt->execute();
        $pendingTaxesAmount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Pending traffic fines amount
        $stmt = $db->prepare("SELECT COALESCE(SUM(total_amount), 0) as total FROM traffic_fines WHERE status = 'pending'");
        $stmt->execute();
        $pendingTrafficFinesAmount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Pending civic fines amount
        $stmt = $db->prepare("SELECT COALESCE(SUM(total_amount), 0) as total FROM civic_fines WHERE status = 'pending'");
        $stmt->execute();
        $pendingCivicFinesAmount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Pending business licenses amount
        $stmt = $db->prepare("SELECT COALESCE(SUM(annual_fee), 0) as total FROM business_licenses WHERE status = 'pending'");
        $stmt->execute();
        $pendingLicensesAmount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Get payment statistics by type
        $stmt = $db->prepare("SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total FROM payments WHERE payment_type = 'property_tax' AND status = 'completed'");
        $stmt->execute();
        $propertyTaxStats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $db->prepare("SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total FROM payments WHERE payment_type = 'traffic_fine' AND status = 'completed'");
        $stmt->execute();
        $trafficFineStats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $db->prepare("SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total FROM payments WHERE payment_type = 'civic_fine' AND status = 'completed'");
        $stmt->execute();
        $civicFineStats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $db->prepare("SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total FROM payments WHERE payment_type = 'business_license' AND status = 'completed'");
        $stmt->execute();
        $licenseStats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $db->prepare("SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total FROM payments WHERE payment_type NOT IN ('property_tax', 'traffic_fine', 'civic_fine', 'business_license') AND status = 'completed'");
        $stmt->execute();
        $otherStats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get pending statistics by type
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM property_taxes WHERE status IN ('pending', 'overdue')");
        $stmt->execute();
        $pendingPropertyTaxCount = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM traffic_fines WHERE status = 'pending'");
        $stmt->execute();
        $pendingTrafficFineCount = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM civic_fines WHERE status = 'pending'");
        $stmt->execute();
        $pendingCivicFineCount = (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        // Get recent activity (last 10 activities)
        $recentActivity = [];
        
        // Recent payments
        $stmt = $db->prepare("SELECT 'payment' as type, p.amount, p.payment_type, p.paid_at as activity_date, u.full_name 
                              FROM payments p 
                              LEFT JOIN users u ON p.user_id = u.id 
                              WHERE p.status = 'completed' 
                              ORDER BY p.paid_at DESC LIMIT 5");
        $stmt->execute();
        $recentActivity = array_merge($recentActivity, $stmt->fetchAll(PDO::FETCH_ASSOC));
        
        // Recent user registrations
        $stmt = $db->prepare("SELECT 'registration' as type, full_name, created_at as activity_date 
                              FROM users 
                              WHERE role = 'citizen' 
                              ORDER BY created_at DESC LIMIT 3");
        $stmt->execute();
        $recentActivity = array_merge($recentActivity, $stmt->fetchAll(PDO::FETCH_ASSOC));
        
        // Recent license applications
        $stmt = $db->prepare("SELECT 'license' as type, bl.business_name, bl.created_at as activity_date, u.full_name 
                              FROM business_licenses bl 
                              LEFT JOIN users u ON bl.user_id = u.id 
                              ORDER BY bl.created_at DESC LIMIT 2");
        $stmt->execute();
        $recentActivity = array_merge($recentActivity, $stmt->fetchAll(PDO::FETCH_ASSOC));
        
        // Sort by date and limit to 10
        usort($recentActivity, function($a, $b) {
            return strtotime($b['activity_date']) - strtotime($a['activity_date']);
        });
        $recentActivity = array_slice($recentActivity, 0, 10);
        
        return [
            'total_revenue' => $totalRevenue,
            'month_revenue' => $monthRevenue,
            'year_revenue' => $yearRevenue,
            'revenue_by_type' => $revenueByType,
            'total_users' => $totalUsers,
            'today_transactions' => $todayTransactions,
            'pending_taxes' => $pendingTaxes,
            'pending_fines' => $pendingTrafficFines + $pendingCivicFines,
            'pending_traffic_fines' => $pendingTrafficFines,
            'pending_civic_fines' => $pendingCivicFines,
            'pending_licenses' => $pendingLicenses,
            'monthly_trend' => $monthlyTrend,
            'user_registration_trend' => $userRegistrationTrend,
            'pending_taxes_amount' => $pendingTaxesAmount,
            'pending_traffic_fines_amount' => $pendingTrafficFinesAmount,
            'pending_civic_fines_amount' => $pendingCivicFinesAmount,
            'pending_licenses_amount' => $pendingLicensesAmount,
            'property_tax_count' => $propertyTaxStats['count'],
            'property_tax_amount' => $propertyTaxStats['total'],
            'traffic_fine_count' => $trafficFineStats['count'],
            'traffic_fine_amount' => $trafficFineStats['total'],
            'civic_fine_count' => $civicFineStats['count'],
            'civic_fine_amount' => $civicFineStats['total'],
            'license_count' => $licenseStats['count'],
            'license_amount' => $licenseStats['total'],
            'other_count' => $otherStats['count'],
            'other_amount' => $otherStats['total'],
            'pending_property_tax_count' => $pendingPropertyTaxCount,
            'pending_property_tax_amount' => $pendingTaxesAmount,
            'pending_traffic_fine_count' => $pendingTrafficFineCount,
            'pending_civic_fine_count' => $pendingCivicFineCount,
            'recent_activity' => $recentActivity
        ];
    }
    
    public function users() {
        $this->requireRole('admin');
        
        $users = $this->userModel->findAll();
        
        $data = [
            'title' => 'Gestión de Usuarios - ' . APP_NAME,
            'users' => $users
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/users', $data);
        $this->view('layout/footer');
    }
    
    public function reports() {
        $this->requireRole('admin');
        
        $data = ['title' => 'Reportes - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('admin/reports', $data);
        $this->view('layout/footer');
    }
    
    public function statistics() {
        $this->requireRole('admin');
        
        $stats = $this->getStatistics();
        
        $data = [
            'title' => 'Estadísticas - ' . APP_NAME,
            'stats' => $stats
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/statistics', $data);
        $this->view('layout/footer');
    }
    
    public function settings() {
        $this->requireRole('admin');
        
        $sql = "SELECT * FROM system_settings ORDER BY setting_key";
        $settings = $this->db->fetchAll($sql);
        
        $data = [
            'title' => 'Configuración del Sistema - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/settings', $data);
        $this->view('layout/footer');
    }
    
    public function updateSettings() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/configuracion');
        }
        
        // Update settings logic here
        
        $_SESSION['success'] = 'Configuración actualizada';
        $this->redirect('/admin/configuracion');
    }
    
    public function getStats() {
        $this->requireRole('admin');
        
        $stats = $this->getStatistics();
        $this->json($stats);
    }
    
    public function exportPayments() {
        $this->requireRole('admin');
        
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');
        
        $sql = "SELECT p.*, u.full_name, u.email 
                FROM payments p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.paid_at BETWEEN ? AND ?
                ORDER BY p.paid_at DESC";
        
        $payments = $this->db->fetchAll($sql, [$startDate, $endDate]);
        
        // Generate CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="pagos-' . $startDate . '-to-' . $endDate . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Usuario', 'Email', 'Tipo', 'Monto', 'Método', 'Estado', 'Fecha']);
        
        foreach ($payments as $payment) {
            fputcsv($output, [
                $payment['id'],
                $payment['full_name'],
                $payment['email'],
                $payment['payment_type'],
                $payment['amount'],
                $payment['payment_method'],
                $payment['status'],
                $payment['paid_at']
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    public function viewUser($id) {
        $this->requireRole('admin');
        
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/admin/usuarios');
        }
        
        $data = [
            'title' => 'Ver Usuario - ' . APP_NAME,
            'user' => $user
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/users/view', $data);
        $this->view('layout/footer');
    }
    
    public function editUser($id) {
        $this->requireRole('admin');
        
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/admin/usuarios');
        }
        
        $data = [
            'title' => 'Editar Usuario - ' . APP_NAME,
            'user' => $user
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/users/edit', $data);
        $this->view('layout/footer');
    }
    
    public function updateUser($id) {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/usuarios');
        }
        
        $data = [
            'full_name' => $_POST['full_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'role' => $_POST['role'] ?? 'citizen'
        ];
        
        if ($this->userModel->update($id, $data)) {
            $this->auditLog->log('user_updated', 'Usuario actualizado: ' . $id);
            $_SESSION['success'] = 'Usuario actualizado correctamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar usuario';
        }
        
        $this->redirect('/admin/usuarios');
    }
    
    public function activateUser($id) {
        $this->requireRole('admin');
        
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/admin/usuarios');
        }
        
        if ($this->userModel->update($id, ['status' => 'active'])) {
            $this->auditLog->log('user_activated', 'Usuario activado: ' . $id);
            $_SESSION['success'] = 'Usuario activado correctamente';
        } else {
            $_SESSION['error'] = 'Error al activar usuario';
        }
        
        $this->redirect('/admin/usuarios');
    }
    
    public function deactivateUser($id) {
        $this->requireRole('admin');
        
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/admin/usuarios');
        }
        
        if ($this->userModel->update($id, ['status' => 'inactive'])) {
            $this->auditLog->log('user_deactivated', 'Usuario desactivado: ' . $id);
            $_SESSION['success'] = 'Usuario desactivado correctamente';
        } else {
            $_SESSION['error'] = 'Error al desactivar usuario';
        }
        
        $this->redirect('/admin/usuarios');
    }
    
    public function deleteUser($id) {
        $this->requireRole('admin');
        
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/admin/usuarios');
        }
        
        // Prevent admin from deleting themselves
        if ($user['id'] == $_SESSION['user_id']) {
            $_SESSION['error'] = 'No puedes eliminar tu propia cuenta';
            $this->redirect('/admin/usuarios');
        }
        
        if ($this->userModel->delete($id)) {
            $this->auditLog->log('user_deleted', 'Usuario eliminado: ' . $id);
            $_SESSION['success'] = 'Usuario eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar usuario';
        }
        
        $this->redirect('/admin/usuarios');
    }
    
    // Property management methods
    public function viewProperty($id) {
        $this->requireRole('admin');
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM properties WHERE id = ?");
        $stmt->execute([$id]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$property) {
            $_SESSION['error'] = 'Predio no encontrado';
            $this->redirect('/admin/reportes/predios');
        }
        
        $data = [
            'title' => 'Ver Predio - ' . APP_NAME,
            'property' => $property
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/properties/view', $data);
        $this->view('layout/footer');
    }
    
    public function processProperty($id) {
        $this->requireRole('admin');
        $_SESSION['info'] = 'Función de procesamiento en desarrollo';
        $this->redirect('/admin/reportes/predios');
    }
    
    public function editProperty($id) {
        $this->requireRole('admin');
        $_SESSION['info'] = 'Función de edición en desarrollo';
        $this->redirect('/admin/reportes/predios');
    }
    
    public function suspendProperty($id) {
        $this->requireRole('admin');
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE properties SET status = 'suspended' WHERE id = ?");
        
        if ($stmt->execute([$id])) {
            $this->auditLog->log($_SESSION['user_id'], 'property_suspended', 'Predio suspendido: ' . $id);
            $_SESSION['success'] = 'Predio suspendido correctamente';
        } else {
            $_SESSION['error'] = 'Error al suspender predio';
        }
        
        $this->redirect('/admin/reportes/predios');
    }
    
    // License management methods
    public function viewLicense($id) {
        $this->requireRole('admin');
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT bl.*, u.full_name as owner_name FROM business_licenses bl 
                              LEFT JOIN users u ON bl.user_id = u.id WHERE bl.id = ?");
        $stmt->execute([$id]);
        $license = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$license) {
            $_SESSION['error'] = 'Licencia no encontrada';
            $this->redirect('/admin/reportes/licencias');
        }
        
        $data = [
            'title' => 'Ver Licencia - ' . APP_NAME,
            'license' => $license
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/licenses/view', $data);
        $this->view('layout/footer');
    }
    
    public function processLicense($id) {
        $this->requireRole('admin');
        $_SESSION['info'] = 'Función de procesamiento en desarrollo';
        $this->redirect('/admin/reportes/licencias');
    }
    
    public function editLicense($id) {
        $this->requireRole('admin');
        $_SESSION['info'] = 'Función de edición en desarrollo';
        $this->redirect('/admin/reportes/licencias');
    }
    
    public function suspendLicense($id) {
        $this->requireRole('admin');
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE business_licenses SET status = 'suspended' WHERE id = ?");
        
        if ($stmt->execute([$id])) {
            $this->auditLog->log($_SESSION['user_id'], 'license_suspended', 'Licencia suspendida: ' . $id);
            $_SESSION['success'] = 'Licencia suspendida correctamente';
        } else {
            $_SESSION['error'] = 'Error al suspender licencia';
        }
        
        $this->redirect('/admin/reportes/licencias');
    }
    
    // Fine management methods
    public function processFine($id) {
        $this->requireRole('admin');
        $_SESSION['info'] = 'Función de procesamiento en desarrollo';
        $this->redirect('/admin/reportes/multas');
    }
    
    public function editFine($id) {
        $this->requireRole('admin');
        $_SESSION['info'] = 'Función de edición en desarrollo';
        $this->redirect('/admin/reportes/multas');
    }
    
    public function suspendFine($id) {
        $this->requireRole('admin');
        
        $type = $_GET['type'] ?? 'traffic';
        $table = $type === 'traffic' ? 'traffic_fines' : 'civic_fines';
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE $table SET status = 'cancelled' WHERE id = ?");
        
        if ($stmt->execute([$id])) {
            $this->auditLog->log($_SESSION['user_id'], 'fine_suspended', 'Multa suspendida: ' . $id);
            $_SESSION['success'] = 'Multa suspendida correctamente';
        } else {
            $_SESSION['error'] = 'Error al suspender multa';
        }
        
        $this->redirect('/admin/reportes/multas');
    }
}
