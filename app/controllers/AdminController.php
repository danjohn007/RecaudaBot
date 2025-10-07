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
        
        // Total revenue
        $totalRevenue = $this->paymentModel->getTotalRevenue();
        $monthRevenue = $this->paymentModel->getTotalRevenue($thisMonth, date('Y-m-t'));
        $yearRevenue = $this->paymentModel->getTotalRevenue($thisYear, date('Y-12-31'));
        
        // Revenue by type
        $revenueByType = $this->paymentModel->getRevenueByType($thisMonth, date('Y-m-t'));
        
        // Total users
        $totalUsers = $this->userModel->count();
        
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
        
        return [
            'total_revenue' => $totalRevenue,
            'month_revenue' => $monthRevenue,
            'year_revenue' => $yearRevenue,
            'revenue_by_type' => $revenueByType,
            'total_users' => $totalUsers,
            'pending_taxes' => $pendingTaxes,
            'pending_fines' => $pendingTrafficFines + $pendingCivicFines,
            'pending_traffic_fines' => $pendingTrafficFines,
            'pending_civic_fines' => $pendingCivicFines,
            'pending_licenses' => $pendingLicenses,
            'monthly_trend' => $monthlyTrend
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
}
