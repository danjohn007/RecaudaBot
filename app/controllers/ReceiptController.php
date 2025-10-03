<?php
/**
 * Receipt Controller
 */

class ReceiptController extends Controller {
    private $receiptModel;
    private $paymentModel;
    
    public function __construct() {
        parent::__construct();
        $this->receiptModel = new Receipt();
        $this->paymentModel = new Payment();
    }
    
    public function index() {
        $this->requireAuth();
        
        $payments = $this->paymentModel->findByUser($_SESSION['user_id']);
        
        $receipts = [];
        foreach ($payments as $payment) {
            $receipt = $this->receiptModel->findByPayment($payment['id']);
            if ($receipt) {
                $receipt['payment'] = $payment;
                $receipts[] = $receipt;
            }
        }
        
        $data = [
            'title' => 'Mis Comprobantes - ' . APP_NAME,
            'receipts' => $receipts
        ];
        
        $this->view('layout/header', $data);
        $this->view('receipts/index', $data);
        $this->view('layout/footer');
    }
    
    public function download($id) {
        $this->requireAuth();
        
        $receipt = $this->receiptModel->getReceiptWithPayment($id);
        
        if (!$receipt || $receipt['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Comprobante no encontrado';
            $this->redirect('/comprobantes');
        }
        
        // Generate PDF here (simplified version)
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="comprobante-' . $receipt['receipt_number'] . '.pdf"');
        
        // In a real implementation, you would use a PDF library like TCPDF or mPDF
        echo "PDF content would be generated here";
        exit;
    }
    
    public function resend($id) {
        $this->requireAuth();
        
        $receipt = $this->receiptModel->getReceiptWithPayment($id);
        
        if (!$receipt || $receipt['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Comprobante no encontrado';
            $this->redirect('/comprobantes');
        }
        
        // Send email here (simplified)
        $_SESSION['success'] = 'Comprobante enviado a ' . $receipt['email'];
        $this->redirect('/comprobantes');
    }
}
