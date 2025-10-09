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
        // Aggregate revenue directly from all source tables
        $db = Database::getInstance()->getConnection();
        $totalRevenue = 0;
        
        // Property taxes
        $sql = "SELECT COALESCE(SUM(total_amount), 0) as total FROM property_taxes WHERE status = 'paid'";
        if ($startDate && $endDate) {
            $sql .= " AND paid_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $totalRevenue += $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Traffic fines
        $sql = "SELECT COALESCE(SUM(total_amount), 0) as total FROM traffic_fines WHERE status = 'paid'";
        if ($startDate && $endDate) {
            $sql .= " AND paid_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $totalRevenue += $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Civic fines
        $sql = "SELECT COALESCE(SUM(total_amount), 0) as total FROM civic_fines WHERE status = 'paid'";
        if ($startDate && $endDate) {
            $sql .= " AND paid_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $totalRevenue += $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Business licenses
        $sql = "SELECT COALESCE(SUM(annual_fee), 0) as total FROM business_licenses WHERE status = 'approved'";
        if ($startDate && $endDate) {
            $sql .= " AND issue_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $totalRevenue += $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $totalRevenue;
    }
    
    public function getRevenueByType($startDate = null, $endDate = null) {
        // Aggregate data directly from source tables for both completed payments and pending obligations
        $db = Database::getInstance()->getConnection();
        $results = [];
        
        // Property taxes
        $sql = "SELECT 'property_tax' as payment_type, 
                       COALESCE(SUM(total_amount), 0) as total, 
                       COUNT(*) as count
                FROM property_taxes 
                WHERE status = 'paid'";
        if ($startDate && $endDate) {
            $sql .= " AND paid_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['total'] > 0) {
            $results[] = $result;
        }
        
        // Traffic fines
        $sql = "SELECT 'traffic_fine' as payment_type, 
                       COALESCE(SUM(total_amount), 0) as total, 
                       COUNT(*) as count
                FROM traffic_fines 
                WHERE status = 'paid'";
        if ($startDate && $endDate) {
            $sql .= " AND paid_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['total'] > 0) {
            $results[] = $result;
        }
        
        // Civic fines
        $sql = "SELECT 'civic_fine' as payment_type, 
                       COALESCE(SUM(total_amount), 0) as total, 
                       COUNT(*) as count
                FROM civic_fines 
                WHERE status = 'paid'";
        if ($startDate && $endDate) {
            $sql .= " AND paid_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['total'] > 0) {
            $results[] = $result;
        }
        
        // Business licenses
        $sql = "SELECT 'business_license' as payment_type, 
                       COALESCE(SUM(annual_fee), 0) as total, 
                       COUNT(*) as count
                FROM business_licenses 
                WHERE status = 'approved'";
        if ($startDate && $endDate) {
            $sql .= " AND issue_date BETWEEN ? AND ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['total'] > 0) {
            $results[] = $result;
        }
        
        return $results;
    }
}
