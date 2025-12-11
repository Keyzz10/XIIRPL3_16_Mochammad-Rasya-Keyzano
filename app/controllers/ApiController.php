<?php

class ApiController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        // Skip auth check for API routes
    }
    
    public function index() {
        $this->json(['message' => 'API endpoint'], 404);
    }
    
    public function getComment() {
        if (!$this->isLoggedIn()) {
            $this->json(['error' => 'Unauthorized'], 401);
            return;
        }
        
        $commentId = $_GET['comment_id'] ?? null;
        if (!$commentId) {
            $this->json(['error' => 'Comment ID is required'], 400);
            return;
        }
        
        $stmt = $this->db->prepare("SELECT * FROM bug_comments WHERE id = ?");
        $stmt->execute([$commentId]);
        $comment = $stmt->fetch();
        
        if (!$comment) {
            $this->json(['error' => 'Comment not found'], 404);
            return;
        }
        
        $this->json(['comment' => $comment]);
    }
    

    
    public function getTaskComment() {
        if (!$this->isLoggedIn()) {
            $this->json(['error' => 'Unauthorized'], 401);
            return;
        }
        
        $commentId = $_GET['comment_id'] ?? null;
        if (!$commentId) {
            $this->json(['error' => 'Comment ID is required'], 400);
            return;
        }
        
        $stmt = $this->db->prepare("SELECT * FROM task_comments WHERE id = ?");
        $stmt->execute([$commentId]);
        $comment = $stmt->fetch();
        
        if (!$comment) {
            $this->json(['error' => 'Comment not found'], 404);
            return;
        }
        
        $this->json(['comment' => $comment]);
    }
    
    public function checkAuth() {
        $isLoggedIn = $this->isLoggedIn();
        $user = null;
        
        if ($isLoggedIn) {
            $user = $this->getCurrentUser();
        }
        
        $this->json([
            'loggedIn' => $isLoggedIn,
            'user' => $user ? [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],
                'role' => $user['role'],
                'email' => $user['email']
            ] : null
        ]);
    }

}
?>
