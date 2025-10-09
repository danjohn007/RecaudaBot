<?php
/**
 * Payment Model
 */

class Payment extends Model {
    protected $table = 'payments';
    
    public function findByUser($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC";
        return $this->db->fetchAll($sql, [$userId]);
    }
    
    public function findByReference($type, $referenceId) {
        $sql = "SELECT * FROM {$this->table} WHERE payment_type = ? AND reference_id = ?";
        return $this->db->fetchOne($sql, [$type, $referenceId]);
    }
    
    public function createPayment($data) {
        $data['reference_number'] = $this->generateReferenceNumber();
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->create($data);
    }
    
    private function generateReferenceNumber() {
        return 'PAY-' . date('Y') . '-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    }
    
    public function getTotalRevenue($startDate = null, $endDate = null) {
        $sql = "SELECT SUM(amount) as total FROM {$this->table} WHERE status = 'completed'";
        $params = [];
        
        if ($startDate && $endDate) {
            $sql .= " AND DATE(paid_at) BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }
        
        $result = $this->db->fetchOne($sql, $params);
        return $result['total'] ?? 0;
    }
    
    public function getRevenueByType($startDate = null, $endDate = null) {
        $sql = "SELECT payment_type, SUM(amount) as total, COUNT(*) as count
                FROM {$this->table} 
                WHERE status = 'completed'";
        $params = [];
        
        if ($startDate && $endDate) {
            $sql .= " AND DATE(paid_at) BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }
        
        $sql .= " GROUP BY payment_type";
        return $this->db->fetchAll($sql, $params);
    }
}
