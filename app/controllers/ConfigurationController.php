<?php
/**
 * Configuration Controller
 * Manages system settings for admin users
 */

class ConfigurationController extends Controller {
    protected $db;
    
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        $this->requireRole('admin');
        
        // Get all settings grouped by category
        $settings = $this->getSettings();
        
        $data = [
            'title' => 'Configuraciones del Sistema - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/index', $data);
        $this->view('layout/footer');
    }
    
    public function paypal() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('paypal_');
        
        $data = [
            'title' => 'Configuración PayPal - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/paypal', $data);
        $this->view('layout/footer');
    }
    
    public function email() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('email_');
        
        $data = [
            'title' => 'Configuración de Correo - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/email', $data);
        $this->view('layout/footer');
    }
    
    public function currency() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('currency_');
        $tax_settings = $this->getSettingsByPrefix('tax_');
        
        $data = [
            'title' => 'Configuración Moneda e Impuestos - ' . APP_NAME,
            'currency_settings' => $settings,
            'tax_settings' => $tax_settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/currency', $data);
        $this->view('layout/footer');
    }
    
    public function site() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('site_');
        
        $data = [
            'title' => 'Configuración del Sitio - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/site', $data);
        $this->view('layout/footer');
    }
    
    public function terms() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByKey('terms_and_conditions');
        
        $data = [
            'title' => 'Términos y Condiciones - ' . APP_NAME,
            'terms' => $settings['setting_value'] ?? ''
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/terms', $data);
        $this->view('layout/footer');
    }
    
    public function whatsapp() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('whatsapp_');
        
        $data = [
            'title' => 'Configuración WhatsApp - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/whatsapp', $data);
        $this->view('layout/footer');
    }
    
    public function banking() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('bank_');
        
        $data = [
            'title' => 'Cuentas Bancarias - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/banking', $data);
        $this->view('layout/footer');
    }
    
    public function contact() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('contact_');
        
        $data = [
            'title' => 'Información de Contacto - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/contact', $data);
        $this->view('layout/footer');
    }
    
    public function theme() {
        $this->requireRole('admin');
        
        $settings = $this->getSettingsByPrefix('theme_');
        
        // Default theme colors if not set
        $defaults = [
            'theme_primary_color' => '#0d6efd',
            'theme_secondary_color' => '#6c757d',
            'theme_success_color' => '#198754',
            'theme_danger_color' => '#dc3545',
            'theme_warning_color' => '#ffc107',
            'theme_info_color' => '#0dcaf0',
            'theme_light_color' => '#f8f9fa',
            'theme_dark_color' => '#212529',
            'theme_chatbot_bg_color' => '#0d6efd',
            'theme_chatbot_text_color' => '#ffffff',
            'theme_chatbot_user_bg_color' => '#e9ecef',
            'theme_chatbot_user_text_color' => '#212529'
        ];
        
        // Merge with existing settings
        foreach ($defaults as $key => $defaultValue) {
            if (!isset($settings[$key])) {
                $settings[$key] = $defaultValue;
            }
        }
        
        $data = [
            'title' => 'Configuración de Tema y Colores - ' . APP_NAME,
            'settings' => $settings
        ];
        
        $this->view('layout/header', $data);
        $this->view('admin/configuration/theme', $data);
        $this->view('layout/footer');
    }
    
    public function update() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/configuraciones');
        }
        
        $settings = $_POST['settings'] ?? [];
        
        foreach ($settings as $key => $value) {
            $this->saveSetting($key, $value);
        }
        
        $_SESSION['success'] = 'Configuración actualizada exitosamente';
        
        // Redirect back to the referrer or to the main config page
        $redirect = $_POST['redirect'] ?? '/admin/configuraciones';
        $this->redirect($redirect);
    }
    
    private function getSettings() {
        $stmt = $this->db->prepare("SELECT * FROM system_settings ORDER BY setting_key");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getSettingsByPrefix($prefix) {
        $stmt = $this->db->prepare("SELECT * FROM system_settings WHERE setting_key LIKE ? ORDER BY setting_key");
        $stmt->execute([$prefix . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }
    
    private function getSettingsByKey($key) {
        $stmt = $this->db->prepare("SELECT * FROM system_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function saveSetting($key, $value) {
        $stmt = $this->db->prepare("
            INSERT INTO system_settings (setting_key, setting_value) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = ?
        ");
        $stmt->execute([$key, $value, $value]);
    }
}
