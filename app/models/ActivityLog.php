<?php
/**
 * Activity Log Model
 */

class ActivityLog extends BaseModel {
    protected $table = 'activity_logs';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function log($userId, $action, $entityType, $entityId, $oldValues = null, $newValues = null) {
        $data = [
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ];
        
        if ($oldValues !== null) {
            $data['old_values'] = json_encode($oldValues);
        }
        
        if ($newValues !== null) {
            $data['new_values'] = json_encode($newValues);
        }
        
        return $this->create($data);
    }
    
    public function getRecentActivity($limit = 50) {
        $sql = "SELECT al.*, u.full_name, u.username, u.role 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.created_at DESC
                LIMIT ?";
        
        $stmt = $this->query($sql, [$limit]);
        return $stmt->fetchAll();
    }
    
    public function getUserActivity($userId, $limit = 20) {
        $sql = "SELECT al.*, u.full_name, u.username, u.role 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.user_id = ? 
                ORDER BY al.created_at DESC 
                LIMIT ?";
        
        $stmt = $this->query($sql, [$userId, $limit]);
        return $stmt->fetchAll();
    }
    
    public function getEntityActivity($entityType, $entityId) {
        $sql = "SELECT al.*, u.full_name, u.username, u.role 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.entity_type = ? AND al.entity_id = ?
                ORDER BY al.created_at DESC";
        
        $stmt = $this->query($sql, [$entityType, $entityId]);
        return $stmt->fetchAll();
    }
    
    public function getActivityStats($days = 30) {
        $sql = "SELECT 
                    DATE(created_at) as date,
                    COUNT(*) as count,
                    action
                FROM {$this->table}
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                GROUP BY DATE(created_at), action
                ORDER BY date DESC";
        
        $stmt = $this->query($sql, [$days]);
        return $stmt->fetchAll();
    }
    
    public function getTotalActivities() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->query($sql);
        return $stmt->fetch()['total'];
    }
    
    public function getTotalUserActivities($userId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->query($sql, [$userId]);
        return $stmt->fetch()['total'];
    }
}
?>