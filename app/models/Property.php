<?php
/**
 * Property Model
 */

class Property extends Model {
    protected $table = 'properties';
    
    public function findByCadastralKey($key) {
        return $this->findOneBy('cadastral_key', $key);
    }
    
    public function findByOwner($ownerId) {
        return $this->findBy('owner_id', $ownerId);
    }
    
    public function searchProperties($term) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE cadastral_key LIKE ? 
                OR owner_name LIKE ? 
                OR address LIKE ?";
        $searchTerm = "%$term%";
        return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm]);
    }
}
