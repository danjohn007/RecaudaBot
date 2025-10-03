<?php
/**
 * Receipt Model
 */

class Receipt extends Model {
    protected $table = 'receipts';
    
    public function findByPayment($paymentId) {
        return $this->findOneBy('payment_id', $paymentId);
    }
    
    public function createReceipt($paymentId) {
        $data = [
            'payment_id' => $paymentId,
            'receipt_number' => $this->generateReceiptNumber(),
            'uuid' => $this->generateUUID(),
            'receipt_type' => 'standard',
            'issued_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->create($data);
    }
    
    private function generateReceiptNumber() {
        return 'REC-' . date('Y') . '-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    }
    
    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
    public function getReceiptWithPayment($receiptId) {
        $sql = "SELECT r.*, p.*, u.full_name, u.email
                FROM {$this->table} r
                JOIN payments p ON r.payment_id = p.id
                LEFT JOIN users u ON p.user_id = u.id
                WHERE r.id = ?";
        return $this->db->fetchOne($sql, [$receiptId]);
    }
}
