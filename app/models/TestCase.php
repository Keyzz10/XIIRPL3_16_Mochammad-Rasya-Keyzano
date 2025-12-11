<?php
/**
 * Test Case Model
 */

class TestCase extends BaseModel {
    protected $table = 'test_cases';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function getProjectTestCases($projectId) {
        $sql = "SELECT tc.*, 
                       u.username as created_by_name,
                       COUNT(te.id) as execution_count,
                       COUNT(CASE WHEN te.status = 'pass' THEN 1 END) as passed_count,
                       COUNT(CASE WHEN te.status = 'fail' THEN 1 END) as failed_count
                FROM {$this->table} tc
                LEFT JOIN users u ON tc.created_by = u.id
                LEFT JOIN test_executions te ON tc.id = te.test_case_id
                WHERE tc.project_id = ?
                GROUP BY tc.id
                ORDER BY tc.created_at DESC";
        
        $stmt = $this->query($sql, [$projectId]);
        return $stmt->fetchAll();
    }
    
    public function getTestCasesByType($projectId, $type) {
        $sql = "SELECT tc.*, u.username as created_by_name
                FROM {$this->table} tc
                LEFT JOIN users u ON tc.created_by = u.id
                WHERE tc.project_id = ? AND tc.type = ?
                ORDER BY tc.created_at DESC";
        
        $stmt = $this->query($sql, [$projectId, $type]);
        return $stmt->fetchAll();
    }
    
    public function getTestCasesByPriority($projectId, $priority) {
        $sql = "SELECT tc.*, u.username as created_by_name
                FROM {$this->table} tc
                LEFT JOIN users u ON tc.created_by = u.id
                WHERE tc.project_id = ? AND tc.priority = ?
                ORDER BY tc.created_at DESC";
        
        $stmt = $this->query($sql, [$projectId, $priority]);
        return $stmt->fetchAll();
    }
    
    public function searchTestCases($projectId, $search) {
        $sql = "SELECT tc.*, u.username as created_by_name
                FROM {$this->table} tc
                LEFT JOIN users u ON tc.created_by = u.id
                WHERE tc.project_id = ? 
                AND (tc.title LIKE ? OR tc.description LIKE ? OR tc.test_steps LIKE ?)
                ORDER BY tc.created_at DESC";
        
        $searchTerm = "%{$search}%";
        $stmt = $this->query($sql, [$projectId, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function createTestCase($data) {
        return $this->create($data);
    }
    
    public function updateTestCase($testCaseId, $data) {
        return $this->update($testCaseId, $data);
    }
    
    public function getTestCaseStats($projectId) {
        $sql = "SELECT 
                    COUNT(*) as total_test_cases,
                    COUNT(CASE WHEN priority = 'critical' THEN 1 END) as critical_cases,
                    COUNT(CASE WHEN priority = 'high' THEN 1 END) as high_cases,
                    COUNT(CASE WHEN priority = 'medium' THEN 1 END) as medium_cases,
                    COUNT(CASE WHEN priority = 'low' THEN 1 END) as low_cases,
                    COUNT(CASE WHEN type = 'functional' THEN 1 END) as functional_cases,
                    COUNT(CASE WHEN type = 'ui' THEN 1 END) as ui_cases,
                    COUNT(CASE WHEN type = 'performance' THEN 1 END) as performance_cases,
                    COUNT(CASE WHEN type = 'security' THEN 1 END) as security_cases,
                    COUNT(CASE WHEN type = 'usability' THEN 1 END) as usability_cases,
                    COUNT(CASE WHEN type = 'compatibility' THEN 1 END) as compatibility_cases
                FROM {$this->table} 
                WHERE project_id = ?";
        
        $stmt = $this->query($sql, [$projectId]);
        return $stmt->fetch();
    }
    
    public function getTestCaseDetails($testCaseId) {
        $sql = "SELECT tc.*, 
                       u.username as created_by_name,
                       p.name as project_name
                FROM {$this->table} tc
                LEFT JOIN users u ON tc.created_by = u.id
                LEFT JOIN projects p ON tc.project_id = p.id
                WHERE tc.id = ?";
        
        $stmt = $this->query($sql, [$testCaseId]);
        return $stmt->fetch();
    }

    /**
     * Record a test execution result for a test case
     */
    public function addExecution($testCaseId, $userId, $status, $notes = null) {
        $stmt = $this->db->prepare(
            "INSERT INTO test_executions (test_case_id, executed_by, status, comments, executed_at) VALUES (?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([$testCaseId, $userId, $status, $notes]);
    }

    /**
     * Fetch execution history for a test case
     */
    public function getExecutions($testCaseId) {
        $sql = "SELECT te.*, u.username as executed_by_name
                FROM test_executions te
                LEFT JOIN users u ON te.executed_by = u.id
                WHERE te.test_case_id = ?
                ORDER BY te.executed_at DESC";
        $stmt = $this->query($sql, [$testCaseId]);
        return $stmt->fetchAll();
    }
    
    public function getAllWithDetails() {
        $sql = "SELECT tc.*, 
                       u.username as created_by_name,
                       p.name as project_name,
                       COUNT(te.id) as execution_count,
                       COUNT(CASE WHEN te.status = 'pass' THEN 1 END) as passed_count,
                       COUNT(CASE WHEN te.status = 'fail' THEN 1 END) as failed_count,
                       (
                           SELECT te2.status 
                           FROM test_executions te2 
                           WHERE te2.test_case_id = tc.id 
                           ORDER BY te2.executed_at DESC, te2.id DESC 
                           LIMIT 1
                       ) as execution_status,
                       (
                           SELECT te3.status 
                           FROM test_executions te3 
                           WHERE te3.test_case_id = tc.id 
                           ORDER BY te3.executed_at DESC, te3.id DESC 
                           LIMIT 1
                       ) as last_result
                FROM {$this->table} tc
                LEFT JOIN users u ON tc.created_by = u.id
                LEFT JOIN projects p ON tc.project_id = p.id
                LEFT JOIN test_executions te ON tc.id = te.test_case_id
                GROUP BY tc.id
                ORDER BY tc.created_at DESC";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Fetch test cases with details filtered by a list of project IDs
     */
    public function getAllWithDetailsByProjectIds($projectIds) {
        if (empty($projectIds)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
        $sql = "SELECT tc.*, 
                       u.username as created_by_name,
                       p.name as project_name,
                       COUNT(te.id) as execution_count,
                       COUNT(CASE WHEN te.status = 'pass' THEN 1 END) as passed_count,
                       COUNT(CASE WHEN te.status = 'fail' THEN 1 END) as failed_count,
                       (
                           SELECT te2.status 
                           FROM test_executions te2 
                           WHERE te2.test_case_id = tc.id 
                           ORDER BY te2.executed_at DESC, te2.id DESC 
                           LIMIT 1
                       ) as execution_status,
                       (
                           SELECT te3.status 
                           FROM test_executions te3 
                           WHERE te3.test_case_id = tc.id 
                           ORDER BY te3.executed_at DESC, te3.id DESC 
                           LIMIT 1
                       ) as last_result
                FROM {$this->table} tc
                LEFT JOIN users u ON tc.created_by = u.id
                LEFT JOIN projects p ON tc.project_id = p.id
                LEFT JOIN test_executions te ON tc.id = te.test_case_id
                WHERE tc.project_id IN ({$placeholders})
                GROUP BY tc.id
                ORDER BY tc.created_at DESC";
        $stmt = $this->query($sql, $projectIds);
        return $stmt->fetchAll();
    }

    /**
     * Recent/completed executions list for reporting
     */
    public function getRecentExecutions($limit = 50) {
        $limit = max(1, (int)$limit);
        $sql = "SELECT te.*, 
                       tc.title as test_case_title,
                       p.name as project_name,
                       u.username as executed_by_name
                FROM test_executions te
                LEFT JOIN test_cases tc ON te.test_case_id = tc.id
                LEFT JOIN projects p ON tc.project_id = p.id
                LEFT JOIN users u ON te.executed_by = u.id
                WHERE te.status IN ('pass','fail','blocked')
                ORDER BY te.executed_at DESC, te.id DESC
                LIMIT {$limit}";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getTestStats() {
        $sql = "SELECT 
                    COUNT(*) as total_test_cases,
                    COUNT(CASE WHEN priority = 'critical' THEN 1 END) as critical_cases,
                    COUNT(CASE WHEN priority = 'high' THEN 1 END) as high_cases,
                    COUNT(CASE WHEN priority = 'medium' THEN 1 END) as medium_cases,
                    COUNT(CASE WHEN priority = 'low' THEN 1 END) as low_cases,
                    COUNT(CASE WHEN type = 'functional' THEN 1 END) as functional_cases,
                    COUNT(CASE WHEN type = 'ui' THEN 1 END) as ui_cases,
                    COUNT(CASE WHEN type = 'performance' THEN 1 END) as performance_cases,
                    COUNT(CASE WHEN type = 'security' THEN 1 END) as security_cases,
                    COUNT(CASE WHEN type = 'usability' THEN 1 END) as usability_cases,
                    COUNT(CASE WHEN type = 'compatibility' THEN 1 END) as compatibility_cases
                FROM {$this->table}";
        
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }

    /**
     * Overall execution stats for header cards (passed/failed) for all projects
     */
    public function getExecutionStatsAll() {
        $sql = "SELECT 
                    COUNT(CASE WHEN te.status = 'pass' THEN 1 END) as passed_tests,
                    COUNT(CASE WHEN te.status = 'fail' THEN 1 END) as failed_tests
                FROM test_cases tc
                LEFT JOIN test_executions te ON tc.id = te.test_case_id";
        $stmt = $this->query($sql);
        return $stmt->fetch();
    }

    /**
     * Execution stats filtered by project IDs
     */
    public function getExecutionStatsByProjectIds($projectIds) {
        if (empty($projectIds)) {
            return ['passed_tests' => 0, 'failed_tests' => 0];
        }
        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
        $sql = "SELECT 
                    COUNT(CASE WHEN te.status = 'pass' THEN 1 END) as passed_tests,
                    COUNT(CASE WHEN te.status = 'fail' THEN 1 END) as failed_tests
                FROM test_cases tc
                LEFT JOIN test_executions te ON tc.id = te.test_case_id
                WHERE tc.project_id IN ({$placeholders})";
        $stmt = $this->query($sql, $projectIds);
        return $stmt->fetch();
    }
    
    public function deleteByProject($projectId) {
        $sql = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$projectId]);
    }
}
?>