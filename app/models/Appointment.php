<?php
/**
 * Appointment Model
 */

class Appointment extends Model {
    protected $table = 'appointments';
    
    public function findByUser($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY appointment_date DESC, appointment_time DESC";
        return $this->db->fetchAll($sql, [$userId]);
    }
    
    public function getUpcomingAppointments($userId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = ? 
                AND appointment_date >= CURDATE()
                AND status IN ('scheduled', 'confirmed')
                ORDER BY appointment_date ASC, appointment_time ASC";
        return $this->db->fetchAll($sql, [$userId]);
    }
    
    public function getAvailableSlots($date) {
        $sql = "SELECT appointment_time, COUNT(*) as count
                FROM {$this->table}
                WHERE appointment_date = ?
                AND status IN ('scheduled', 'confirmed')
                GROUP BY appointment_time";
        return $this->db->fetchAll($sql, [$date]);
    }
    
    public function isSlotAvailable($date, $time) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}
                WHERE appointment_date = ? AND appointment_time = ?
                AND status IN ('scheduled', 'confirmed')";
        $result = $this->db->fetchOne($sql, [$date, $time]);
        $maxPerSlot = 5; // Max appointments per time slot
        return $result['count'] < $maxPerSlot;
    }
}
