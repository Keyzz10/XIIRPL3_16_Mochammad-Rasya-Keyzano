<?php
/**
 * Bug Model
 */

class Bug extends BaseModel {
    protected $table = 'bugs';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function getBugWithDetails($bugId) {
        $sql = "SELECT b.*, 
                       p.name as project_name,
                       t.title as task_title,
                       bc.name as category_name,
                       u1.username as reported_by_name,
                       u1.username as reported_by_username,
                       u1.role as reported_by_role,
                       u2.username as assigned_to_name,
                       u2.username as assigned_to_username,
                       u2.role as assigned_to_role,
                       u3.username as resolved_by_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN tasks t ON b.task_id = t.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                LEFT JOIN users u1 ON b.reported_by = u1.id
                LEFT JOIN users u2 ON b.assigned_to = u2.id
                LEFT JOIN users u3 ON b.resolved_by = u3.id
                WHERE b.id = ?";
        
        $stmt = $this->query($sql, [$bugId]);
        return $stmt->fetch();
    }
    
    public function getAllWithDetails($limit = null) {
        $sql = "SELECT b.*, 
                       p.name as project_name,
                       t.title as task_title,
                       bc.name as category_name,
                       u1.username as reported_by_name,
                       u2.username as assigned_to_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN tasks t ON b.task_id = t.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                LEFT JOIN users u1 ON b.reported_by = u1.id
                LEFT JOIN users u2 ON b.assigned_to = u2.id
                ORDER BY b.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getBugStats() {
        $sql = "SELECT 
                    COUNT(*) as total_bugs,
                    COUNT(CASE WHEN status = 'new' THEN 1 END) as new_bugs,
                    COUNT(CASE WHEN status = 'assigned' THEN 1 END) as assigned_bugs,
                    COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as progress_bugs,
                    COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_bugs,
                    COUNT(CASE WHEN severity = 'critical' THEN 1 END) as critical_bugs,
                    COUNT(CASE WHEN severity = 'major' THEN 1 END) as major_bugs,
                    COUNT(CASE WHEN severity = 'minor' THEN 1 END) as minor_bugs,
                    COUNT(CASE WHEN severity IN ('low','trivial') THEN 1 END) as low_bugs
                FROM {$this->table}";
        
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }
    
    public function getBugStatsForUser($userId, $role) {
        $sql = "";
        $params = [];
        
        if (in_array($role, ['super_admin', 'admin'])) {
            // Admin sees all bugs
            $sql = "SELECT 
                        COUNT(*) as total_bugs,
                        COUNT(CASE WHEN status = 'new' THEN 1 END) as new_bugs,
                        COUNT(CASE WHEN status = 'assigned' THEN 1 END) as assigned_bugs,
                        COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as progress_bugs,
                        COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_bugs,
                        COUNT(CASE WHEN severity = 'critical' THEN 1 END) as critical_bugs
                    FROM {$this->table}";
        } elseif ($role === 'project_manager') {
            // PM sees bugs in their projects
            $sql = "SELECT 
                        COUNT(*) as total_bugs,
                        COUNT(CASE WHEN b.status = 'new' THEN 1 END) as new_bugs,
                        COUNT(CASE WHEN b.status = 'assigned' THEN 1 END) as assigned_bugs,
                        COUNT(CASE WHEN b.status = 'in_progress' THEN 1 END) as progress_bugs,
                        COUNT(CASE WHEN b.status = 'resolved' THEN 1 END) as resolved_bugs,
                        COUNT(CASE WHEN b.severity = 'critical' THEN 1 END) as critical_bugs,
                        COUNT(CASE WHEN b.severity = 'major' THEN 1 END) as major_bugs,
                        COUNT(CASE WHEN b.severity = 'minor' THEN 1 END) as minor_bugs,
                        COUNT(CASE WHEN b.severity IN ('low','trivial') THEN 1 END) as low_bugs
                    FROM {$this->table} b
                    LEFT JOIN projects p ON b.project_id = p.id
                    WHERE p.project_manager_id = ?";
            $params = [$userId];
        } elseif ($role === 'developer') {
            // Developer sees only assigned bugs
            $sql = "SELECT 
                        COUNT(*) as total_bugs,
                        COUNT(CASE WHEN status = 'new' THEN 1 END) as new_bugs,
                        COUNT(CASE WHEN status = 'assigned' THEN 1 END) as assigned_bugs,
                        COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as progress_bugs,
                        COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_bugs,
                        COUNT(CASE WHEN severity = 'critical' THEN 1 END) as critical_bugs,
                        COUNT(CASE WHEN severity = 'major' THEN 1 END) as major_bugs,
                        COUNT(CASE WHEN severity = 'minor' THEN 1 END) as minor_bugs,
                        COUNT(CASE WHEN severity IN ('low','trivial') THEN 1 END) as low_bugs
                    FROM {$this->table}
                    WHERE assigned_to = ?";
            $params = [$userId];
        } elseif ($role === 'qa_tester') {
            // QA sees bugs they reported + bugs in their projects
            $sql = "SELECT 
                        COUNT(*) as total_bugs,
                        COUNT(CASE WHEN b.status = 'new' THEN 1 END) as new_bugs,
                        COUNT(CASE WHEN b.status = 'assigned' THEN 1 END) as assigned_bugs,
                        COUNT(CASE WHEN b.status = 'in_progress' THEN 1 END) as progress_bugs,
                        COUNT(CASE WHEN b.status = 'resolved' THEN 1 END) as resolved_bugs,
                        COUNT(CASE WHEN b.severity = 'critical' THEN 1 END) as critical_bugs,
                        COUNT(CASE WHEN b.severity = 'major' THEN 1 END) as major_bugs,
                        COUNT(CASE WHEN b.severity = 'minor' THEN 1 END) as minor_bugs,
                        COUNT(CASE WHEN b.severity IN ('low','trivial') THEN 1 END) as low_bugs
                    FROM {$this->table} b
                    LEFT JOIN projects p ON b.project_id = p.id
                    LEFT JOIN project_teams pt ON p.id = pt.project_id
                    WHERE b.reported_by = ? OR (pt.user_id = ? AND pt.role_in_project = 'qa_tester')";
            $params = [$userId, $userId];
        } else {
            // Other roles see bugs they reported or assigned to
            $sql = "SELECT 
                        COUNT(*) as total_bugs,
                        COUNT(CASE WHEN status = 'new' THEN 1 END) as new_bugs,
                        COUNT(CASE WHEN status = 'assigned' THEN 1 END) as assigned_bugs,
                        COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as progress_bugs,
                        COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_bugs,
                        COUNT(CASE WHEN severity = 'critical' THEN 1 END) as critical_bugs,
                        COUNT(CASE WHEN severity = 'major' THEN 1 END) as major_bugs,
                        COUNT(CASE WHEN severity = 'minor' THEN 1 END) as minor_bugs,
                        COUNT(CASE WHEN severity IN ('low','trivial') THEN 1 END) as low_bugs
                    FROM {$this->table}
                    WHERE assigned_to = ? OR reported_by = ?";
            $params = [$userId, $userId];
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    public function getBugsForProjectManager($managerId) {
        $sql = "SELECT b.*, 
                       p.name as project_name,
                       bc.name as category_name,
                       u.username as reported_by_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                LEFT JOIN users u ON b.reported_by = u.id
                WHERE p.project_manager_id = ?
                ORDER BY b.created_at DESC";
        
        $stmt = $this->query($sql, [$managerId]);
        return $stmt->fetchAll();
    }
    
    public function getCriticalBugs() {
        return $this->findBy('severity', 'critical');
    }
    
    public function getBugComments($bugId, $currentUserRole = null) {
        // Admin and project manager can see deleted comments
        $showDeleted = in_array($currentUserRole, ['super_admin', 'admin', 'project_manager']);
        
        $sql = "SELECT bc.*, 
                       u.full_name, u.username, u.profile_photo,
                       parent.comment as parent_comment,
                       parent.is_deleted as parent_is_deleted,
                       parent_user.username as parent_user_name,
                       deleted_user.username as deleted_by_username,
                       deleted_user.full_name as deleted_by_name,
                       edited_user.username as edited_by_username,
                       edited_user.full_name as edited_by_name
                FROM bug_comments bc
                LEFT JOIN users u ON bc.user_id = u.id
                LEFT JOIN bug_comments parent ON bc.parent_comment_id = parent.id
                LEFT JOIN users parent_user ON parent.user_id = parent_user.id
                LEFT JOIN users deleted_user ON bc.deleted_by = deleted_user.id
                LEFT JOIN users edited_user ON bc.edited_by = edited_user.id
                WHERE bc.bug_id = ?" . ($showDeleted ? "" : " AND bc.is_deleted = 0") . "
                ORDER BY bc.created_at ASC";
        
        $stmt = $this->query($sql, [$bugId]);
        return $stmt->fetchAll();
    }
    
    public function addComment($bugId, $userId, $comment, $parentCommentId = null) {
        $data = [
            'bug_id' => $bugId,
            'user_id' => $userId,
            'comment' => $comment,
            'parent_comment_id' => $parentCommentId
        ];
        
        $stmt = $this->db->prepare("INSERT INTO bug_comments (bug_id, user_id, comment, parent_comment_id) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$bugId, $userId, $comment, $parentCommentId]);
        
        // Return the inserted comment ID
        if ($result) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    public function getBugAttachments($bugId) {
        $sql = "SELECT ba.*, u.username as uploaded_by_name
                FROM bug_attachments ba
                LEFT JOIN users u ON ba.uploaded_by = u.id
                WHERE ba.bug_id = ?
                ORDER BY ba.uploaded_at DESC";
        
        $stmt = $this->query($sql, [$bugId]);
        return $stmt->fetchAll();
    }
    
    public function getUserBugs($userId, $limit = null, $status = null) {
        $sql = "SELECT b.*, p.name as project_name, bc.name as category_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                WHERE (b.assigned_to = ? OR b.reported_by = ?)";
        $params = [$userId, $userId];

        if (!empty($status)) {
            $sql .= " AND b.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY b.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?"; 
            $params[] = $limit;
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function getAssignedBugs($userId, $status = null) {
        $sql = "SELECT b.*, p.name as project_name, bc.name as category_name,
                       u.username as reported_by_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                LEFT JOIN users u ON b.reported_by = u.id
                WHERE b.assigned_to = ?";
        $params = [$userId];

        if (!empty($status)) {
            $sql .= " AND b.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY b.priority DESC, b.created_at DESC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function getBugsForQA($userId, $status = null) {
        $sql = "SELECT DISTINCT b.*, p.name as project_name, bc.name as category_name,
                       u1.username as reported_by_name, u2.username as assigned_to_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                LEFT JOIN users u1 ON b.reported_by = u1.id
                LEFT JOIN users u2 ON b.assigned_to = u2.id
                LEFT JOIN project_teams pt ON p.id = pt.project_id
                WHERE (b.reported_by = ? OR (pt.user_id = ? AND pt.role_in_project = 'qa_tester'))";
        $params = [$userId, $userId];

        if (!empty($status)) {
            $sql .= " AND b.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY b.created_at DESC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function deleteByProject($projectId) {
        $sql = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$projectId]);
    }
    
    // Role-based methods for reports
    public function getBugStatsByManager($managerId) {
        $sql = "SELECT 
                    COUNT(*) as total_bugs,
                    COUNT(CASE WHEN b.status = 'new' THEN 1 END) as new_bugs,
                    COUNT(CASE WHEN b.status = 'assigned' THEN 1 END) as assigned_bugs,
                    COUNT(CASE WHEN b.status = 'in_progress' THEN 1 END) as progress_bugs,
                    COUNT(CASE WHEN b.status = 'resolved' THEN 1 END) as resolved_bugs,
                    COUNT(CASE WHEN b.severity = 'critical' THEN 1 END) as critical_bugs,
                    COUNT(CASE WHEN b.severity = 'major' THEN 1 END) as major_bugs,
                    COUNT(CASE WHEN b.severity = 'minor' THEN 1 END) as minor_bugs,
                    COUNT(CASE WHEN b.severity IN ('low','trivial') THEN 1 END) as low_bugs
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                WHERE p.project_manager_id = ?";
        
        $stmt = $this->query($sql, [$managerId]);
        return $stmt->fetch();
    }
    
    public function getBugStatsByUser($userId) {
        $sql = "SELECT 
                    COUNT(*) as total_bugs,
                    COUNT(CASE WHEN status = 'new' THEN 1 END) as new_bugs,
                    COUNT(CASE WHEN status = 'assigned' THEN 1 END) as assigned_bugs,
                    COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as progress_bugs,
                    COUNT(CASE WHEN status = 'resolved' THEN 1 END) as resolved_bugs,
                    COUNT(CASE WHEN severity = 'critical' THEN 1 END) as critical_bugs,
                    COUNT(CASE WHEN severity = 'major' THEN 1 END) as major_bugs,
                    COUNT(CASE WHEN severity = 'minor' THEN 1 END) as minor_bugs,
                    COUNT(CASE WHEN severity IN ('low','trivial') THEN 1 END) as low_bugs
                FROM {$this->table}
                WHERE assigned_to = ? OR reported_by = ?";
        
        $stmt = $this->query($sql, [$userId, $userId]);
        return $stmt->fetch();
    }
    
    public function getBugStatsByClient($clientId) {
        $sql = "SELECT 
                    COUNT(*) as total_bugs,
                    COUNT(CASE WHEN b.status = 'new' THEN 1 END) as new_bugs,
                    COUNT(CASE WHEN b.status = 'assigned' THEN 1 END) as assigned_bugs,
                    COUNT(CASE WHEN b.status = 'in_progress' THEN 1 END) as progress_bugs,
                    COUNT(CASE WHEN b.status = 'resolved' THEN 1 END) as resolved_bugs,
                    COUNT(CASE WHEN b.severity = 'critical' THEN 1 END) as critical_bugs,
                    COUNT(CASE WHEN b.severity = 'major' THEN 1 END) as major_bugs,
                    COUNT(CASE WHEN b.severity = 'minor' THEN 1 END) as minor_bugs,
                    COUNT(CASE WHEN b.severity IN ('low','trivial') THEN 1 END) as low_bugs
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                WHERE p.client_id = ?";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetch();
    }
    
    public function getBugsByManagerWithDetails($managerId) {
        return $this->getBugsForProjectManager($managerId);
    }
    
    public function getBugsByUserWithDetails($userId) {
        return $this->getUserBugs($userId);
    }
    
    public function getBugsByClientWithDetails($clientId) {
        $sql = "SELECT b.*, 
                       p.name as project_name,
                       bc.name as category_name,
                       u1.username as reported_by_name,
                       u2.username as assigned_to_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                LEFT JOIN users u1 ON b.reported_by = u1.id
                LEFT JOIN users u2 ON b.assigned_to = u2.id
                WHERE p.client_id = ?
                ORDER BY b.created_at DESC";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetchAll();
    }
    
    public function getCriticalBugsByManager($managerId) {
        $sql = "SELECT b.*, p.name as project_name, bc.name as category_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                WHERE p.project_manager_id = ? AND b.severity = 'critical'
                ORDER BY b.created_at DESC";
        
        $stmt = $this->query($sql, [$managerId]);
        return $stmt->fetchAll();
    }
    
    public function getCriticalBugsByUser($userId) {
        $sql = "SELECT b.*, p.name as project_name, bc.name as category_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                WHERE (b.assigned_to = ? OR b.reported_by = ?) AND b.severity = 'critical'
                ORDER BY b.created_at DESC";
        
        $stmt = $this->query($sql, [$userId, $userId]);
        return $stmt->fetchAll();
    }
    
    public function getCriticalBugsByClient($clientId) {
        $sql = "SELECT b.*, p.name as project_name, bc.name as category_name
                FROM {$this->table} b
                LEFT JOIN projects p ON b.project_id = p.id
                LEFT JOIN bug_categories bc ON b.category_id = bc.id
                WHERE p.client_id = ? AND b.severity = 'critical'
                ORDER BY b.created_at DESC";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetchAll();
    }
}
?>