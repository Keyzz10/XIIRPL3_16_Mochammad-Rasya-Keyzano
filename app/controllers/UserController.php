<?php
/**
 * User Controller
 */

class UserController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        // Allow both super_admin and admin to view all users
        $this->requireRole(['super_admin', 'admin']);
        
        $currentUser = $this->getCurrentUser();
        // Hanya tampilkan user dengan status active di daftar utama
        $users = $this->userModel->getActiveUsers();
        $userStats = $this->userModel->getUserStats();
        
        // Determine permissions for current user
        $canEdit = in_array($currentUser['role'], ['super_admin', 'admin']);
        $canDelete = in_array($currentUser['role'], ['super_admin', 'admin']);
        
        $this->view('users/index', [
            'users' => $users,
            'stats' => $userStats,
            'canEdit' => $canEdit,
            'canDelete' => $canDelete,
            'currentUser' => $currentUser
        ]);
    }
    
    public function profile() {
        $currentUser = $this->getCurrentUser();
        $success = null;
        $errors = [];
        
        // Check for session success message (from language change redirect)
        if (isset($_SESSION['profile_success'])) {
            $success = $_SESSION['profile_success'];
            unset($_SESSION['profile_success']);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'language' => 'id' // Force Indonesian language
            ];
            
            // Enforce: email cannot be changed from profile page (frontend is read-only, backend enforces)
            $data['email'] = $currentUser['email'];
            // Also normalize POST for validation rules that still reference email
            $_POST['email'] = $currentUser['email'];
            
            // Handle username change if provided
            if (isset($_POST['username']) && !empty($_POST['username'])) {
                $newUsername = trim($_POST['username']);
                
                // Check if username is different from current
                if ($newUsername !== $currentUser['username']) {
                    // Check 90-day restriction
                    $lastChanged = $currentUser['username_last_changed'] ?? null;
                    if ($lastChanged) {
                        $daysSince = floor((time() - strtotime($lastChanged)) / (60 * 60 * 24));
                        if ($daysSince < 90) {
                            $daysRemaining = 90 - $daysSince;
                            $errors['username'] = sprintf(__('profile.username_cooldown'), $daysRemaining);
                        }
                    }
                    
                    // Check if username is available (if no cooldown error)
                    if (!isset($errors['username'])) {
                        $existingUser = $this->userModel->findByUsername($newUsername);
                        if ($existingUser && $existingUser['id'] != $currentUser['id']) {
                            $errors['username'] = __('profile.username_taken');
                        } else {
                            $data['username'] = $newUsername;
                            $data['username_last_changed'] = date('Y-m-d H:i:s');
                        }
                    }
                }
            }
            
            // Validate input (merge with existing username errors if any)
            $validationErrors = $this->validate($_POST, [
                'full_name' => 'required|max:100',
                'email' => 'required|email|max:100'
            ]);
            
            // Merge validation errors with username errors
            $errors = array_merge($errors ?? [], $validationErrors);
            
            // Handle password change
            if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
                if ($_POST['new_password'] !== $_POST['confirm_password']) {
                    $errors['confirm_password'] = 'Password confirmation does not match';
                } else {
                    $passwordResult = $this->userModel->changePassword(
                        $currentUser['id'],
                        $_POST['current_password'],
                        $_POST['new_password']
                    );
                    
                    if (isset($passwordResult['error'])) {
                        $errors['current_password'] = $passwordResult['error'];
                    }
                }
            }
            
            // Handle profile photo upload
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                $fileExtension = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
                
                if (in_array($fileExtension, $allowedTypes)) {
                    $photoPath = $this->uploadFile($_FILES['profile_photo'], 'profiles');
                    if ($photoPath) {
                        $data['profile_photo'] = $photoPath;
                    }
                } else {
                    $errors['profile_photo'] = 'Invalid file type. Only JPG, PNG, and GIF files are allowed.';
                }
            }
            
            if (empty($errors)) {
                $result = $this->userModel->updateProfile($currentUser['id'], $data);
                
                if (isset($result['success'])) {
                    // Check if language was changed (always false since we force Indonesian)
                    $languageChanged = false;
                    
                    // Update session data
                    $_SESSION['full_name'] = $data['full_name'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['language'] = 'id'; // Force Indonesian language
                    
                    // Update username in session if changed
                    if (isset($data['username'])) {
                        $_SESSION['username'] = $data['username'];
                    }
                    
                    // Reinitialize language system to load new language
                    Language::init();
                    
                    $this->logActivity('update_profile', 'user', $currentUser['id']);
                    
                    $success = __('profile.updated_successfully');
                    
                    // Refresh current user data to ensure profile_photo is updated
                    $currentUser = $this->userModel->findById($currentUser['id']);
                    
                    // If language was changed, redirect to refresh the page with new language
                    if ($languageChanged) {
                        // Set a session message for the redirect
                        $_SESSION['profile_success'] = $success;
                        $this->redirect('/profile');
                        return;
                    }
                    
                    // Clear any cached file input to prevent JavaScript conflicts
                    $_POST = []; // Clear POST data to prevent form resubmission issues
                } else {
                    $errors['update'] = $result['error'];
                }
            }
        }
        
        // Calculate user statistics
        $userStats = [
            'total_tasks' => 0,
            'completed_tasks' => 0,
            'bugs_reported' => 0,
            'active_projects' => 0
        ];
        
        // Get task statistics based on user role
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            // Admin sees all tasks
            $taskStats = $this->taskModel->getTaskStats();
            $userStats['total_tasks'] = $taskStats['total_tasks'] ?? 0;
            $userStats['completed_tasks'] = $taskStats['done_tasks'] ?? 0;
        } elseif ($currentUser['role'] === 'project_manager') {
            // PM sees tasks in their projects
            $taskStats = $this->taskModel->getTaskStatsForProjectManager($currentUser['id']);
            $userStats['total_tasks'] = $taskStats['total_tasks'] ?? 0;
            $userStats['completed_tasks'] = $taskStats['done_tasks'] ?? 0;
        } elseif ($currentUser['role'] === 'developer') {
            // Developer sees their assigned tasks
            $taskStats = $this->taskModel->getTaskStatsForUser($currentUser['id']);
            $userStats['total_tasks'] = $taskStats['total_tasks'] ?? 0;
            $userStats['completed_tasks'] = $taskStats['done_tasks'] ?? 0;
        } elseif ($currentUser['role'] === 'qa_tester') {
            // QA sees tasks in their projects
            $taskStats = $this->taskModel->getTaskStatsForQA($currentUser['id']);
            $userStats['total_tasks'] = $taskStats['total_tasks'] ?? 0;
            $userStats['completed_tasks'] = $taskStats['done_tasks'] ?? 0;
        }
        
        // Get bug statistics
        $bugStats = $this->bugModel->getBugStatsForUser($currentUser['id'], $currentUser['role']);
        $userStats['bugs_reported'] = $bugStats['total_bugs'] ?? 0;
        
        // Get active projects count
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            // Admin sees all active projects
            $projects = $this->projectModel->getProjectsByStatus('in_progress');
            $userStats['active_projects'] = count($projects);
        } elseif ($currentUser['role'] === 'project_manager') {
            // PM sees their active projects
            $projects = $this->projectModel->getProjectsByManager($currentUser['id']);
            $userStats['active_projects'] = count(array_filter($projects, function($p) { 
                return $p['status'] === 'in_progress'; 
            }));
        } else {
            // Other roles see projects they're assigned to
            $projects = $this->projectModel->getUserProjects($currentUser['id']);
            $userStats['active_projects'] = count(array_filter($projects, function($p) { 
                return $p['status'] === 'in_progress'; 
            }));
        }
        
        $this->view('users/profile', [
            'user' => $currentUser,
            'success' => $success,
            'errors' => $errors,
            'userStats' => $userStats
        ]);
    }
    
    public function checkUsername() {
        // AJAX endpoint to check username availability
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $username = trim($input['username'] ?? '');
        
        if (empty($username)) {
            echo json_encode(['available' => false, 'error' => 'Username is required']);
            return;
        }
        
        if (strlen($username) < 3) {
            echo json_encode(['available' => false, 'error' => 'Username must be at least 3 characters']);
            return;
        }
        
        $existingUser = $this->userModel->findByUsername($username);
        $available = !$existingUser;
        
        echo json_encode(['available' => $available]);
    }
    
    public function create() {
        // Allow both super_admin and admin to access user creation
        $this->requireRole(['super_admin', 'admin']);
        
        // Get current user for role checking
        $currentUser = $this->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check role creation permissions
            $requestedRole = $_POST['role'] ?? '';
            
            // Super admin can create any role including admin
            // Admin can create any role EXCEPT admin (only super_admin can create admin)
            if ($requestedRole === 'admin' && $currentUser['role'] !== 'super_admin') {
                $errors['role'] = 'Only Super Administrators can create Admin users';
            } else if ($requestedRole === 'super_admin') {
                // Nobody can create super_admin via this interface for security
                $errors['role'] = 'Super Admin accounts cannot be created through this interface';
            }
            
            if (!isset($errors)) {
                $errors = $this->validate($_POST, [
                    'username' => 'required|min:3|max:50',
                    'email' => 'required|email|max:100',
                    'password' => 'required|min:8',
                    'full_name' => 'required|max:100',
                    'role' => 'required'
                ]);
            }
            
            if (empty($errors)) {
                $data = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'full_name' => $_POST['full_name'],
                    'role' => $_POST['role'],
                    'phone' => $_POST['phone'] ?? null,
                    'status' => 'active'
                ];
                
                $result = $this->userModel->register($data);
                
                if (isset($result['success'])) {
                    $this->logActivity('create_user', 'user', $result['user_id']);
                    $this->redirect('/users');
                } else {
                    $errors['registration'] = $result['error'];
                }
            }
        }
        
        $this->view('users/create', [
            'errors' => $errors ?? [],
            'currentUserRole' => $currentUser['role']
        ]);
    }
    
    public function edit($userId) {
        // Allow both super_admin and admin to edit users
        $this->requireRole(['super_admin', 'admin']);
        
        $user = $this->userModel->findById($userId);
        if (!$user) {
            $this->redirect('/users');
        }
        
        // Check edit permissions
        $currentUser = $this->getCurrentUser();
        
        // Only super_admin can edit super_admin accounts
        if ($user['role'] === 'super_admin' && $currentUser['role'] !== 'super_admin') {
            $this->forbidden();
            return;
        }
        
        // Admin cannot edit other admin accounts unless they are super_admin
        if ($user['role'] === 'admin' && $currentUser['role'] === 'admin' && $user['id'] !== $currentUser['id']) {
            $this->forbidden();
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'full_name' => $_POST['full_name'],
                'role' => $_POST['role'],
                'phone' => $_POST['phone'] ?? null,
                'status' => $_POST['status']
            ];
            
            // Only update password if provided
            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }
            
            $errors = $this->validate($_POST, [
                'username' => 'required|min:3|max:50',
                'email' => 'required|email|max:100',
                'full_name' => 'required|max:100',
                'role' => 'required',
                'status' => 'required'
            ]);
            
            // Check role change permissions
            $requestedRole = $_POST['role'] ?? '';
            
            // Super admin can change anyone's role (except creating super_admin)
            // Admin can change roles but not to admin or super_admin
            if ($requestedRole === 'admin' && $currentUser['role'] !== 'super_admin') {
                $errors['role'] = 'Only Super Administrators can assign Admin role';
            } else if ($requestedRole === 'super_admin') {
                $errors['role'] = 'Super Admin role cannot be assigned through this interface';
            }
            
            if (empty($errors)) {
                $result = $this->userModel->updateProfile($userId, $data);
                
                if (isset($result['success'])) {
                    $this->logActivity('update_user', 'user', $userId);
                    $this->redirect('/users');
                } else {
                    $errors['update'] = $result['error'];
                }
            }
        }
        
        $this->view('users/edit', [
            'user' => $user,
            'errors' => $errors ?? [],
            'currentUserRole' => $currentUser['role']
        ]);
    }
    
    public function delete($userId) {
        // Allow both super_admin and admin to delete users
        $this->requireRole(['super_admin', 'admin']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->findById($userId);
            if ($user) {
                $currentUser = $this->getCurrentUser();
                
                // Cannot delete super_admin accounts
                if ($user['role'] === 'super_admin') {
                    $this->json(['error' => 'Super Admin accounts cannot be deleted'], 400);
                    return;
                }
                
                // Only super_admin can delete admin accounts
                if ($user['role'] === 'admin' && $currentUser['role'] !== 'super_admin') {
                    $this->json(['error' => 'Only Super Administrators can delete Admin users'], 400);
                    return;
                }
                
                // Don't allow deletion of the only admin (if current user is not super_admin)
                if ($user['role'] === 'admin') {
                    $adminCount = $this->userModel->count(['role' => 'admin']);
                    if ($adminCount <= 1) {
                        $this->json(['error' => 'Cannot delete the only admin user'], 400);
                        return;
                    }
                }
                
                // Soft delete by changing status
                $this->userModel->update($userId, ['status' => 'inactive']);
                $this->logActivity('delete_user', 'user', $userId);
                
                $this->json(['success' => true]);
            } else {
                $this->json(['error' => 'User not found'], 404);
            }
        }
    }
    
    public function activate($userId) {
        // Allow both super_admin and admin to activate users
        $this->requireRole(['super_admin', 'admin']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->findById($userId);
            if ($user) {
                $this->userModel->update($userId, ['status' => 'active']);
                $this->logActivity('activate_user', 'user', $userId);
                
                $this->json(['success' => true]);
            } else {
                $this->json(['error' => 'User not found'], 404);
            }
        }
    }
    
    public function deactivate($userId) {
        // Allow both super_admin and admin to deactivate users
        $this->requireRole(['super_admin', 'admin']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->findById($userId);
            if ($user) {
                // Check if this is the only admin
                if ($user['role'] === 'admin') {
                    $adminCount = $this->userModel->count(['role' => 'admin', 'status' => 'active']);
                    if ($adminCount <= 1) {
                        $this->json(['error' => 'Cannot deactivate the only active admin user'], 400);
                        return;
                    }
                }
                
                $this->userModel->update($userId, ['status' => 'inactive']);
                $this->logActivity('deactivate_user', 'user', $userId);
                
                $this->json(['success' => true]);
            } else {
                $this->json(['error' => 'User not found'], 404);
            }
        }
    }
    
    public function search() {
        $search = $_GET['q'] ?? '';
        $role = $_GET['role'] ?? null;
        
        if (strlen($search) < 2) {
            $this->json(['users' => []]);
            return;
        }
        
        $users = $this->userModel->searchUsers($search, $role);
        
        // Format for autocomplete
        $formattedUsers = array_map(function($user) {
            return [
                'id' => $user['id'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'profile_photo' => $user['profile_photo']
            ];
        }, $users);
        
        $this->json(['users' => $formattedUsers]);
    }
    
    public function activity($userId = null) {
        if (!$userId) {
            $userId = $this->getCurrentUser()['id'];
        }
        
        // Only admin can view other users' activities
        if ($userId != $this->getCurrentUser()['id']) {
            $this->requireRole(['super_admin', 'admin']);
        }
        
        $user = $this->userModel->findById($userId);
        if (!$user) {
            $this->redirect('/users');
        }
        
        $activityModel = new ActivityLog($this->db);
        $activities = $activityModel->getUserActivity($userId, 50);
        
        $this->view('users/activity', [
            'user' => $user,
            'activities' => $activities
        ]);
    }
    
    public function export($format = 'csv') {
        // Allow both super_admin and admin to export users
        $this->requireRole(['super_admin', 'admin']);
        
        $users = $this->userModel->findAll('full_name', 'ASC');
        
        switch (strtolower($format)) {
            case 'excel':
                // Export as Excel (XLS) using an HTML table which Excel can open
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="users_export_' . date('Y-m-d') . '.xls"');
                echo "<table border='1'>";
                echo "<tr>"
                    ."<th>ID</th><th>Username</th><th>Email</th><th>Full Name</th>"
                    ."<th>Role</th><th>Status</th><th>Phone</th><th>Last Login</th><th>Created At</th>"
                    ."</tr>";
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['status']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['last_login']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                break;
            case 'pdf':
                // Render printable HTML view; user can Save as PDF via browser
                $this->view('users/export_pdf', [ 'users' => $users ]);
                break;
            case 'csv':
            default:
                // Set headers for CSV download
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="users_export_' . date('Y-m-d') . '.csv"');
                $output = fopen('php://output', 'w');
                fputcsv($output, [
                    'ID', 'Username', 'Email', 'Full Name', 'Role', 'Status', 
                    'Phone', 'Last Login', 'Created At'
                ]);
                foreach ($users as $user) {
                    fputcsv($output, [
                        $user['id'],
                        $user['username'],
                        $user['email'],
                        $user['full_name'],
                        $user['role'],
                        $user['status'],
                        $user['phone'],
                        $user['last_login'],
                        $user['created_at']
                    ]);
                }
                fclose($output);
                break;
        }
    }
}
?>