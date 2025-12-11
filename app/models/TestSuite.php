<?php
/**
 * Test Suite Model
 */

class TestSuite extends BaseModel {
    protected $table = 'test_suites';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function getProjectTestSuites($projectId) {
        $sql = "SELECT ts.*, 
                       u.username as created_by_name,
                       COUNT(DISTINCT tsc.test_case_id) as test_case_count,
                       COUNT(DISTINCT te.id) as execution_count,
                       COUNT(DISTINCT CASE WHEN te.status = 'pass' THEN te.id END) as passed_count,
                       COUNT(DISTINCT CASE WHEN te.status = 'fail' THEN te.id END) as failed_count
                FROM {$this->table} ts
                LEFT JOIN users u ON ts.created_by = u.id
                LEFT JOIN test_suite_cases tsc ON ts.id = tsc.test_suite_id
                LEFT JOIN test_executions te ON tsc.test_case_id = te.test_case_id
                WHERE ts.project_id = ?
                GROUP BY ts.id
                ORDER BY ts.created_at DESC";
        
        $stmt = $this->query($sql, [$projectId]);
        return $stmt->fetchAll();
    }
    
    public function getTestSuiteDetails($testSuiteId) {
        $sql = "SELECT ts.*, 
                       u.username as created_by_name,
                       p.name as project_name
                FROM {$this->table} ts
                LEFT JOIN users u ON ts.created_by = u.id
                LEFT JOIN projects p ON ts.project_id = p.id
                WHERE ts.id = ?";
        
        $stmt = $this->query($sql, [$testSuiteId]);
        return $stmt->fetch();
    }
    
    public function getTestSuiteTestCases($testSuiteId) {
        $sql = "SELECT tc.*, 
                       tsc.added_at,
                       u.username as created_by_name
                FROM test_suite_cases tsc
                JOIN test_cases tc ON tsc.test_case_id = tc.id
                LEFT JOIN users u ON tc.created_by = u.id
                WHERE tsc.test_suite_id = ?
                ORDER BY tsc.added_at ASC";
        
        $stmt = $this->query($sql, [$testSuiteId]);
        return $stmt->fetchAll();
    }
    
    public function addTestCaseToSuite($testSuiteId, $testCaseId) {
        // Check if test case is already in suite
        $sql = "SELECT COUNT(*) as count FROM test_suite_cases 
                WHERE test_suite_id = ? AND test_case_id = ?";
        $stmt = $this->query($sql, [$testSuiteId, $testCaseId]);
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            return false; // Already exists
        }
        
        $sql = "INSERT INTO test_suite_cases (test_suite_id, test_case_id, added_at) 
                VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$testSuiteId, $testCaseId]);
    }
    
    public function removeTestCaseFromSuite($testSuiteId, $testCaseId) {
        $sql = "DELETE FROM test_suite_cases 
                WHERE test_suite_id = ? AND test_case_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$testSuiteId, $testCaseId]);
    }
    
    public function createTestSuite($data) {
        return $this->create($data);
    }
    
    public function updateTestSuite($testSuiteId, $data) {
        return $this->update($testSuiteId, $data);
    }
    
    public function deleteTestSuite($testSuiteId) {
        // First remove all test cases from suite
        $sql = "DELETE FROM test_suite_cases WHERE test_suite_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$testSuiteId]);
        
        // Then delete the suite
        return $this->delete($testSuiteId);
    }
    
    public function getTestSuiteStats($testSuiteId) {
        $sql = "SELECT 
                    COUNT(DISTINCT tsc.test_case_id) as total_test_cases,
                    COUNT(DISTINCT te.id) as total_executions,
                    COUNT(DISTINCT CASE WHEN te.status = 'pass' THEN te.id END) as passed_executions,
                    COUNT(DISTINCT CASE WHEN te.status = 'fail' THEN te.id END) as failed_executions,
                    COUNT(DISTINCT CASE WHEN te.status = 'blocked' THEN te.id END) as skipped_executions,
                    COUNT(DISTINCT CASE WHEN tc.priority = 'critical' THEN tc.id END) as critical_cases,
                    COUNT(DISTINCT CASE WHEN tc.priority = 'high' THEN tc.id END) as high_cases
                FROM test_suite_cases tsc
                LEFT JOIN test_cases tc ON tsc.test_case_id = tc.id
                LEFT JOIN test_executions te ON tc.id = te.test_case_id
                WHERE tsc.test_suite_id = ?";
        
        $stmt = $this->query($sql, [$testSuiteId]);
        return $stmt->fetch();
    }
    
    public function searchTestSuites($projectId, $search) {
        $sql = "SELECT ts.*, u.username as created_by_name
                FROM {$this->table} ts
                LEFT JOIN users u ON ts.created_by = u.id
                WHERE ts.project_id = ? 
                AND (ts.name LIKE ? OR ts.description LIKE ?)
                ORDER BY ts.created_at DESC";
        
        $searchTerm = "%{$search}%";
        $stmt = $this->query($sql, [$projectId, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    public function getAllWithDetails() {
        $sql = "SELECT ts.*, 
                       u.username as created_by_name,
                       p.name as project_name,
                       COUNT(DISTINCT tsc.test_case_id) as test_case_count,
                       COUNT(DISTINCT te.id) as execution_count,
                       COUNT(DISTINCT CASE WHEN te.status = 'pass' THEN te.id END) as passed_count,
                       COUNT(DISTINCT CASE WHEN te.status = 'fail' THEN te.id END) as failed_count
                FROM {$this->table} ts
                LEFT JOIN users u ON ts.created_by = u.id
                LEFT JOIN projects p ON ts.project_id = p.id
                LEFT JOIN test_suite_cases tsc ON ts.id = tsc.test_suite_id
                LEFT JOIN test_executions te ON tsc.test_case_id = te.test_case_id
                GROUP BY ts.id
                ORDER BY ts.created_at DESC";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Fetch test suites with details filtered by a list of project IDs
     */
    public function getAllWithDetailsByProjectIds($projectIds) {
        if (empty($projectIds)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($projectIds), '?'));
        $sql = "SELECT ts.*, 
                       u.username as created_by_name,
                       p.name as project_name,
                       COUNT(DISTINCT tsc.test_case_id) as test_case_count,
                       COUNT(DISTINCT te.id) as execution_count,
                       COUNT(DISTINCT CASE WHEN te.status = 'pass' THEN te.id END) as passed_count,
                       COUNT(DISTINCT CASE WHEN te.status = 'fail' THEN te.id END) as failed_count
                FROM {$this->table} ts
                LEFT JOIN users u ON ts.created_by = u.id
                LEFT JOIN projects p ON ts.project_id = p.id
                LEFT JOIN test_suite_cases tsc ON ts.id = tsc.test_suite_id
                LEFT JOIN test_executions te ON tsc.test_case_id = te.test_case_id
                WHERE ts.project_id IN ({$placeholders})
                GROUP BY ts.id
                ORDER BY ts.created_at DESC";
        $stmt = $this->query($sql, $projectIds);
        return $stmt->fetchAll();
    }
    
    public function deleteByProject($projectId) {
        $sql = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$projectId]);
    }
}
?>