<?php
/**
 * RecaudaBot - Front Controller
 * Entry point for all requests
 */

// Start session
session_start();

// Load configuration
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// Load core classes
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';

// Load controllers
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PropertyTaxController.php';
require_once __DIR__ . '/../app/controllers/LicenseController.php';
require_once __DIR__ . '/../app/controllers/TrafficFineController.php';
require_once __DIR__ . '/../app/controllers/CivicFineController.php';
require_once __DIR__ . '/../app/controllers/ReceiptController.php';
require_once __DIR__ . '/../app/controllers/AssistanceController.php';
require_once __DIR__ . '/../app/controllers/PaymentController.php';
require_once __DIR__ . '/../app/controllers/AppointmentController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';

// Load models
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Property.php';
require_once __DIR__ . '/../app/models/PropertyTax.php';
require_once __DIR__ . '/../app/models/BusinessLicense.php';
require_once __DIR__ . '/../app/models/TrafficFine.php';
require_once __DIR__ . '/../app/models/CivicFine.php';
require_once __DIR__ . '/../app/models/Payment.php';
require_once __DIR__ . '/../app/models/Receipt.php';
require_once __DIR__ . '/../app/models/Appointment.php';
require_once __DIR__ . '/../app/models/Notification.php';
require_once __DIR__ . '/../app/models/AuditLog.php';

// Initialize router
$router = new Router();

// Authentication routes
$router->get('/', [new HomeController(), 'index']);
$router->get('/login', [new AuthController(), 'showLogin']);
$router->post('/login', [new AuthController(), 'login']);
$router->get('/register', [new AuthController(), 'showRegister']);
$router->post('/register', [new AuthController(), 'register']);
$router->get('/logout', [new AuthController(), 'logout']);

// Property Tax routes
$router->get('/impuesto-predial', [new PropertyTaxController(), 'index']);
$router->get('/impuesto-predial/consultar', [new PropertyTaxController(), 'consult']);
$router->post('/impuesto-predial/buscar', [new PropertyTaxController(), 'search']);
$router->get('/impuesto-predial/detalle/{id}', [new PropertyTaxController(), 'detail']);
$router->get('/impuesto-predial/pagar/{id}', [new PropertyTaxController(), 'pay']);

// Business License routes
$router->get('/licencias', [new LicenseController(), 'index']);
$router->get('/licencias/nueva', [new LicenseController(), 'create']);
$router->post('/licencias/nueva', [new LicenseController(), 'store']);
$router->get('/licencias/mis-licencias', [new LicenseController(), 'myLicenses']);
$router->get('/licencias/detalle/{id}', [new LicenseController(), 'detail']);
$router->get('/licencias/renovar/{id}', [new LicenseController(), 'renew']);
$router->post('/licencias/renovar/{id}', [new LicenseController(), 'processRenewal']);

// Traffic Fine routes
$router->get('/multas-transito', [new TrafficFineController(), 'index']);
$router->get('/multas-transito/consultar', [new TrafficFineController(), 'consult']);
$router->post('/multas-transito/buscar', [new TrafficFineController(), 'search']);
$router->get('/multas-transito/detalle/{id}', [new TrafficFineController(), 'detail']);
$router->get('/multas-transito/impugnar/{id}', [new TrafficFineController(), 'appeal']);
$router->post('/multas-transito/impugnar/{id}', [new TrafficFineController(), 'submitAppeal']);
$router->get('/multas-transito/pagar/{id}', [new TrafficFineController(), 'pay']);

// Civic Fine routes
$router->get('/multas-civicas', [new CivicFineController(), 'index']);
$router->get('/multas-civicas/consultar', [new CivicFineController(), 'consult']);
$router->post('/multas-civicas/buscar', [new CivicFineController(), 'search']);
$router->get('/multas-civicas/detalle/{id}', [new CivicFineController(), 'detail']);
$router->get('/multas-civicas/pagar/{id}', [new CivicFineController(), 'pay']);

// Receipt routes
$router->get('/comprobantes', [new ReceiptController(), 'index']);
$router->get('/comprobantes/descargar/{id}', [new ReceiptController(), 'download']);
$router->get('/comprobantes/reenviar/{id}', [new ReceiptController(), 'resend']);

// Assistance routes
$router->get('/orientacion', [new AssistanceController(), 'index']);
$router->get('/orientacion/guias', [new AssistanceController(), 'guides']);
$router->get('/orientacion/faq', [new AssistanceController(), 'faq']);
$router->get('/orientacion/calculadoras', [new AssistanceController(), 'calculators']);
$router->get('/orientacion/chatbot', [new AssistanceController(), 'chatbot']);

// Payment routes
$router->get('/pagos/procesar/{type}/{id}', [new PaymentController(), 'process']);
$router->post('/pagos/confirmar', [new PaymentController(), 'confirm']);
$router->get('/pagos/exito/{id}', [new PaymentController(), 'success']);
$router->get('/pagos/cancelado', [new PaymentController(), 'cancelled']);

// Appointment routes
$router->get('/citas', [new AppointmentController(), 'index']);
$router->get('/citas/agendar', [new AppointmentController(), 'schedule']);
$router->post('/citas/agendar', [new AppointmentController(), 'store']);
$router->get('/citas/mis-citas', [new AppointmentController(), 'myAppointments']);
$router->get('/citas/cancelar/{id}', [new AppointmentController(), 'cancel']);

// Profile routes
$router->get('/perfil', [new ProfileController(), 'index']);
$router->post('/perfil/actualizar', [new ProfileController(), 'update']);
$router->get('/perfil/cambiar-password', [new ProfileController(), 'changePassword']);
$router->post('/perfil/cambiar-password', [new ProfileController(), 'updatePassword']);

// Admin routes
$router->get('/admin', [new AdminController(), 'dashboard']);
$router->get('/admin/usuarios', [new AdminController(), 'users']);
$router->get('/admin/reportes', [new AdminController(), 'reports']);
$router->get('/admin/estadisticas', [new AdminController(), 'statistics']);
$router->get('/admin/configuracion', [new AdminController(), 'settings']);
$router->post('/admin/configuracion', [new AdminController(), 'updateSettings']);

// API routes
$router->get('/api/dashboard/stats', [new AdminController(), 'getStats']);
$router->get('/api/payments/export', [new AdminController(), 'exportPayments']);

// Run router
$router->run();
