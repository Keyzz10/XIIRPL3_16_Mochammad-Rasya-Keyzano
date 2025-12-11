<?php
/**
 * QA Controller
 */

class QAController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->requireRole(['super_admin', 'admin', 'qa_tester', 'project_manager', 'developer']);
    }
    
    public function index() {
        $currentUser = $this->getCurrentUser();
        $role = $currentUser['role'] ?? '';

        if (in_array($role, ['super_admin', 'admin', 'qa_tester'])) {
            $testCases = $this->testCaseModel->getAllWithDetails();
            $testSuites = $this->testSuiteModel->getAllWithDetails();
            $stats = $this->testCaseModel->getExecutionStatsAll();
            $doneTasks = $this->taskModel->getTasksByStatus('done');
        } else {
            // Project Manager or Developer: show only their projects
            $projects = $this->projectModel->getUserProjects($currentUser['id']);
            $projectIds = array_map(function($p){ return $p['id']; }, $projects);
            $testCases = $this->testCaseModel->getAllWithDetailsByProjectIds($projectIds);
            $testSuites = $this->testSuiteModel->getAllWithDetailsByProjectIds($projectIds);
            $stats = $this->testCaseModel->getExecutionStatsByProjectIds($projectIds);
            $doneTasks = $this->taskModel->getDoneTasksByProjectIds($projectIds);
        }
        
        $this->view('qa/index', [
            'testCases' => $testCases,
            'testSuites' => $testSuites,
            'stats' => $stats,
            'doneTasks' => $doneTasks ?? [],
            'pageTitle' => 'Quality Assurance'
        ]);
    }
    
    public function testCases() {
        $testCases = $this->testCaseModel->getAllWithDetails();
        
        $this->view('qa/test_cases', [
            'testCases' => $testCases,
            'pageTitle' => 'Test Cases'
        ]);
    }
    
    public function testSuites() {
        $testSuites = $this->testSuiteModel->getAllWithDetails();
        
        $this->view('qa/test_suites', [
            'testSuites' => $testSuites,
            'pageTitle' => 'Test Suites'
        ]);
    }

    public function viewTestSuite($testSuiteId) {
        $suite = $this->testSuiteModel->getTestSuiteDetails($testSuiteId);
        if (!$suite) { $this->redirect('/qa/test-suites'); }
        $testCases = $this->testSuiteModel->getTestSuiteTestCases($testSuiteId);
        $stats = $this->testSuiteModel->getTestSuiteStats($testSuiteId);
        $this->view('qa/view_test_suite', [
            'suite' => $suite,
            'testCases' => $testCases,
            'stats' => $stats,
            'pageTitle' => 'Detail Test Suite'
        ]);
    }

    public function completedTests() {
        $this->requireRole(['super_admin', 'admin', 'qa_tester', 'project_manager', 'developer']);
        $executions = $this->testCaseModel->getRecentExecutions(100);
        $this->view('qa/completed_tests', [
            'executions' => $executions,
            'pageTitle' => 'Hasil Test Selesai'
        ]);
    }

    public function deleteTestCase($testCaseId) {
        $this->requireRole(['super_admin', 'admin']);
        $testCase = $this->testCaseModel->findById($testCaseId);
        if (!$testCase) { $this->redirect('/qa/test-cases'); }
        // Remove executions first to keep referential integrity
        $this->db->prepare('DELETE FROM test_executions WHERE test_case_id = ?')->execute([$testCaseId]);
        $deleted = $this->testCaseModel->delete($testCaseId);
        if ($deleted) {
            $this->logActivity('delete_test_case', 'test_case', $testCaseId);
            $_SESSION['success_message'] = 'Test case berhasil dihapus.';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus test case.';
        }
        $this->redirect('/qa/test-cases');
    }

    public function deleteTestSuite($testSuiteId) {
        $this->requireRole(['super_admin', 'admin']);
        $suite = $this->testSuiteModel->findById($testSuiteId);
        if (!$suite) { $this->redirect('/qa/test-suites'); }
        $deleted = $this->testSuiteModel->deleteTestSuite($testSuiteId);
        if ($deleted) {
            $this->logActivity('delete_test_suite', 'test_suite', $testSuiteId);
            $_SESSION['success_message'] = 'Test suite berhasil dihapus.';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus test suite.';
        }
        $this->redirect('/qa/test-suites');
    }

    public function viewTestCase($testCaseId) {
        $testCase = $this->testCaseModel->getTestCaseDetails($testCaseId);
        if (!$testCase) { $this->redirect('/qa'); }
        $executions = $this->testCaseModel->getExecutions($testCaseId);
        $this->view('qa/view_test_case', [
            'testCase' => $testCase,
            'executions' => $executions,
            'pageTitle' => 'Test Case Detail'
        ]);
    }

    public function runTest($testCaseId) {
        $this->requireRole(['super_admin','admin','qa_tester']);
        $testCase = $this->testCaseModel->getTestCaseDetails($testCaseId);
        if (!$testCase) { $this->redirect('/qa'); }
        $currentUser = $this->getCurrentUser();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            $notes = trim($_POST['notes'] ?? '');
            if (in_array($status, ['pass','fail','blocked'], true)) {
                $this->testCaseModel->addExecution($testCaseId, $currentUser['id'], $status, $notes ?: null);
                $this->logActivity('run_test_case', 'test_case', $testCaseId, null, ['status' => $status]);
                if ($status === 'fail' && !empty($_POST['report_bug'])) {
                    // redirect to bug report with context
                    $bugParams = http_build_query([
                        'project_id' => $testCase['project_id'] ?? null,
                        'task_id' => $_POST['task_id'] ?? null,
                        'title' => 'Failed Test - ' . ($testCase['title'] ?? 'Untitled'),
                        'expected_result' => $testCase['expected_result'] ?? '',
                        'description' => $notes ?: 'Describe the failure here',
                    ]);
                    $this->redirect('/bugs/create&' . $bugParams);
                }
                $this->redirect('/qa');
            }
        }

        // tasks for selected project to optionally link
        $tasks = [];
        if (!empty($testCase['project_id'])) {
            $tasks = $this->taskModel->getProjectTasks($testCase['project_id']);
        }
        $this->view('qa/run_test', [
            'testCase' => $testCase,
            'tasks' => $tasks,
            'pageTitle' => 'Run Test'
        ]);
    }
    
    public function createTestCase() {
        // Only QA Tester and Project Manager can create test cases
        $this->requireRole(['super_admin', 'admin', 'qa_tester', 'project_manager']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Normalize type to match DB enum, and preserve custom/user text
            $allowedTypes = ['functional','ui','performance','security','usability','compatibility'];
            $rawType = trim($_POST['type'] ?? '');
            $customType = '';
            if ($rawType === 'other' && !empty(trim($_POST['type_other'] ?? ''))) {
                $customType = trim($_POST['type_other']);
            } else if (!in_array($rawType, $allowedTypes, true)) {
                // preserve non-enum choices like integration/system/acceptance/regression
                $customType = $rawType;
            }
            $dbType = in_array($rawType, $allowedTypes, true) ? $rawType : 'functional';
            $data = [
                'project_id' => $_POST['project_id'],
                'title' => $_POST['title'],
                // Append custom/non-enum type to description so info isn't lost
                'description' => $_POST['description'] . ($customType ? "\n\n[Jenis Test Kustom: " . $customType . "]" : ''),
                'preconditions' => $_POST['preconditions'],
                'test_steps' => $_POST['test_steps'],
                'expected_result' => $_POST['expected_result'],
                'priority' => $_POST['priority'],
                'type' => $dbType,
                'created_by' => $this->getCurrentUser()['id']
            ];
            
            $errors = $this->validate($_POST, [
                'project_id' => 'required',
                'title' => 'required|max:200',
                'description' => 'required',
                'test_steps' => 'required',
                'expected_result' => 'required',
                'priority' => 'required',
                'type' => 'required'
            ]);
            
            if (empty($errors)) {
                $testCaseId = $this->testCaseModel->create($data);
                
                if ($testCaseId) {
                    $this->logActivity('create_test_case', 'test_case', $testCaseId);
                    $this->redirect('/qa/test-cases');
                } else {
                    $errors['general'] = 'Failed to create test case';
                }
            }
        }
        
        // Get projects for dropdown
        $projects = $this->projectModel->findAll();
        
        $this->view('qa/create_test_case', [
            'projects' => $projects,
            'errors' => $errors ?? [],
            'pageTitle' => 'Create Test Case'
        ]);
    }
    
    public function editTestCase($testCaseId) {
        // Only super_admin and admin can edit test cases
        $this->requireRole(['super_admin', 'admin']);
        
        $testCase = $this->testCaseModel->findById($testCaseId);
        if (!$testCase) {
            $this->redirect('/qa/test-cases');
        }
        
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Normalize type to match DB enum; preserve any custom/non-enum choice in description
            $allowedTypes = ['functional','ui','performance','security','usability','compatibility'];
            $rawType = trim($_POST['type'] ?? '');
            $customType = '';
            
            if ($rawType === 'other' && !empty(trim($_POST['type_other'] ?? ''))) {
                $customType = trim($_POST['type_other']);
            } else if (!in_array($rawType, $allowedTypes, true) && !empty($rawType)) {
                // Values like integration/system/acceptance/regression are preserved as custom
                $customType = $rawType;
            }
            
            $dbType = in_array($rawType, $allowedTypes, true) ? $rawType : 'functional';

            // Clean description from any legacy custom type markers, then append if needed
            $cleanDescription = $_POST['description'] ?? '';
            $cleanDescription = preg_replace('/\n\n\[Jenis Test Kustom:.*?\]/u', '', $cleanDescription);
            $cleanDescription = trim($cleanDescription);
            if (!empty($customType)) {
                $cleanDescription .= "\n\n[Jenis Test Kustom: " . $customType . "]";
            }

            $data = [
                'project_id' => $_POST['project_id'] ?? null,
                'title' => $_POST['title'] ?? '',
                'description' => $cleanDescription,
                'preconditions' => $_POST['preconditions'] ?? null,
                'test_steps' => $_POST['test_steps'] ?? null,
                'expected_result' => $_POST['expected_result'] ?? null,
                'priority' => $_POST['priority'] ?? 'medium',
                'type' => $dbType
            ];
            
            $errors = $this->validate($_POST, [
                'project_id' => 'required',
                'title' => 'required|max:200',
                'description' => 'required',
                'test_steps' => 'required',
                'expected_result' => 'required',
                'priority' => 'required',
                'type' => 'required'
            ]);
            
            if (empty($errors)) {
                $updated = $this->testCaseModel->update($testCaseId, $data);
                
                if ($updated) {
                    $this->logActivity('update_test_case', 'test_case', $testCaseId);
                    $_SESSION['success_message'] = 'Test case berhasil diperbarui.';
                    $this->redirect('/qa/test-cases');
                } else {
                    $errors['general'] = 'Gagal memperbarui test case';
                }
            }
        }
        
        // Get projects for dropdown
        $projects = $this->projectModel->findAll();
        
        $this->view('qa/edit_test_case', [
            'testCase' => $testCase,
            'projects' => $projects,
            'errors' => $errors ?? [],
            'pageTitle' => 'Edit Test Case'
        ]);
    }
    
    public function editTestSuite($testSuiteId) {
        // Only super_admin and admin can edit test suites
        $this->requireRole(['super_admin', 'admin']);
        
        $testSuite = $this->testSuiteModel->getTestSuiteDetails($testSuiteId);
        if (!$testSuite) {
            $this->redirect('/qa/test-suites');
        }
        
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'project_id' => $_POST['project_id'] ?? null
            ];
            
            $errors = $this->validate($data, [
                'name' => 'required|min:3|max:255',
                'description' => 'required|min:10',
                'project_id' => 'required'
            ]);
            
            if (empty($errors)) {
                $updated = $this->testSuiteModel->update($testSuiteId, $data);
                if (!$updated) {
                    $errors['general'] = 'Gagal memperbarui test suite';
                } else {
                    // Manage test cases inside suite
                    if (!empty($_POST['remove_cases']) && is_array($_POST['remove_cases'])) {
                        foreach ($_POST['remove_cases'] as $caseId) {
                            $this->testSuiteModel->removeTestCaseFromSuite($testSuiteId, (int)$caseId);
                        }
                    }
                    if (!empty($_POST['new_test_cases']) && is_array($_POST['new_test_cases'])) {
                        foreach ($_POST['new_test_cases'] as $caseId) {
                            $this->testSuiteModel->addTestCaseToSuite($testSuiteId, (int)$caseId);
                        }
                    }
                    $this->logActivity('update_test_suite', 'test_suite', $testSuiteId);
                    $_SESSION['success_message'] = 'Test suite berhasil diperbarui.';
                    $this->redirect('/qa/test-suites');
                }
            }
        }
        
        // Get projects for dropdown
        $projects = $this->projectModel->findAll();
        $currentCases = $this->testSuiteModel->getTestSuiteTestCases($testSuiteId);
        $currentCaseIds = array_map(function($tc){ return (int)$tc['id']; }, $currentCases);
        // Limit candidate test cases to same project for relevance
        $allProjectCases = [];
        if (!empty($testSuite['project_id'])) {
            $stmt = $this->db->prepare("SELECT * FROM test_cases WHERE project_id = ? ORDER BY created_at DESC");
            $stmt->execute([$testSuite['project_id']]);
            $allProjectCases = $stmt->fetchAll();
        }
        
        $this->view('qa/edit_test_suite', [
            'testSuite' => $testSuite,
            'projects' => $projects,
            'currentCases' => $currentCases,
            'availableCases' => array_values(array_filter($allProjectCases, function($tc) use ($currentCaseIds){ return !in_array((int)$tc['id'], $currentCaseIds, true); })),
            'errors' => $errors ?? [],
            'pageTitle' => 'Edit Test Suite'
        ]);
    }

    public function createTestSuite() {
        // Only QA Tester and Project Manager can create test suites
        $this->requireRole(['super_admin', 'admin', 'qa_tester', 'project_manager']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'project_id' => $_POST['project_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'type' => $_POST['type'],
                'priority' => $_POST['priority'],
                'schedule' => $_POST['schedule'] ?? 'manual',
                'created_by' => $this->getCurrentUser()['id']
            ];
            
            $errors = $this->validate($_POST, [
                'project_id' => 'required',
                'name' => 'required|max:200',
                'description' => 'required',
                'type' => 'required',
                'priority' => 'required'
            ]);
            
            if (empty($errors)) {
                $testSuiteId = $this->testSuiteModel->create($data);
                
                if ($testSuiteId) {
                    // Add selected test cases to the suite
                    if (!empty($_POST['test_cases'])) {
                        foreach ($_POST['test_cases'] as $testCaseId) {
                            $this->testSuiteModel->addTestCaseToSuite($testSuiteId, $testCaseId);
                        }
                    }
                    
                    $this->logActivity('create_test_suite', 'test_suite', $testSuiteId);
                    $this->redirect('/qa/test-suites');
                } else {
                    $errors['general'] = 'Failed to create test suite';
                }
            }
        }
        
        // Get projects and test cases for dropdowns
        $projects = $this->projectModel->findAll();
        $testCases = $this->testCaseModel->findAll();
        
        $this->view('qa/create_test_suite', [
            'projects' => $projects,
            'testCases' => $testCases,
            'errors' => $errors ?? [],
            'pageTitle' => 'Create Test Suite'
        ]);
    }

    public function runSuite($testSuiteId) {
        $this->requireRole(['super_admin','admin','qa_tester','project_manager']);
        $suite = $this->testSuiteModel->getTestSuiteDetails($testSuiteId);
        if (!$suite) { $this->redirect('/qa/test-suites'); }
        $testCases = $this->testSuiteModel->getTestSuiteTestCases($testSuiteId);
        $currentUser = $this->getCurrentUser();

        $summary = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status']) && is_array($_POST['status'])) {
            $passed = 0; $failed = 0; $blocked = 0; $total = 0;
            foreach ($_POST['status'] as $testCaseId => $status) {
                $status = trim($status);
                if (!in_array($status, ['pass','fail','blocked'], true)) { continue; }
                $total++;
                if ($status === 'pass') $passed++;
                if ($status === 'fail') $failed++;
                if ($status === 'blocked') $blocked++;
                $this->testCaseModel->addExecution((int)$testCaseId, $currentUser['id'], $status, $_POST['notes'][$testCaseId] ?? null);
            }
            $summary = [
                'total' => $total,
                'passed' => $passed,
                'failed' => $failed,
                'blocked' => $blocked
            ];
            $this->logActivity('run_test_suite', 'test_suite', $testSuiteId, null, $summary);
            $_SESSION['success_message'] = "Suite dijalankan: {$passed} passed, {$failed} failed, {$blocked} blocked";
            $this->redirect('/qa/test-suites');
        }

        $this->view('qa/run_suite', [
            'suite' => $suite,
            'testCases' => $testCases,
            'pageTitle' => 'Jalankan Test Suite'
        ]);
    }
}
?>