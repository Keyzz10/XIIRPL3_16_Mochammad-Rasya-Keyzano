<?php
/**
 * User Model
 */

class User extends BaseModel {
    protected $table = 'users';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function authenticate($email, $password) {
        $user = $this->findOneBy('email', $email);
        
        if (!$user) {
            return ['error' => 'Pengguna tidak ditemukan dengan email ini'];
        }
        
        if ($user['status'] !== 'active') {
            return ['error' => 'Akun pengguna tidak aktif. Silakan hubungi administrator untuk mengaktifkan akun Anda.'];
        }
        
        if (password_verify($password, $user['password'])) {
            $this->updateLastLogin($user['id']);
            return $user;
        }
        
        return ['error' => 'Kata sandi tidak valid'];
    }
    
    public function register($data) {
        // Check if email already exists
        if ($this->exists('email', $data['email'])) {
            return ['error' => 'Email already exists'];
        }
        
        // Check if username already exists
        if ($this->exists('username', $data['username'])) {
            return ['error' => 'Username already exists'];
        }
        
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Set default values
        $data['status'] = 'active';
        $data['role'] = $data['role'] ?? 'developer';
        
        $userId = $this->create($data);
        
        if ($userId) {
            return ['success' => true, 'user_id' => $userId];
        }
        
        return ['error' => 'Registration failed'];
    }
    
    public function updateProfile($userId, $data) {
        // Remove password from data if empty
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        // Check if email exists for other users
        if (isset($data['email']) && $this->exists('email', $data['email'], $userId)) {
            return ['error' => 'Email already exists'];
        }
        
        // Check if username exists for other users
        if (isset($data['username']) && $this->exists('username', $data['username'], $userId)) {
            return ['error' => 'Username already exists'];
        }
        
        if ($this->update($userId, $data)) {
            return ['success' => true];
        }
        
        return ['error' => 'Profile update failed'];
    }
    
    public function updateLastLogin($userId) {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
    
    public function getUsersByRole($role) {
        return $this->findBy('role', $role);
    }
    
    public function getActiveUsers() {
        return $this->findBy('status', 'active');
    }
    
    public function searchUsers($search, $role = null) {
        $sql = "SELECT * FROM {$this->table} WHERE 
                (full_name LIKE ? OR email LIKE ? OR username LIKE ?)";
        $params = ["%{$search}%", "%{$search}%", "%{$search}%"];
        
        if ($role) {
            $sql .= " AND role = ?";
            $params[] = $role;
        }
        
        $sql .= " AND status = 'active' ORDER BY full_name";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function findByUsername($username) {
        return $this->findOneBy('username', $username);
    }
    
    public function getUserStats() {
        $sql = "SELECT 
                    COUNT(*) as total_users,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_users,
                    SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admin_users,
                    SUM(CASE WHEN role = 'project_manager' THEN 1 ELSE 0 END) as project_managers,
                    SUM(CASE WHEN role = 'developer' THEN 1 ELSE 0 END) as developers,
                    SUM(CASE WHEN role = 'qa_tester' THEN 1 ELSE 0 END) as qa_testers,
                    SUM(CASE WHEN role = 'client' THEN 1 ELSE 0 END) as clients,
                    SUM(CASE WHEN last_login >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as recent_logins
                FROM {$this->table}";
        
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }
    
    public function changePassword($userId, $currentPassword, $newPassword) {
        $user = $this->findById($userId);
        
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return ['error' => 'Current password is incorrect'];
        }
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        if ($this->update($userId, ['password' => $hashedPassword])) {
            return ['success' => true];
        }
        
        return ['error' => 'Password change failed'];
    }
    
    public function getUsersForProject($projectId) {
        $sql = "SELECT u.*, pt.role_in_project 
                FROM {$this->table} u
                INNER JOIN project_teams pt ON u.id = pt.user_id
                WHERE pt.project_id = ? AND u.status = 'active'
                ORDER BY u.full_name";
        
        $stmt = $this->query($sql, [$projectId]);
        return $stmt->fetchAll();
    }
    
    public function getAvailableUsers($excludeProjectId = null) {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' AND role IN ('developer', 'qa_tester', 'project_manager')";
        $params = [];
        
        if ($excludeProjectId) {
            $sql .= " AND id NOT IN (SELECT user_id FROM project_teams WHERE project_id = ?)";
            $params[] = $excludeProjectId;
        }
        
        $sql .= " ORDER BY full_name";
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    // Role-based methods for reports
    public function getUserStatsByManager($managerId) {
        $sql = "SELECT 
                    COUNT(DISTINCT u.id) as active_users,
                    COUNT(DISTINCT CASE WHEN u.role = 'developer' THEN u.id END) as developers,
                    COUNT(DISTINCT CASE WHEN u.role = 'qa_tester' THEN u.id END) as qa_testers,
                    COUNT(DISTINCT CASE WHEN u.last_login >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN u.id END) as recent_logins
                FROM {$this->table} u
                LEFT JOIN project_teams pt ON u.id = pt.user_id
                LEFT JOIN projects p ON pt.project_id = p.id
                WHERE p.project_manager_id = ? AND u.status = 'active'";
        
        $stmt = $this->query($sql, [$managerId]);
        return $stmt->fetch();
    }
}
?>