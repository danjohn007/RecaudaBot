<?php
/**
 * Notification Model
 */

class Notification extends Model {
    protected $table = 'notifications';
    
    public function findByUser($userId, $limit = 20) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$userId, $limit]);
    }
    
    public function getUnreadCount($userId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = ? AND read_at IS NULL";
        $result = $this->db->fetchOne($sql, [$userId]);
        return $result['count'];
    }
    
    public function markAsRead($notificationId) {
        return $this->update($notificationId, ['read_at' => date('Y-m-d H:i:s'), 'status' => 'read']);
    }
    
    public function markAllAsRead($userId) {
        $sql = "UPDATE {$this->table} SET read_at = ?, status = 'read' WHERE user_id = ? AND read_at IS NULL";
        return $this->db->query($sql, [date('Y-m-d H:i:s'), $userId]);
    }
    
    public function createNotification($userId, $type, $title, $message, $referenceType = null, $referenceId = null) {
        $data = [
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->create($data);
    }
}
