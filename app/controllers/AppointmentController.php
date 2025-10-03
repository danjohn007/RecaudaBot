<?php
/**
 * Appointment Controller
 */

class AppointmentController extends Controller {
    private $appointmentModel;
    
    public function __construct() {
        parent::__construct();
        $this->appointmentModel = new Appointment();
    }
    
    public function index() {
        $data = ['title' => 'Citas - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('appointments/index', $data);
        $this->view('layout/footer');
    }
    
    public function schedule() {
        $this->requireAuth();
        
        $data = ['title' => 'Agendar Cita - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('appointments/schedule', $data);
        $this->view('layout/footer');
    }
    
    public function store() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/citas/agendar');
        }
        
        $data = [
            'user_id' => $_SESSION['user_id'],
            'service_type' => $_POST['service_type'] ?? '',
            'appointment_date' => $_POST['appointment_date'] ?? '',
            'appointment_time' => $_POST['appointment_time'] ?? '',
            'notes' => $_POST['notes'] ?? '',
            'status' => 'scheduled'
        ];
        
        $appointmentId = $this->appointmentModel->create($data);
        
        if ($appointmentId) {
            $_SESSION['success'] = 'Cita agendada exitosamente';
            $this->redirect('/citas/mis-citas');
        } else {
            $_SESSION['error'] = 'Error al agendar cita';
            $this->redirect('/citas/agendar');
        }
    }
    
    public function myAppointments() {
        $this->requireAuth();
        
        $appointments = $this->appointmentModel->findByUser($_SESSION['user_id']);
        
        $data = [
            'title' => 'Mis Citas - ' . APP_NAME,
            'appointments' => $appointments
        ];
        
        $this->view('layout/header', $data);
        $this->view('appointments/my_appointments', $data);
        $this->view('layout/footer');
    }
    
    public function cancel($id) {
        $this->requireAuth();
        
        $appointment = $this->appointmentModel->findById($id);
        
        if ($appointment && $appointment['user_id'] == $_SESSION['user_id']) {
            $this->appointmentModel->update($id, ['status' => 'cancelled']);
            $_SESSION['success'] = 'Cita cancelada';
        } else {
            $_SESSION['error'] = 'No se pudo cancelar la cita';
        }
        
        $this->redirect('/citas/mis-citas');
    }
}
