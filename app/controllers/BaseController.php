<?php
/**
 * Base Controller
 * All controllers should extend this class
 */

class BaseController {
    protected $db;
    protected $userModel;
    protected $projectModel;
    protected $taskModel;
    protected $bugModel;
    protected $clientModel;
    protected $bugCategoryModel;
    protected $testCaseModel;
    protected $testSuiteModel;
    
    public function __construct() {
        session_start();
        
        // Initialize database connection
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Initialize language system
        Language::init();
        
        // Initialize models
        $this->userModel = new User($this->db);
        $this->projectModel = new Project($this->db);
        $this->taskModel = new Task($this->db);
        $this->bugModel = new Bug($this->db);
        $this->clientModel = new Client($this->db);
        $this->bugCategoryModel = new BugCategory($this->db);
        $this->testCaseModel = new TestCase($this->db);
        $this->testSuiteModel = new TestSuite($this->db);
        
        // Check if user is logged in for protected routes
        $this->checkAuth();
    }
    
    protected function checkAuth() {
        $publicRoutes = ['login', 'register', 'api'];
        $currentRoute = $this->getCurrentRoute();
        
        if (!in_array($currentRoute, $publicRoutes) && !$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    protected function getCurrentRoute() {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $parts = explode('/', $url);
        return $parts[0] ?? 'dashboard';
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    protected function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return $this->userModel->findById($_SESSION['user_id']);
        }
        return null;
    }
    
    protected function hasRole($roles) {
        $user = $this->getCurrentUser();
        if (!$user) return false;
        
        if (is_string($roles)) {
            $roles = [$roles];
        }
        
        return in_array($user['role'], $roles);
    }
    
    protected function requireRole($roles) {
        if (!$this->hasRole($roles)) {
            $this->forbidden();
        }
    }
    
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }
    }
    
    protected function view($viewName, $data = []) {
        // Extract data array to variables
        extract($data);
        
        // Get current user for all views
        $currentUser = $this->getCurrentUser();
        
        // Include view file
        $viewFile = ROOT_PATH . '/app/views/' . $viewName . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View not found: " . $viewName);
        }
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function redirect($url) {
        // Debug logging
        error_log("FlowTask Redirect Debug - Redirecting to: {$url}");
        
        // For file-based navigation, always use index.php?url= format
        $redirectUrl = 'index.php';
        if (!empty($url) && $url !== '/') {
            $redirectUrl .= '?url=' . ltrim($url, '/');
        }
        
        error_log("FlowTask Redirect Debug - Final URL: {$redirectUrl}");
        header('Location: ' . $redirectUrl);
        exit;
    }
    
    protected function forbidden() {
        http_response_code(403);
        $this->view('errors/403');
        exit;
    }
    
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            $ruleList = explode('|', $rule);
            
            foreach ($ruleList as $singleRule) {
                if ($singleRule === 'required' && empty($value)) {
                    $errors[$field] = ucfirst($field) . ' is required';
                    break;
                }
                
                if (strpos($singleRule, 'min:') === 0) {
                    $min = (int) substr($singleRule, 4);
                    if (strlen($value) < $min) {
                        $errors[$field] = ucfirst($field) . ' must be at least ' . $min . ' characters';
                        break;
                    }
                }
                
                if (strpos($singleRule, 'max:') === 0) {
                    $max = (int) substr($singleRule, 4);
                    if (strlen($value) > $max) {
                        $errors[$field] = ucfirst($field) . ' must not exceed ' . $max . ' characters';
                        break;
                    }
                }
                
                if ($singleRule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = ucfirst($field) . ' must be a valid email';
                    break;
                }
            }
        }
        
        return $errors;
    }
    
    protected function uploadFile($file, $directory = 'general') {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $uploadDir = UPLOADS_PATH . '/' . $directory . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = time() . '_' . basename($file['name']);
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $directory . '/' . $fileName;
        }
        
        return false;
    }
    
    protected function logActivity($action, $entityType, $entityId, $oldValues = null, $newValues = null) {
        if ($this->isLoggedIn()) {
            $activityLog = new ActivityLog($this->db);
            $activityLog->log(
                $_SESSION['user_id'],
                $action,
                $entityType,
                $entityId,
                $oldValues,
                $newValues
            );
        }
    }
}
?>