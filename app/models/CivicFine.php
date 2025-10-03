<?php
/**
 * CivicFine Model
 */

class CivicFine extends Model {
    protected $table = 'civic_fines';
    
    public function findByFolio($folio) {
        return $this->findOneBy('folio', $folio);
    }
    
    public function findByCitizenId($citizenId) {
        return $this->findBy('citizen_id', $citizenId);
    }
    
    public function searchFines($term) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE folio LIKE ? 
                OR citizen_name LIKE ? 
                OR citizen_id LIKE ?
                ORDER BY infraction_date DESC";
        $searchTerm = "%$term%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm]);
    }
}
