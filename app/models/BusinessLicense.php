<?php
/**
 * BusinessLicense Model
 */

class BusinessLicense extends Model {
    protected $table = 'business_licenses';
    
    public function findByUser($userId) {
        return $this->findBy('user_id', $userId);
    }
    
    public function findExpiringSoon($days = 30) {
        $date = date('Y-m-d', strtotime("+$days days"));
        $sql = "SELECT * FROM {$this->table} 
                WHERE expiry_date <= ? AND status = 'approved'
                ORDER BY expiry_date ASC";
        return $this->db->fetchAll($sql, [$date]);
    }
    
    public function getLicenseWithDocuments($licenseId) {
        $sql = "SELECT bl.*, 
                GROUP_CONCAT(ld.document_type SEPARATOR ', ') as documents
                FROM {$this->table} bl
                LEFT JOIN license_documents ld ON bl.id = ld.license_id
                WHERE bl.id = ?
                GROUP BY bl.id";
        return $this->db->fetchOne($sql, [$licenseId]);
    }
}
