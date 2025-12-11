<?php
/**
 * Project Model
 */

class Project extends BaseModel {
    protected $table = 'projects';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function getAllWithDetails($limit = null) {
        $sql = "SELECT p.*, 
                       c.company_name as client_name,
                       u.username as manager_name,
                       COUNT(DISTINCT t.id) as total_tasks,
                       COUNT(DISTINCT CASE WHEN t.status = 'done' THEN t.id END) as completed_tasks
                FROM {$this->table} p
                LEFT JOIN clients c ON p.client_id = c.id
                LEFT JOIN users u ON p.project_manager_id = u.id
                LEFT JOIN tasks t ON p.id = t.project_id
                GROUP BY p.id
                ORDER BY p.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getProjectsByManager($managerId) {
        $sql = "SELECT p.*, 
                       c.company_name as client_name,
                       COUNT(DISTINCT t.id) as total_tasks,
                       COUNT(DISTINCT CASE WHEN t.status = 'done' THEN t.id END) as completed_tasks
                FROM {$this->table} p
                LEFT JOIN clients c ON p.client_id = c.id
                LEFT JOIN tasks t ON p.id = t.project_id
                WHERE p.project_manager_id = ?
                GROUP BY p.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->query($sql, [$managerId]);
        return $stmt->fetchAll();
    }
    
    public function getUserProjects($userId, $limit = null) {
        $sql = "SELECT DISTINCT p.*, 
                       c.company_name as client_name,
                       u.username as manager_name,
                       COUNT(DISTINCT t.id) as total_tasks,
                       COUNT(DISTINCT CASE WHEN t.status = 'done' THEN t.id END) as completed_tasks
                FROM {$this->table} p
                LEFT JOIN clients c ON p.client_id = c.id
                LEFT JOIN users u ON p.project_manager_id = u.id
                LEFT JOIN project_teams pt ON p.id = pt.project_id
                LEFT JOIN tasks t ON p.id = t.project_id
                WHERE p.project_manager_id = ? OR pt.user_id = ?
                GROUP BY p.id
                ORDER BY p.created_at DESC";
        
        $params = [$userId, $userId];
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getClientProjects($clientId) {
        return $this->findBy('client_id', $clientId);
    }
    
    public function createProject($data, $teamMembers = null) {
        // Calculate initial progress
        $data['progress'] = 0.00;
        
        $projectId = $this->create($data);
        
        if ($projectId && $teamMembers) {
            $this->assignTeamMembers($projectId, $teamMembers);
        }
        
        return $projectId;
    }
    
    public function updateProject($projectId, $data, $teamMembers = null) {
        $result = $this->update($projectId, $data);
        
        if ($result && $teamMembers !== null) {
            $this->updateTeamMembers($projectId, $teamMembers);
        }
        
        return $result;
    }
    
    public function assignTeamMembers($projectId, $teamMembers) {
        // Clear existing team assignments
        $stmt = $this->db->prepare("DELETE FROM project_teams WHERE project_id = ?");
        $stmt->execute([$projectId]);
        
        // Add new team members
        foreach ($teamMembers as $member) {
            $stmt = $this->db->prepare("INSERT INTO project_teams (project_id, user_id, role_in_project) VALUES (?, ?, ?)");
            $stmt->execute([$projectId, $member['user_id'], $member['role']]);
        }
    }
    
    public function updateTeamMembers($projectId, $teamMembers) {
        return $this->assignTeamMembers($projectId, $teamMembers);
    }
    
    public function getTeamMembers($projectId) {
        $sql = "SELECT pt.*, u.username, u.email, u.role as user_role, u.profile_photo
                FROM project_teams pt
                JOIN users u ON pt.user_id = u.id
                WHERE pt.project_id = ?
                ORDER BY u.username";
        
        $stmt = $this->query($sql, [$projectId]);
        return $stmt->fetchAll();
    }
    
    public function updateProgress($projectId) {
        // Calculate project progress based on completed tasks
        $sql = "SELECT 
                    COUNT(*) as total_tasks,
                    COUNT(CASE WHEN status = 'done' THEN 1 END) as completed_tasks
                FROM tasks 
                WHERE project_id = ?";
        
        $stmt = $this->query($sql, [$projectId]);
        $result = $stmt->fetch();
        
        $progress = 0;
        if ($result['total_tasks'] > 0) {
            $progress = ($result['completed_tasks'] / $result['total_tasks']) * 100;
        }
        
        return $this->update($projectId, ['progress' => $progress]);
    }
    
    public function getProjectStats($projectId) {
        $sql = "SELECT 
                    COUNT(DISTINCT t.id) as total_tasks,
                    COUNT(DISTINCT CASE WHEN t.status = 'to_do' THEN t.id END) as pending_tasks,
                    COUNT(DISTINCT CASE WHEN t.status = 'in_progress' THEN t.id END) as active_tasks,
                    COUNT(DISTINCT CASE WHEN t.status = 'done' THEN t.id END) as completed_tasks,
                    COUNT(DISTINCT b.id) as total_bugs,
                    COUNT(DISTINCT CASE WHEN b.status IN ('new', 'assigned', 'in_progress') THEN b.id END) as open_bugs,
                    COUNT(DISTINCT CASE WHEN b.severity = 'critical' THEN b.id END) as critical_bugs
                FROM projects p
                LEFT JOIN tasks t ON p.id = t.project_id
                LEFT JOIN bugs b ON p.id = b.project_id
                WHERE p.id = ?
                GROUP BY p.id";
        
        $stmt = $this->query($sql, [$projectId]);
        return $stmt->fetch();
    }
    
    public function searchProjects($search, $status = null, $managerId = null) {
        $sql = "SELECT p.*, 
                       c.company_name as client_name,
                       u.username as manager_name
                FROM {$this->table} p
                LEFT JOIN clients c ON p.client_id = c.id
                LEFT JOIN users u ON p.project_manager_id = u.id
                WHERE (p.name LIKE ? OR p.description LIKE ?)";
        
        $params = ["%{$search}%", "%{$search}%"];
        
        if ($status) {
            $sql .= " AND p.status = ?";
            $params[] = $status;
        }
        
        if ($managerId) {
            $sql .= " AND p.project_manager_id = ?";
            $params[] = $managerId;
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function getProjectsByStatus($status) {
        return $this->findBy('status', $status);
    }
    
    public function getOverdueProjects() {
        $sql = "SELECT p.*, 
                       c.company_name as client_name,
                       u.username as manager_name
                FROM {$this->table} p
                LEFT JOIN clients c ON p.client_id = c.id
                LEFT JOIN users u ON p.project_manager_id = u.id
                WHERE p.end_date < CURDATE() 
                AND p.status NOT IN ('completed', 'cancelled')
                ORDER BY p.end_date ASC";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function completeProject($projectId) {
        // Mark project as completed with 100% progress
        return $this->update($projectId, [
            'status' => 'completed',
            'progress' => 100.0
        ]);
    }

    public function reopenProject($projectId) {
        // Reopen project to in_progress and ensure progress is < 100
        $project = $this->findById($projectId);
        $newProgress = null;
        if ($project && isset($project['progress'])) {
            $current = (float)$project['progress'];
            $newProgress = $current >= 100.0 ? 99.0 : $current;
        }
        $data = ['status' => 'in_progress'];
        if ($newProgress !== null) {
            $data['progress'] = $newProgress;
        }
        return $this->update($projectId, $data);
    }
    
    // Role-based methods for reports
    public function getProjectsByManagerCount($managerId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE project_manager_id = ?";
        $stmt = $this->query($sql, [$managerId]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
    
    public function getProjectsByUser($userId) {
        $sql = "SELECT COUNT(DISTINCT p.id) as count 
                FROM {$this->table} p
                LEFT JOIN project_teams pt ON p.id = pt.project_id
                WHERE p.project_manager_id = ? OR pt.user_id = ?";
        $stmt = $this->query($sql, [$userId, $userId]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
    
    public function getProjectsByClient($clientId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE client_id = ?";
        $stmt = $this->query($sql, [$clientId]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
    
    public function getProjectsByManagerWithDetails($managerId) {
        return $this->getProjectsByManager($managerId);
    }
    
    public function getProjectsByUserWithDetails($userId) {
        return $this->getUserProjects($userId);
    }
    
    public function getProjectsByClientWithDetails($clientId) {
        $sql = "SELECT p.*, 
                       c.company_name as client_name,
                       u.username as manager_name,
                       COUNT(DISTINCT t.id) as total_tasks,
                       COUNT(DISTINCT CASE WHEN t.status = 'done' THEN t.id END) as completed_tasks
                FROM {$this->table} p
                LEFT JOIN clients c ON p.client_id = c.id
                LEFT JOIN users u ON p.project_manager_id = u.id
                LEFT JOIN tasks t ON p.id = t.project_id
                WHERE p.client_id = ?
                GROUP BY p.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetchAll();
    }
}
?>