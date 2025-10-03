<?php
/**
 * PropertyTax Model
 */

class PropertyTax extends Model {
    protected $table = 'property_taxes';
    
    public function findByProperty($propertyId) {
        $sql = "SELECT * FROM {$this->table} WHERE property_id = ? ORDER BY year DESC, period DESC";
        return $this->db->fetchAll($sql, [$propertyId]);
    }
    
    public function getPendingTaxes($propertyId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE property_id = ? AND status IN ('pending', 'overdue')
                ORDER BY year ASC, period ASC";
        return $this->db->fetchAll($sql, [$propertyId]);
    }
    
    public function calculateInterest($taxId) {
        $tax = $this->findById($taxId);
        if (!$tax || $tax['status'] !== 'overdue') {
            return 0;
        }
        
        $dueDate = new DateTime($tax['due_date']);
        $now = new DateTime();
        $monthsOverdue = $dueDate->diff($now)->m + ($dueDate->diff($now)->y * 12);
        
        $interestRate = 0.05; // 5% per month
        $interest = $tax['base_amount'] * $interestRate * $monthsOverdue;
        
        return round($interest, 2);
    }
    
    public function getTaxWithDetails($taxId) {
        $sql = "SELECT pt.*, p.cadastral_key, p.owner_name, p.address
                FROM {$this->table} pt
                JOIN properties p ON pt.property_id = p.id
                WHERE pt.id = ?";
        return $this->db->fetchOne($sql, [$taxId]);
    }
}
