<?php
/**
 * Task Model
 */

class Task extends BaseModel {
    protected $table = 'tasks';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function getAllWithDetails($limit = null) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name,
                       u2.username as created_by_name,
                       u3.username as reporter_name,
                       u4.username as verified_by_name,
                       pt.title as parent_task_title
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                LEFT JOIN users u3 ON t.reporter_id = u3.id
                LEFT JOIN users u4 ON t.verified_by = u4.id
                LEFT JOIN tasks pt ON t.parent_task_id = pt.id
                ORDER BY t.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getUserTasks($userId, $limit = null) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                WHERE t.assigned_to = ?
                ORDER BY 
                    CASE WHEN t.due_date IS NULL THEN 1 ELSE 0 END,
                    t.due_date ASC,
                    t.priority DESC,
                    t.created_at DESC";
        
        $params = [$userId];
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getProjectTasksByStatus($projectId, $statuses) {
        if (empty($statuses)) {
            return [];
        }
        
        $placeholders = implode(',', array_fill(0, count($statuses), '?'));
        $sql = "SELECT t.*, 
                       u1.username as assigned_to_name,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                WHERE t.project_id = ? AND t.status IN ({$placeholders})
                ORDER BY t.created_at DESC";
        
        $params = array_merge([$projectId], $statuses);
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getProjectTasks($projectId, $status = null) {
        $sql = "SELECT t.*, 
                       u1.username as assigned_to_name,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                WHERE t.project_id = ?";
        
        $params = [$projectId];
        
        if ($status) {
            $sql .= " AND t.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY t.created_at DESC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Get Done tasks for the provided project IDs (used by QA dashboard)
     */
    public function getDoneTasksByProjectIds($projectIds, $limit = 10) {
        if (empty($projectIds)) { return []; }
        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
        $sql = "SELECT t.*, p.name as project_name, u.username as assigned_to_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.status = 'done' AND t.project_id IN ({$placeholders})
                ORDER BY t.updated_at DESC, t.id DESC
                LIMIT {$limit}";
        $stmt = $this->query($sql, $projectIds);
        return $stmt->fetchAll();
    }
    
    public function getTasksForProjectManager($managerId) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                WHERE p.project_manager_id = ?
                ORDER BY t.created_at DESC";
        
        $stmt = $this->query($sql, [$managerId]);
        return $stmt->fetchAll();
    }
    
    public function getOverdueTasksForManager($managerId) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                WHERE p.project_manager_id = ? 
                AND t.due_date < CURDATE() 
                AND t.status != 'done'
                ORDER BY t.due_date ASC";
        
        $stmt = $this->query($sql, [$managerId]);
        return $stmt->fetchAll();
    }
    
    public function createTask($data) {
        $taskId = $this->create($data);
        
        if ($taskId) {
            // Update project progress
            $projectModel = new Project($this->db);
            $projectModel->updateProgress($data['project_id']);
        }
        
        return $taskId;
    }

    /**
     * Fetch single task with joined project/user names for detail view
     */
    public function findWithDetails($taskId) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name,
                       u1.role as assigned_to_role,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                WHERE t.id = ?";
        $stmt = $this->query($sql, [$taskId]);
        return $stmt->fetch();
    }
    
    public function updateTask($taskId, $data) {
        $task = $this->findById($taskId);
        if (!$task) return false;
        
        $result = $this->update($taskId, $data);
        
        if ($result) {
            // Update project progress
            $projectModel = new Project($this->db);
            $projectModel->updateProgress($task['project_id']);
        }
        
        return $result;
    }
    
    public function getTaskComments($taskId, $currentUserRole = null) {
        // Admin and project manager can see deleted comments
        $showDeleted = in_array($currentUserRole, ['super_admin', 'admin', 'project_manager']);
        
        $sql = "SELECT tc.*, 
                       u.full_name, u.username, u.profile_photo,
                       parent.comment as parent_comment,
                       parent.is_deleted as parent_is_deleted,
                       parent_user.username as parent_user_name,
                       deleted_user.username as deleted_by_username,
                       deleted_user.full_name as deleted_by_name,
                       edited_user.username as edited_by_username,
                       edited_user.full_name as edited_by_name
                FROM task_comments tc
                LEFT JOIN users u ON tc.user_id = u.id
                LEFT JOIN task_comments parent ON tc.parent_comment_id = parent.id
                LEFT JOIN users parent_user ON parent.user_id = parent_user.id
                LEFT JOIN users deleted_user ON tc.deleted_by = deleted_user.id
                LEFT JOIN users edited_user ON tc.edited_by = edited_user.id
                WHERE tc.task_id = ?" . ($showDeleted ? "" : " AND tc.is_deleted = 0") . "
                ORDER BY tc.created_at ASC";
        
        $stmt = $this->query($sql, [$taskId]);
        return $stmt->fetchAll();
    }
    
    public function addComment($taskId, $userId, $comment, $parentCommentId = null) {
        $data = [
            'task_id' => $taskId,
            'user_id' => $userId,
            'comment' => $comment,
            'parent_comment_id' => $parentCommentId
        ];
        
        $stmt = $this->db->prepare("INSERT INTO task_comments (task_id, user_id, comment, parent_comment_id) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$taskId, $userId, $comment, $parentCommentId]);
        
        // Return the inserted comment ID
        if ($result) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    public function getTaskAttachments($taskId) {
        $sql = "SELECT ta.*, u.username as uploaded_by_name
                FROM task_attachments ta
                LEFT JOIN users u ON ta.uploaded_by = u.id
                WHERE ta.task_id = ?
                ORDER BY ta.uploaded_at DESC";
        
        $stmt = $this->query($sql, [$taskId]);
        return $stmt->fetchAll();
    }
    
    public function addAttachment($taskId, $data) {
        // Prefer newer schema with `filename` + `original_name` + `comment_id`
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO task_attachments (task_id, comment_id, filename, original_name, file_path, file_size, file_type, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            return $stmt->execute([
                $taskId,
                $data['comment_id'] ?? null,
                $data['filename'],
                $data['original_name'] ?? $data['filename'],
                $data['file_path'],
                $data['file_size'],
                $data['file_type'],
                $data['uploaded_by']
            ]);
        } catch (\PDOException $e) {
            // Fallback to older schema without comment_id
            try {
                $stmt = $this->db->prepare(
                    "INSERT INTO task_attachments (task_id, filename, original_name, file_path, file_size, file_type, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                return $stmt->execute([
                    $taskId,
                    $data['filename'],
                    $data['original_name'] ?? $data['filename'],
                    $data['file_path'],
                    $data['file_size'],
                    $data['file_type'],
                    $data['uploaded_by']
                ]);
            } catch (\PDOException $e2) {
                // Fallback to oldest schema with `file_name` and without `original_name`
                $stmt = $this->db->prepare(
                    "INSERT INTO task_attachments (task_id, file_name, file_path, file_size, file_type, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)"
                );
                return $stmt->execute([
                    $taskId,
                    $data['filename'],
                    $data['file_path'],
                    $data['file_size'],
                    $data['file_type'],
                    $data['uploaded_by']
                ]);
            }
        }
    }
    
    public function searchTasks($search, $projectId = null, $assignedTo = null, $status = null) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                WHERE (t.title LIKE ? OR t.description LIKE ?)";
        
        $params = ["%{$search}%", "%{$search}%"];
        
        if ($projectId) {
            $sql .= " AND t.project_id = ?";
            $params[] = $projectId;
        }
        
        if ($assignedTo) {
            $sql .= " AND t.assigned_to = ?";
            $params[] = $assignedTo;
        }
        
        if ($status) {
            $sql .= " AND t.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY t.created_at DESC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getTasksByStatus($status, $projectId = null) {
        if ($projectId) {
            $sql = "SELECT t.*, u.username as assigned_to_name
                    FROM {$this->table} t
                    LEFT JOIN users u ON t.assigned_to = u.id
                    WHERE t.status = ? AND t.project_id = ?
                    ORDER BY t.created_at DESC";
            $params = [$status, $projectId];
        } else {
            $sql = "SELECT t.*, p.name as project_name, u.username as assigned_to_name
                    FROM {$this->table} t
                    LEFT JOIN projects p ON t.project_id = p.id
                    LEFT JOIN users u ON t.assigned_to = u.id
                    WHERE t.status = ?
                    ORDER BY t.created_at DESC";
            $params = [$status];
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getOverdueTasks($userId = null) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u.username as assigned_to_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.due_date < CURDATE() 
                AND t.status != 'done'";
        
        $params = [];
        
        if ($userId) {
            $sql .= " AND t.assigned_to = ?";
            $params[] = $userId;
        }
        
        $sql .= " ORDER BY t.due_date ASC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getTaskStats($projectId = null) {
        $sql = "SELECT 
                    COUNT(*) as total_tasks,
                    COUNT(CASE WHEN status = 'to_do' THEN 1 END) as todo_tasks,
                    COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as progress_tasks,
                    COUNT(CASE WHEN status = 'done' THEN 1 END) as done_tasks,
                    COUNT(CASE WHEN due_date < CURDATE() AND status != 'done' THEN 1 END) as overdue_tasks,
                    AVG(progress) as avg_progress
                FROM {$this->table}";
        
        $params = [];
        
        if ($projectId) {
            $sql .= " WHERE project_id = ?";
            $params[] = $projectId;
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    public function getSubTasks($parentTaskId) {
        $sql = "SELECT t.*, u.username as assigned_to_name
                FROM {$this->table} t
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE t.parent_task_id = ?
                ORDER BY t.created_at DESC";
        
        $stmt = $this->query($sql, [$parentTaskId]);
        return $stmt->fetchAll();
    }
    
    public function updateProgress($taskId, $progress) {
        return $this->update($taskId, ['progress' => $progress]);
    }
    
    public function deleteByProject($projectId) {
        $sql = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$projectId]);
    }
    
    /**
     * Get tasks for QA Tester - all tasks in projects they are assigned to
     */
    public function getTasksForQA($userId, $limit = null) {
        $sql = "SELECT DISTINCT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                LEFT JOIN project_teams pt ON p.id = pt.project_id
                WHERE pt.user_id = ? AND pt.role_in_project = 'qa_tester'
                ORDER BY t.created_at DESC";
        
        $params = [$userId];
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Get task stats for Project Manager
     */
    public function getTaskStatsForProjectManager($userId) {
        $sql = "SELECT 
                    COUNT(*) as total_tasks,
                    COUNT(CASE WHEN t.status = 'to_do' THEN 1 END) as todo_tasks,
                    COUNT(CASE WHEN t.status = 'in_progress' THEN 1 END) as progress_tasks,
                    COUNT(CASE WHEN t.status = 'done' THEN 1 END) as done_tasks,
                    COUNT(CASE WHEN t.due_date < CURDATE() AND t.status != 'done' THEN 1 END) as overdue_tasks,
                    AVG(t.progress) as avg_progress
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                WHERE p.project_manager_id = ?";
        
        $stmt = $this->query($sql, [$userId]);
        return $stmt->fetch();
    }
    
    /**
     * Get task stats for QA Tester
     */
    public function getTaskStatsForQA($userId) {
        $sql = "SELECT 
                    COUNT(DISTINCT t.id) as total_tasks,
                    COUNT(CASE WHEN t.status = 'to_do' THEN 1 END) as todo_tasks,
                    COUNT(CASE WHEN t.status = 'in_progress' THEN 1 END) as progress_tasks,
                    COUNT(CASE WHEN t.status = 'done' THEN 1 END) as done_tasks,
                    COUNT(CASE WHEN t.due_date < CURDATE() AND t.status != 'done' THEN 1 END) as overdue_tasks,
                    AVG(t.progress) as avg_progress
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN project_teams pt ON p.id = pt.project_id
                WHERE pt.user_id = ? AND pt.role_in_project = 'qa_tester'";
        
        $stmt = $this->query($sql, [$userId]);
        return $stmt->fetch();
    }
    
    /**
     * Get task stats for specific user
     */
    public function getTaskStatsForUser($userId) {
        $sql = "SELECT 
                    COUNT(*) as total_tasks,
                    COUNT(CASE WHEN status = 'to_do' THEN 1 END) as todo_tasks,
                    COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as progress_tasks,
                    COUNT(CASE WHEN status = 'done' THEN 1 END) as done_tasks,
                    COUNT(CASE WHEN due_date < CURDATE() AND status != 'done' THEN 1 END) as overdue_tasks,
                    AVG(progress) as avg_progress
                FROM {$this->table}
                WHERE assigned_to = ?";
        
        $stmt = $this->query($sql, [$userId]);
        return $stmt->fetch();
    }
    
    
    /**
     * Get available tags
     */
    public function getAvailableTags() {
        $sql = "SELECT DISTINCT tags FROM {$this->table} WHERE tags IS NOT NULL AND tags != ''";
        $stmt = $this->query($sql);
        $results = $stmt->fetchAll();
        
        $allTags = [];
        foreach ($results as $result) {
            $tags = explode(',', $result['tags']);
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (!empty($tag) && !in_array($tag, $allTags)) {
                    $allTags[] = $tag;
                }
            }
        }
        
        sort($allTags);
        return $allTags;
    }
    
    // Role-based methods for reports
    public function getTaskStatsByManager($managerId) {
        return $this->getTaskStatsForProjectManager($managerId);
    }
    
    public function getTaskStatsByUser($userId) {
        return $this->getTaskStatsForUser($userId);
    }
    
    public function getTaskStatsByClient($clientId) {
        $sql = "SELECT 
                    COUNT(DISTINCT t.id) as total_tasks,
                    COUNT(CASE WHEN t.status = 'to_do' THEN 1 END) as todo_tasks,
                    COUNT(CASE WHEN t.status = 'in_progress' THEN 1 END) as progress_tasks,
                    COUNT(CASE WHEN t.status = 'done' THEN 1 END) as done_tasks,
                    COUNT(CASE WHEN t.due_date < CURDATE() AND t.status != 'done' THEN 1 END) as overdue_tasks,
                    AVG(t.progress) as avg_progress
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                WHERE p.client_id = ?";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetch();
    }
    
    public function getTasksByManagerWithDetails($managerId) {
        return $this->getTasksForProjectManager($managerId);
    }
    
    public function getTasksByUserWithDetails($userId) {
        return $this->getUserTasks($userId);
    }
    
    public function getTasksByClientWithDetails($clientId) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u1.username as assigned_to_name,
                       u2.username as created_by_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u1 ON t.assigned_to = u1.id
                LEFT JOIN users u2 ON t.created_by = u2.id
                WHERE p.client_id = ?
                ORDER BY t.created_at DESC";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetchAll();
    }
    
    public function getOverdueTasksByManager($managerId) {
        return $this->getOverdueTasksForManager($managerId);
    }
    
    public function getOverdueTasksByUser($userId) {
        return $this->getOverdueTasks($userId);
    }
    
    public function getOverdueTasksByClient($clientId) {
        $sql = "SELECT t.*, 
                       p.name as project_name,
                       u.username as assigned_to_name
                FROM {$this->table} t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN users u ON t.assigned_to = u.id
                WHERE p.client_id = ? 
                AND t.due_date < CURDATE() 
                AND t.status != 'done'
                ORDER BY t.due_date ASC";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetchAll();
    }
}
?>