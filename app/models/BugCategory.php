<?php
/**
 * Bug Category Model
 */

class BugCategory extends BaseModel {
    protected $table = 'bug_categories';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function getAllWithBugCount() {
        $sql = "SELECT bc.*, 
                       COUNT(b.id) as bug_count,
                       COUNT(CASE WHEN b.status NOT IN ('resolved', 'closed') THEN 1 END) as open_bugs
                FROM {$this->table} bc
                LEFT JOIN bugs b ON bc.id = b.category_id
                GROUP BY bc.id
                ORDER BY bc.name ASC";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getCategoryBugs($categoryId, $status = null) {
        $sql = "SELECT b.*, 
                       p.name as project_name,
                       u1.username as reporter_name,
                       u2.username as assignee_name
                FROM bugs b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN users u1 ON b.reported_by = u1.id
                LEFT JOIN users u2 ON b.assigned_to = u2.id
                WHERE b.category_id = ?";
        
        $params = [$categoryId];
        
        if ($status) {
            $sql .= " AND b.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY b.created_at DESC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function createCategory($data) {
        // Validate unique name
        if ($this->exists('name', $data['name'])) {
            return false;
        }
        
        return $this->create($data);
    }
    
    public function updateCategory($categoryId, $data) {
        // Validate unique name (excluding current category)
        if (isset($data['name']) && $this->exists('name', $data['name'], $categoryId)) {
            return false;
        }
        
        return $this->update($categoryId, $data);
    }
    
    public function deleteCategory($categoryId) {
        // Check if category has bugs
        $bugCount = $this->count(['category_id' => $categoryId]);
        if ($bugCount > 0) {
            return false; // Cannot delete category with bugs
        }
        
        return $this->delete($categoryId);
    }
    
    public function getCategoryStats($categoryId) {
        $sql = "SELECT 
                    COUNT(*) as total_bugs,
                    COUNT(CASE WHEN status = 'new' THEN 1 END) as new_bugs,
                    COUNT(CASE WHEN status = 'assigned' THEN 1 END) as assigned_bugs,
                    COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as in_progress_bugs,
                    COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_bugs,
                    COUNT(CASE WHEN status = 'closed' THEN 1 END) as closed_bugs,
                    COUNT(CASE WHEN severity = 'critical' THEN 1 END) as critical_bugs,
                    COUNT(CASE WHEN severity = 'major' THEN 1 END) as major_bugs,
                    COUNT(CASE WHEN severity = 'minor' THEN 1 END) as minor_bugs,
                    COUNT(CASE WHEN severity = 'trivial' THEN 1 END) as trivial_bugs
                FROM bugs 
                WHERE category_id = ?";
        
        $stmt = $this->query($sql, [$categoryId]);
        return $stmt->fetch();
    }
}
?>