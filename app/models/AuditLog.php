<?php
/**
 * AuditLog Model
 */

class AuditLog extends Model {
    protected $table = 'audit_log';
    
    public function log($action, $description = null, $entityType = null, $entityId = null, $oldValues = null, $newValues = null) {
        // Support both old calling style (action, description) and new style (action, description, entityType, entityId, ...)
        // Description is included in action field when provided
        $userId = $_SESSION['user_id'] ?? null;
        
        // If description is provided, combine it with action
        $actionText = $action;
        if ($description !== null) {
            $actionText = $action . ': ' . $description;
        }
        
        $data = [
            'user_id' => $userId,
            'action' => $actionText,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->create($data);
    }
    
    public function getLogsByUser($userId, $limit = 100) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$userId, $limit]);
    }
    
    public function getLogsByEntity($entityType, $entityId, $limit = 50) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE entity_type = ? AND entity_id = ? 
                ORDER BY created_at DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$entityType, $entityId, $limit]);
    }
    
    public function getRecentActivity($limit = 50) {
        $sql = "SELECT al.*, u.full_name, u.email 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.created_at DESC LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
}
