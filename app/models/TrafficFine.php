<?php
/**
 * TrafficFine Model
 */

class TrafficFine extends Model {
    protected $table = 'traffic_fines';
    
    public function findByFolio($folio) {
        return $this->findOneBy('folio', $folio);
    }
    
    public function findByLicensePlate($plate) {
        return $this->findBy('license_plate', $plate);
    }
    
    public function findByDriverLicense($license) {
        return $this->findBy('driver_license', $license);
    }
    
    public function searchFines($term) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE folio LIKE ? 
                OR license_plate LIKE ? 
                OR driver_license LIKE ?
                ORDER BY infraction_date DESC";
        $searchTerm = "%$term%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm]);
    }
    
    public function getFineWithEvidence($fineId) {
        $sql = "SELECT tf.*, 
                GROUP_CONCAT(fe.file_path SEPARATOR ',') as evidence_files
                FROM {$this->table} tf
                LEFT JOIN fine_evidence fe ON tf.id = fe.fine_id
                WHERE tf.id = ?
                GROUP BY tf.id";
        return $this->db->fetchOne($sql, [$fineId]);
    }
    
    public function calculateDiscount($fineId) {
        $fine = $this->findById($fineId);
        if (!$fine) return 0;
        
        $infractionDate = new DateTime($fine['infraction_date']);
        $now = new DateTime();
        $daysElapsed = $infractionDate->diff($now)->days;
        
        if ($daysElapsed <= 15) {
            return $fine['base_amount'] * 0.20; // 20% discount
        }
        
        return 0;
    }
}
