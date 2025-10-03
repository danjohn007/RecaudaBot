<?php
/**
 * Payment Controller
 */

class PaymentController extends Controller {
    private $paymentModel;
    private $receiptModel;
    
    public function __construct() {
        parent::__construct();
        $this->paymentModel = new Payment();
        $this->receiptModel = new Receipt();
    }
    
    public function process($type, $id) {
        $this->requireAuth();
        
        $item = null;
        $amount = 0;
        $description = '';
        
        switch ($type) {
            case 'property_tax':
                $taxModel = new PropertyTax();
                $item = $taxModel->getTaxWithDetails($id);
                $amount = $item['total_amount'];
                $description = 'Impuesto Predial - ' . $item['cadastral_key'];
                break;
            case 'traffic_fine':
                $fineModel = new TrafficFine();
                $item = $fineModel->findById($id);
                $amount = $item['total_amount'];
                $description = 'Multa de Tránsito - ' . $item['folio'];
                break;
            case 'civic_fine':
                $fineModel = new CivicFine();
                $item = $fineModel->findById($id);
                $amount = $item['total_amount'];
                $description = 'Multa Cívica - ' . $item['folio'];
                break;
        }
        
        if (!$item) {
            $_SESSION['error'] = 'Item no encontrado';
            $this->redirect('/');
        }
        
        $data = [
            'title' => 'Procesar Pago - ' . APP_NAME,
            'type' => $type,
            'reference_id' => $id,
            'amount' => $amount,
            'description' => $description,
            'item' => $item
        ];
        
        $this->view('layout/header', $data);
        $this->view('payments/process', $data);
        $this->view('layout/footer');
    }
    
    public function confirm() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
        }
        
        $paymentData = [
            'user_id' => $_SESSION['user_id'],
            'payment_type' => $_POST['payment_type'],
            'reference_id' => $_POST['reference_id'],
            'amount' => $_POST['amount'],
            'payment_method' => $_POST['payment_method'],
            'status' => 'completed',
            'paid_at' => date('Y-m-d H:i:s')
        ];
        
        $paymentId = $this->paymentModel->createPayment($paymentData);
        
        if ($paymentId) {
            // Update the related entity status
            $this->updateEntityStatus($paymentData['payment_type'], $paymentData['reference_id']);
            
            // Create receipt
            $this->receiptModel->createReceipt($paymentId);
            
            // Create notification
            $notificationModel = new Notification();
            $notificationModel->createNotification(
                $_SESSION['user_id'],
                'email',
                'Pago Exitoso',
                'Su pago ha sido procesado exitosamente',
                'payment',
                $paymentId
            );
            
            $_SESSION['success'] = 'Pago procesado exitosamente';
            $this->redirect('/pagos/exito/' . $paymentId);
        } else {
            $_SESSION['error'] = 'Error al procesar pago';
            $this->redirect('/');
        }
    }
    
    private function updateEntityStatus($type, $id) {
        switch ($type) {
            case 'property_tax':
                $taxModel = new PropertyTax();
                $taxModel->update($id, ['status' => 'paid', 'paid_date' => date('Y-m-d H:i:s'), 'paid_by' => $_SESSION['user_id']]);
                break;
            case 'traffic_fine':
                $fineModel = new TrafficFine();
                $fineModel->update($id, ['status' => 'paid', 'paid_date' => date('Y-m-d H:i:s'), 'paid_by' => $_SESSION['user_id']]);
                break;
            case 'civic_fine':
                $fineModel = new CivicFine();
                $fineModel->update($id, ['status' => 'paid', 'paid_date' => date('Y-m-d H:i:s'), 'paid_by' => $_SESSION['user_id']]);
                break;
        }
    }
    
    public function success($id) {
        $this->requireAuth();
        
        $payment = $this->paymentModel->findById($id);
        $receipt = $this->receiptModel->findByPayment($id);
        
        $data = [
            'title' => 'Pago Exitoso - ' . APP_NAME,
            'payment' => $payment,
            'receipt' => $receipt
        ];
        
        $this->view('layout/header', $data);
        $this->view('payments/success', $data);
        $this->view('layout/footer');
    }
    
    public function cancelled() {
        $data = ['title' => 'Pago Cancelado - ' . APP_NAME];
        $this->view('layout/header', $data);
        $this->view('payments/cancelled', $data);
        $this->view('layout/footer');
    }
}
