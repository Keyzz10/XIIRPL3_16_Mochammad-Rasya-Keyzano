<?php


class AuthController extends BaseController {
    
    public function __construct() {
        // Skip auth check for authentication routes
        session_start();
        
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new User($this->db);
    }
    
    public function login() {
        // Check if already logged in - redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validate input
            $errors = $this->validate($_POST, [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            if (empty($errors)) {
                $result = $this->userModel->authenticate($email, $password);
                
                if (is_array($result) && !isset($result['error'])) {
                    // Successful login
                    $user = $result;
                    
                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['language'] = 'id'; // Force Indonesian language
                    
                    // Log activity
                    $this->logActivity('login', 'user', $user['id']);
                    
                    // Redirect based on role
                    $this->redirect('/dashboard');
                } else {
                    // Authentication failed
                    if (isset($result['error'])) {
                        $errors['login'] = $result['error'];
                    } else {
                        $errors['login'] = 'Email atau kata sandi tidak valid';
                    }
                }
            }
            
            $this->view('auth/login', ['errors' => $errors]);
        } else {
            $this->view('auth/login');
        }
    }
    
    public function register() {
        // Check if already logged in - redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input
            $errors = $this->validate($_POST, [
                'username' => 'required|min:3|max:50',
                'email' => 'required|email',
                'password' => 'required|min:8',
                'confirm_password' => 'required',
                'full_name' => 'required|max:100'
            ]);
            
            // Check password confirmation
            if ($_POST['password'] !== $_POST['confirm_password']) {
                $errors['confirm_password'] = 'Password confirmation does not match';
            }
            
            if (empty($errors)) {
                $data = [
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'full_name' => $_POST['full_name'],
                    'role' => $_POST['role'] ?? 'developer'
                ];
                
                $result = $this->userModel->register($data);
                
                if (isset($result['success'])) {
                    // Auto login after registration
                    $_SESSION['user_id'] = $result['user_id'];
                    $user = $this->userModel->findById($result['user_id']);
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['language'] = 'id'; // Force Indonesian language
                    
                    $this->redirect('/dashboard');
                } else {
                    $errors['registration'] = $result['error'];
                }
            }
            
            $this->view('auth/register', ['errors' => $errors]);
        } else {
            $this->view('auth/register');
        }
    }
    
    public function logout() {
        if ($this->isLoggedIn()) {
            $this->logActivity('logout', 'user', $_SESSION['user_id']);
        }
        
        // Destroy session
        session_destroy();
        
        $this->redirect('/login');
    }
    
    public function forgotPassword() {
        // Check if already logged in - redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            $errors = $this->validate($_POST, [
                'email' => 'required|email'
            ]);
            
            if (empty($errors)) {
                $user = $this->userModel->findOneBy('email', $email);
                
                if ($user) {
                    // Generate reset token (implement email sending here)
                    $message = 'Password reset instructions have been sent to your email';
                } else {
                    $message = 'If an account with that email exists, you will receive password reset instructions';
                }
                
                $this->view('auth/forgot-password', ['message' => $message]);
            } else {
                $this->view('auth/forgot-password', ['errors' => $errors]);
            }
        } else {
            $this->view('auth/forgot-password');
        }
    }
}
?>