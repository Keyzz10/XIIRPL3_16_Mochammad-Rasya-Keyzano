<?php

class DashboardController extends BaseController {
    private $activityModel;
    
    public function __construct() {
        parent::__construct();
        
        $this->activityModel = new ActivityLog($this->db);
    }
    
    public function index() {
        $currentUser = $this->getCurrentUser();
        $userId = $currentUser['id'];
        $role = $currentUser['role'];
        
        // Get dashboard statistics based on user role
        $stats = $this->getDashboardStats($userId, $role);
        
        // Get recent activities
        $recentActivities = $this->activityModel->getRecentActivity(10);
        
        // Get user's tasks
        $userTasks = $this->taskModel->getUserTasks($userId, 5);
        
        // Get user's bugs (if applicable)
        $userBugs = [];
        if (in_array($role, ['developer', 'qa_tester', 'admin'])) {
            $userBugs = $this->bugModel->getUserBugs($userId, 5);
        }
        
        // Get latest 3 projects user is involved in
        $userProjects = $this->projectModel->getUserProjects($userId, 3);
        
        $data = [
            'stats' => $stats,
            'recent_activities' => $recentActivities,
            'user_tasks' => $userTasks,
            'user_bugs' => $userBugs,
            'user_projects' => $userProjects,
            'current_user' => $currentUser
        ];
        
        $this->view('dashboard/index', $data);
    }
    
    public function activities() {
        $currentUser = $this->getCurrentUser();
        
        // Get all activities with pagination
        $page = $_GET['page'] ?? 1;
        $limit = 50;
        $offset = ($page - 1) * $limit;
        
        // For super_admin and admin, show all activities
        // For other roles, show only their activities
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            $activities = $this->activityModel->getRecentActivity($limit);
            $totalActivities = $this->activityModel->getTotalActivities();
        } else {
            $activities = $this->activityModel->getUserActivity($currentUser['id'], $limit);
            $totalActivities = $this->activityModel->getTotalUserActivities($currentUser['id']);
        }
        
        $totalPages = ceil($totalActivities / $limit);
        
        $this->view('dashboard/activities', [
            'activities' => $activities,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalActivities' => $totalActivities,
            'currentUser' => $currentUser
        ]);
    }
    
    private function getDashboardStats($userId, $role) {
        $stats = [];
        
        switch ($role) {
            case 'admin':
                $stats = [
                    'total_projects' => $this->projectModel->count(),
                    'active_projects' => $this->projectModel->count(['status' => 'in_progress']),
                    'total_users' => $this->userModel->count(),
                    'total_tasks' => $this->taskModel->count(),
                    'pending_tasks' => $this->taskModel->count(['status' => 'to_do']),
                    'total_bugs' => $this->bugModel->count(),
                    'open_bugs' => $this->bugModel->count(['status' => 'new']),
                    'critical_bugs' => $this->bugModel->count(['severity' => 'critical'])
                ];
                break;
                
            case 'project_manager':
                $stats = [
                    'my_projects' => $this->projectModel->getProjectsByManager($userId),
                    'team_tasks' => $this->taskModel->getTasksForProjectManager($userId),
                    'team_bugs' => $this->bugModel->getBugsForProjectManager($userId),
                    'overdue_tasks' => $this->taskModel->getOverdueTasksForManager($userId)
                ];
                break;
                
            case 'developer':
                $stats = [
                    'my_tasks' => $this->taskModel->count(['assigned_to' => $userId]),
                    'pending_tasks' => $this->taskModel->count(['assigned_to' => $userId, 'status' => 'to_do']),
                    'in_progress_tasks' => $this->taskModel->count(['assigned_to' => $userId, 'status' => 'in_progress']),
                    'my_bugs' => $this->bugModel->count(['assigned_to' => $userId]),
                    'open_bugs' => $this->bugModel->count(['assigned_to' => $userId, 'status' => 'assigned'])
                ];
                break;
                
            case 'qa_tester':
                $stats = [
                    'my_tasks' => $this->taskModel->count(['assigned_to' => $userId]),
                    'bugs_reported' => $this->bugModel->count(['reported_by' => $userId]),
                    'bugs_to_test' => $this->bugModel->count(['status' => 'resolved']),
                    'test_cases' => $this->getTestCaseStats($userId)
                ];
                break;
                
            case 'client':
                $clientProjects = $this->projectModel->getClientProjects($userId);
                $stats = [
                    'my_projects' => count($clientProjects),
                    'project_progress' => $this->getClientProjectProgress($clientProjects),
                    'recent_updates' => $this->getClientRecentUpdates($clientProjects)
                ];
                break;
        }
        
        return $stats;
    }
    
    private function getTestCaseStats($userId) {
        // Get test case count for QA tester
        return $this->testCaseModel->count();
    }
    
    private function getClientProjectProgress($projects) {
        $totalProgress = 0;
        foreach ($projects as $project) {
            $totalProgress += $project['progress'];
        }
        return count($projects) > 0 ? $totalProgress / count($projects) : 0;
    }
    
    private function getClientRecentUpdates($projects) {
        // Get recent activities for client projects
        return [];
    }
    
    public function profile() {
        $currentUser = $this->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? ''
            ];
            
            // Handle password change
            if (!empty($_POST['password'])) {
                if ($_POST['password'] !== $_POST['confirm_password']) {
                    $errors['password'] = 'Password confirmation does not match';
                } else {
                    $data['password'] = $_POST['password'];
                }
            }
            
            // Handle profile photo upload
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $photoPath = $this->uploadFile($_FILES['profile_photo'], 'profiles');
                if ($photoPath) {
                    $data['profile_photo'] = $photoPath;
                }
            }
            
            if (!isset($errors)) {
                $result = $this->userModel->updateProfile($currentUser['id'], $data);
                
                if (isset($result['success'])) {
                    // Update session data
                    $_SESSION['full_name'] = $data['full_name'];
                    $_SESSION['email'] = $data['email'];
                    
                    $this->logActivity('update_profile', 'user', $currentUser['id']);
                    
                    $success = 'Profile updated successfully';
                } else {
                    $errors['update'] = $result['error'];
                }
            }
        }
        
        $this->view('dashboard/profile', [
            'user' => $currentUser,
            'success' => $success ?? null,
            'errors' => $errors ?? []
        ]);
    }
}
?>