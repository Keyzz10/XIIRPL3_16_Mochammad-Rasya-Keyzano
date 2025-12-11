<?php
class ReportController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        // Allow all authenticated users to access reports with role-based data filtering
    }
    
    public function index() {
        $currentUser = $this->getCurrentUser();
        $userRole = $currentUser['role'];
        
        // Get role-based statistics
        $data = $this->getRoleBasedData($userRole, $currentUser['id']);
        
        $this->view('reports/index', [
            'projectStats' => $data['projectStats'],
            'taskStats' => $data['taskStats'],
            'bugStats' => $data['bugStats'],
            'userStats' => $data['userStats'],
            'userRole' => $userRole,
            'pageTitle' => 'Reports & Analytics'
        ]);
    }
    
    public function print() {
        $currentUser = $this->getCurrentUser();
        $userRole = $currentUser['role'];

        $data = $this->getRoleBasedData($userRole, $currentUser['id']);

        $this->view('reports/print', [
            'projectStats' => $data['projectStats'],
            'taskStats' => $data['taskStats'],
            'bugStats' => $data['bugStats'],
            'userStats' => $data['userStats'],
            'userRole' => $userRole,
            'pageTitle' => 'Reports & Analytics - Print'
        ]);
    }
    
    public function projects() {
        $currentUser = $this->getCurrentUser();
        $userRole = $currentUser['role'];
        
        // Get role-based project data
        $projects = $this->getRoleBasedProjects($userRole, $currentUser['id']);
        
        $this->view('reports/projects', [
            'projects' => $projects,
            'userRole' => $userRole,
            'pageTitle' => 'Project Reports'
        ]);
    }
    
    public function tasks() {
        $currentUser = $this->getCurrentUser();
        $userRole = $currentUser['role'];
        
        // Get role-based task data
        $taskData = $this->getRoleBasedTasks($userRole, $currentUser['id']);
        
        $this->view('reports/tasks', [
            'tasks' => $taskData['tasks'],
            'overdueTasks' => $taskData['overdueTasks'],
            'userRole' => $userRole,
            'pageTitle' => 'Task Reports'
        ]);
    }
    
    public function bugs() {
        $currentUser = $this->getCurrentUser();
        $userRole = $currentUser['role'];
        
        // Get role-based bug data
        $bugData = $this->getRoleBasedBugs($userRole, $currentUser['id']);
        
        $this->view('reports/bugs', [
            'bugs' => $bugData['bugs'],
            'criticalBugs' => $bugData['criticalBugs'],
            'userRole' => $userRole,
            'pageTitle' => 'Bug Reports'
        ]);
    }
    
    public function qa() {
        $currentUser = $this->getCurrentUser();
        $userRole = $currentUser['role'];
        
        // Build role-based QA data (test cases and test suites)
        $qaData = $this->getRoleBasedQA($userRole, $currentUser['id']);
        
        $this->view('reports/qa', [
            'testCases' => $qaData['testCases'],
            'testSuites' => $qaData['testSuites'],
            'executionStats' => $qaData['executionStats'],
            'caseStats' => $qaData['caseStats'],
            'userRole' => $userRole,
            'pageTitle' => 'QA Reports'
        ]);
    }
    
    public function export($type = 'projects') {
        $currentUser = $this->getCurrentUser();
        $userRole = $currentUser['role'];
        $userId = $currentUser['id'];

        $format = isset($_GET['format']) && in_array(strtolower($_GET['format']), ['csv','excel'])
            ? strtolower($_GET['format'])
            : 'csv';

        switch ($type) {
            case 'projects':
                $projects = $this->getRoleBasedProjects($userRole, $userId);
                $data = array_map(function($row) {
                    return [
                        $row['id'] ?? '',
                        $row['name'] ?? '',
                        $row['client_name'] ?? ($row['client'] ?? ''),
                        $row['manager_name'] ?? ($row['manager'] ?? ''),
                        $row['status'] ?? '',
                        $row['progress'] ?? 0,
                        $row['start_date'] ?? '',
                        $row['end_date'] ?? ''
                    ];
                }, $projects);
                $filename = 'projects_report_' . date('Y-m-d') . '.csv';
                $headers = ['ID', 'Name', 'Client', 'Manager', 'Status', 'Progress', 'Start Date', 'End Date'];
                break;
                
            case 'tasks':
                $taskData = $this->getRoleBasedTasks($userRole, $userId);
                $tasks = $taskData['tasks'];
                $data = array_map(function($row) {
                    return [
                        $row['id'] ?? '',
                        $row['title'] ?? '',
                        $row['project_name'] ?? '',
                        $row['assigned_to_name'] ?? '',
                        $row['status'] ?? '',
                        $row['priority'] ?? '',
                        $row['progress'] ?? 0,
                        $row['due_date'] ?? ''
                    ];
                }, $tasks);
                $filename = 'tasks_report_' . date('Y-m-d') . '.csv';
                $headers = ['ID', 'Title', 'Project', 'Assigned To', 'Status', 'Priority', 'Progress', 'Due Date'];
                break;
                
            case 'bugs':
                $bugData = $this->getRoleBasedBugs($userRole, $userId);
                $bugs = $bugData['bugs'];
                $data = array_map(function($row) {
                    return [
                        $row['id'] ?? '',
                        $row['title'] ?? '',
                        $row['project_name'] ?? '',
                        $row['severity'] ?? '',
                        $row['priority'] ?? '',
                        $row['status'] ?? '',
                        $row['reported_by_name'] ?? '',
                        $row['created_at'] ?? ''
                    ];
                }, $bugs);
                $filename = 'bugs_report_' . date('Y-m-d') . '.csv';
                $headers = ['ID', 'Title', 'Project', 'Severity', 'Priority', 'Status', 'Reported By', 'Created Date'];
                break;
            
            case 'test_cases':
                $qaData = $this->getRoleBasedQA($userRole, $userId);
                $cases = $qaData['testCases'];
                $filename = 'test_cases_report_' . date('Y-m-d') . '.csv';
                $headers = ['ID', 'Title', 'Project', 'Priority', 'Type', 'Executions', 'Passed', 'Failed', 'Last Result'];
                // Normalize rows to match headers order
                $data = array_map(function($row){
                    return [
                        $row['id'] ?? '',
                        $row['title'] ?? '',
                        $row['project_name'] ?? '',
                        $row['priority'] ?? '',
                        $row['type'] ?? '',
                        $row['execution_count'] ?? 0,
                        $row['passed_count'] ?? 0,
                        $row['failed_count'] ?? 0,
                        $row['last_result'] ?? ($row['execution_status'] ?? '')
                    ];
                }, $cases);
                break;
            
            case 'test_suites':
                $qaData = $this->getRoleBasedQA($userRole, $userId);
                $suites = $qaData['testSuites'];
                $filename = 'test_suites_report_' . date('Y-m-d') . '.csv';
                $headers = ['ID', 'Name', 'Project', 'Type', 'Priority', 'Test Cases', 'Executions', 'Passed', 'Failed'];
                $data = array_map(function($row){
                    return [
                        $row['id'] ?? '',
                        $row['name'] ?? '',
                        $row['project_name'] ?? '',
                        $row['type'] ?? '',
                        $row['priority'] ?? '',
                        $row['test_case_count'] ?? 0,
                        $row['execution_count'] ?? 0,
                        $row['passed_count'] ?? 0,
                        $row['failed_count'] ?? 0,
                    ];
                }, $suites);
                break;
            
            case 'qa_all':
                // Export both in a single file (Excel HTML or combined CSV)
                $qaData = $this->getRoleBasedQA($userRole, $userId);
                $cases = $qaData['testCases'];
                $suites = $qaData['testSuites'];

                if ($format === 'excel') {
                    $excelFilename = 'qa_reports_' . date('Y-m-d') . '.xls';
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename=' . $excelFilename);
                    echo "<html><head><meta charset='UTF-8'></head><body>";
                    echo "<h2 style='font-family:Arial'>Test Cases</h2>";
                    echo "<table border='1' cellspacing='0' cellpadding='4'>";
                    echo '<tr><th>ID</th><th>Title</th><th>Project</th><th>Priority</th><th>Type</th><th>Executions</th><th>Passed</th><th>Failed</th><th>Last Result</th></tr>';
                    foreach ($cases as $row) {
                        echo '<tr>'
                            . '<td>' . htmlspecialchars((string)($row['id'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['title'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['project_name'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['priority'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['type'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['execution_count'] ?? 0)) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['passed_count'] ?? 0)) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['failed_count'] ?? 0)) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['last_result'] ?? ($row['execution_status'] ?? ''))) . '</td>'
                            . '</tr>';
                    }
                    echo '</table>';

                    echo "<br/><h2 style='font-family:Arial'>Test Suites</h2>";
                    echo "<table border='1' cellspacing='0' cellpadding='4'>";
                    echo '<tr><th>ID</th><th>Name</th><th>Project</th><th>Type</th><th>Priority</th><th>Test Cases</th><th>Executions</th><th>Passed</th><th>Failed</th></tr>';
                    foreach ($suites as $row) {
                        echo '<tr>'
                            . '<td>' . htmlspecialchars((string)($row['id'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['name'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['project_name'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['type'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['priority'] ?? '')) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['test_case_count'] ?? 0)) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['execution_count'] ?? 0)) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['passed_count'] ?? 0)) . '</td>'
                            . '<td>' . htmlspecialchars((string)($row['failed_count'] ?? 0)) . '</td>'
                            . '</tr>';
                    }
                    echo '</table>';
                    echo '</body></html>';
                    exit;
                }

                // Default combined CSV in one file
                header('Content-Type: text/csv');
                $csvName = 'qa_reports_' . date('Y-m-d') . '.csv';
                header('Content-Disposition: attachment; filename="' . $csvName . '"');
                $output = fopen('php://output', 'w');
                // Section: Test Cases
                fputcsv($output, ['Test Cases']);
                fputcsv($output, ['ID','Title','Project','Priority','Type','Executions','Passed','Failed','Last Result']);
                foreach ($cases as $row) {
                    fputcsv($output, [
                        $row['id'] ?? '',
                        $row['title'] ?? '',
                        $row['project_name'] ?? '',
                        $row['priority'] ?? '',
                        $row['type'] ?? '',
                        $row['execution_count'] ?? 0,
                        $row['passed_count'] ?? 0,
                        $row['failed_count'] ?? 0,
                        $row['last_result'] ?? ($row['execution_status'] ?? '')
                    ]);
                }
                fputcsv($output, []); // blank line
                // Section: Test Suites
                fputcsv($output, ['Test Suites']);
                fputcsv($output, ['ID','Name','Project','Type','Priority','Test Cases','Executions','Passed','Failed']);
                foreach ($suites as $row) {
                    fputcsv($output, [
                        $row['id'] ?? '',
                        $row['name'] ?? '',
                        $row['project_name'] ?? '',
                        $row['type'] ?? '',
                        $row['priority'] ?? '',
                        $row['test_case_count'] ?? 0,
                        $row['execution_count'] ?? 0,
                        $row['passed_count'] ?? 0,
                        $row['failed_count'] ?? 0,
                    ]);
                }
                fclose($output);
                exit;
                
                // no break
                
            default:
                $this->redirect('/reports');
                return;
        }
        
        if ($format === 'excel') {
            // Simple Excel-compatible HTML table export (opens in Excel)
            $excelFilename = preg_replace('/\.csv$/', '.xls', $filename);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=' . $excelFilename);
            echo "<table border='1'>";
            echo '<tr>';
            foreach ($headers as $h) { echo '<th>' . htmlspecialchars($h) . '</th>'; }
            echo '</tr>';
            foreach ($data as $row) {
                echo '<tr>';
                foreach (array_values($row) as $cell) {
                    echo '<td>' . htmlspecialchars((string)$cell) . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        } else {
            // CSV export
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $output = fopen('php://output', 'w');
            fputcsv($output, $headers);
            foreach ($data as $row) { fputcsv($output, array_values($row)); }
            fclose($output);
        }
    }
    
    /**
     * Get role-based data for reports
     */
    private function getRoleBasedData($userRole, $userId) {
        $data = [
            'projectStats' => 0,
            'taskStats' => ['total_tasks' => 0, 'todo_tasks' => 0, 'progress_tasks' => 0, 'done_tasks' => 0],
            'bugStats' => ['new_bugs' => 0, 'assigned_bugs' => 0, 'critical_bugs' => 0, 'major_bugs' => 0, 'minor_bugs' => 0, 'low_bugs' => 0],
            'userStats' => ['active_users' => 0]
        ];
        
        switch ($userRole) {
            case 'super_admin':
            case 'admin':
                // Full access to all data
                $data['projectStats'] = $this->projectModel->count();
                $data['taskStats'] = $this->taskModel->getTaskStats();
                $data['bugStats'] = $this->bugModel->getBugStats();
                $data['userStats'] = $this->userModel->getUserStats();
                break;
                
            case 'project_manager':
                // Access to projects they manage and related data
                $data['projectStats'] = $this->projectModel->getProjectsByManagerCount($userId);
                $data['taskStats'] = $this->taskModel->getTaskStatsByManager($userId);
                $data['bugStats'] = $this->bugModel->getBugStatsByManager($userId);
                $data['userStats'] = $this->userModel->getUserStatsByManager($userId);
                break;
                
            case 'developer':
                // Access to assigned tasks and related projects
                $data['projectStats'] = $this->projectModel->getProjectsByUser($userId);
                $data['taskStats'] = $this->taskModel->getTaskStatsByUser($userId);
                $data['bugStats'] = $this->bugModel->getBugStatsByUser($userId);
                $data['userStats'] = ['active_users' => 1]; // Only themselves
                break;
                
            case 'qa_tester':
                // Access to assigned bugs and related projects
                $data['projectStats'] = $this->projectModel->getProjectsByUser($userId);
                $data['taskStats'] = $this->taskModel->getTaskStatsByUser($userId);
                $data['bugStats'] = $this->bugModel->getBugStatsByUser($userId);
                $data['userStats'] = ['active_users' => 1]; // Only themselves
                break;
                
            case 'client':
                // Access to their projects only
                $data['projectStats'] = $this->projectModel->getProjectsByClient($userId);
                $data['taskStats'] = $this->taskModel->getTaskStatsByClient($userId);
                $data['bugStats'] = $this->bugModel->getBugStatsByClient($userId);
                $data['userStats'] = ['active_users' => 1]; // Only themselves
                break;
        }
        
        return $data;
    }
    
    /**
     * Get role-based projects
     */
    private function getRoleBasedProjects($userRole, $userId) {
        switch ($userRole) {
            case 'super_admin':
            case 'admin':
                return $this->projectModel->getAllWithDetails();
                
            case 'project_manager':
                return $this->projectModel->getProjectsByManagerWithDetails($userId);
                
            case 'developer':
            case 'qa_tester':
                return $this->projectModel->getProjectsByUserWithDetails($userId);
                
            case 'client':
                return $this->projectModel->getProjectsByClientWithDetails($userId);
                
            default:
                return [];
        }
    }
    
    /**
     * Get role-based tasks
     */
    private function getRoleBasedTasks($userRole, $userId) {
        $tasks = [];
        $overdueTasks = [];
        
        switch ($userRole) {
            case 'super_admin':
            case 'admin':
                $tasks = $this->taskModel->getAllWithDetails();
                $overdueTasks = $this->taskModel->getOverdueTasks();
                break;
                
            case 'project_manager':
                $tasks = $this->taskModel->getTasksByManagerWithDetails($userId);
                $overdueTasks = $this->taskModel->getOverdueTasksByManager($userId);
                break;
                
            case 'developer':
            case 'qa_tester':
                $tasks = $this->taskModel->getTasksByUserWithDetails($userId);
                $overdueTasks = $this->taskModel->getOverdueTasksByUser($userId);
                break;
                
            case 'client':
                $tasks = $this->taskModel->getTasksByClientWithDetails($userId);
                $overdueTasks = $this->taskModel->getOverdueTasksByClient($userId);
                break;
        }
        
        return [
            'tasks' => $tasks,
            'overdueTasks' => $overdueTasks
        ];
    }
    
    /**
     * Get role-based bugs
     */
    private function getRoleBasedBugs($userRole, $userId) {
        $bugs = [];
        $criticalBugs = [];
        
        switch ($userRole) {
            case 'super_admin':
            case 'admin':
                $bugs = $this->bugModel->getAllWithDetails();
                $criticalBugs = $this->bugModel->getCriticalBugs();
                break;
                
            case 'project_manager':
                $bugs = $this->bugModel->getBugsByManagerWithDetails($userId);
                $criticalBugs = $this->bugModel->getCriticalBugsByManager($userId);
                break;
                
            case 'developer':
            case 'qa_tester':
                $bugs = $this->bugModel->getBugsByUserWithDetails($userId);
                $criticalBugs = $this->bugModel->getCriticalBugsByUser($userId);
                break;
                
            case 'client':
                $bugs = $this->bugModel->getBugsByClientWithDetails($userId);
                $criticalBugs = $this->bugModel->getCriticalBugsByClient($userId);
                break;
        }
        
        return [
            'bugs' => $bugs,
            'criticalBugs' => $criticalBugs
        ];
    }
    
    /**
     * Get role-based QA data (test cases and suites)
     */
    private function getRoleBasedQA($userRole, $userId) {
        $testCases = [];
        $testSuites = [];
        $executionStats = ['passed_tests' => 0, 'failed_tests' => 0];
        $caseStats = [
            'total_test_cases' => 0,
            'critical_cases' => 0,
            'high_cases' => 0,
            'medium_cases' => 0,
            'low_cases' => 0,
            'functional_cases' => 0,
            'ui_cases' => 0,
            'performance_cases' => 0,
            'security_cases' => 0,
            'usability_cases' => 0,
            'compatibility_cases' => 0,
        ];
        
        switch ($userRole) {
            case 'super_admin':
            case 'admin':
            case 'qa_tester':
                $testCases = $this->testCaseModel->getAllWithDetails();
                $testSuites = $this->testSuiteModel->getAllWithDetails();
                $executionStats = $this->testCaseModel->getExecutionStatsAll();
                $caseStats = $this->testCaseModel->getTestStats();
                break;
            
            case 'project_manager':
            case 'developer':
                $projects = $this->projectModel->getUserProjects($userId);
                $projectIds = array_map(function($p){ return $p['id']; }, $projects);
                $testCases = $this->testCaseModel->getAllWithDetailsByProjectIds($projectIds);
                $testSuites = $this->testSuiteModel->getAllWithDetailsByProjectIds($projectIds);
                $executionStats = $this->testCaseModel->getExecutionStatsByProjectIds($projectIds);
                // Aggregate simplified stats per available cases
                // Fallback: compute counts by priority/type from the detailed rows
                $caseStats['total_test_cases'] = count($testCases);
                foreach ($testCases as $tc) {
                    $priority = strtolower($tc['priority'] ?? '');
                    if (isset($caseStats[$priority . '_cases'])) { $caseStats[$priority . '_cases']++; }
                    $type = strtolower($tc['type'] ?? '');
                    if (isset($caseStats[$type . '_cases'])) { $caseStats[$type . '_cases']++; }
                }
                break;
            
            case 'client':
                // Clients: QA reporting not typically exposed; limit to projects they own
                $projects = $this->projectModel->getProjectsByClientWithDetails($userId);
                $projectIds = array_map(function($p){ return $p['id']; }, $projects);
                $testCases = $this->testCaseModel->getAllWithDetailsByProjectIds($projectIds);
                $testSuites = $this->testSuiteModel->getAllWithDetailsByProjectIds($projectIds);
                $executionStats = $this->testCaseModel->getExecutionStatsByProjectIds($projectIds);
                $caseStats['total_test_cases'] = count($testCases);
                foreach ($testCases as $tc) {
                    $priority = strtolower($tc['priority'] ?? '');
                    if (isset($caseStats[$priority . '_cases'])) { $caseStats[$priority . '_cases']++; }
                    $type = strtolower($tc['type'] ?? '');
                    if (isset($caseStats[$type . '_cases'])) { $caseStats[$type . '_cases']++; }
                }
                break;
        }
        
        return [
            'testCases' => $testCases,
            'testSuites' => $testSuites,
            'executionStats' => $executionStats,
            'caseStats' => $caseStats,
        ];
    }
}
?>