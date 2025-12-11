<?php
/**
 * Client Model
 */

class Client extends BaseModel {
    protected $table = 'clients';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function getAllClientsWithProjects() {
        $sql = "SELECT c.*, 
                       COUNT(p.id) as project_count,
                       COUNT(CASE WHEN p.status = 'in_progress' THEN 1 END) as active_projects
                FROM {$this->table} c
                LEFT JOIN projects p ON c.id = p.client_id
                GROUP BY c.id
                ORDER BY c.company_name ASC";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getClientProjects($clientId) {
        $sql = "SELECT p.*, 
                       u.username as manager_name
                FROM projects p
                LEFT JOIN users u ON p.project_manager_id = u.id
                WHERE p.client_id = ?
                ORDER BY p.created_at DESC";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetchAll();
    }
    
    public function searchClients($search) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE company_name LIKE ? 
                OR contact_person LIKE ? 
                OR email LIKE ?
                ORDER BY company_name ASC";
        
        $searchTerm = "%{$search}%";
        $stmt = $this->query($sql, [$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function getClientStats($clientId) {
        $sql = "SELECT 
                    COUNT(DISTINCT p.id) as total_projects,
                    COUNT(DISTINCT CASE WHEN p.status = 'planning' THEN p.id END) as planning_projects,
                    COUNT(DISTINCT CASE WHEN p.status = 'in_progress' THEN p.id END) as active_projects,
                    COUNT(DISTINCT CASE WHEN p.status = 'completed' THEN p.id END) as completed_projects,
                    COUNT(DISTINCT t.id) as total_tasks,
                    COUNT(DISTINCT CASE WHEN t.status = 'done' THEN t.id END) as completed_tasks,
                    COUNT(DISTINCT b.id) as total_bugs,
                    COUNT(DISTINCT CASE WHEN b.status IN ('new', 'assigned', 'in_progress') THEN b.id END) as open_bugs
                FROM clients c
                LEFT JOIN projects p ON c.id = p.client_id
                LEFT JOIN tasks t ON p.id = t.project_id
                LEFT JOIN bugs b ON p.id = b.project_id
                WHERE c.id = ?
                GROUP BY c.id";
        
        $stmt = $this->query($sql, [$clientId]);
        return $stmt->fetch();
    }
    
    public function createClient($data) {
        // Validate unique email
        if ($this->exists('email', $data['email'])) {
            return false;
        }
        
        return $this->create($data);
    }
    
    public function updateClient($clientId, $data) {
        // Validate unique email (excluding current client)
        if (isset($data['email']) && $this->exists('email', $data['email'], $clientId)) {
            return false;
        }
        
        return $this->update($clientId, $data);
    }
}
?>