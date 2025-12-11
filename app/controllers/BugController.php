<?php


class BugController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }
    
    public function index() {
        $currentUser = $this->getCurrentUser();
        $statusFilter = $_GET['status'] ?? '';
        
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            $bugs = $this->bugModel->getAllWithDetails();
        } elseif ($currentUser['role'] === 'project_manager') {
            // PM sees all bugs in their projects
            $bugs = $this->bugModel->getBugsForProjectManager($currentUser['id']);
        } elseif ($currentUser['role'] === 'developer') {
            // Developer only sees bugs assigned to them
            $bugs = $this->bugModel->getAssignedBugs($currentUser['id'], $statusFilter ?: null);
        } elseif ($currentUser['role'] === 'qa_tester') {
            // QA sees bugs they reported + bugs in their projects for validation
            $bugs = $this->bugModel->getBugsForQA($currentUser['id'], $statusFilter ?: null);
        } else {
            $bugs = $this->bugModel->getUserBugs($currentUser['id'], null, $statusFilter ?: null);
        }
        
        $stats = $this->bugModel->getBugStatsForUser($currentUser['id'], $currentUser['role']);
        
        $this->view('bugs/index', [
            'bugs' => $bugs,
            'stats' => $stats,
            'selectedStatus' => $statusFilter,
            'currentUser' => $currentUser,
            'pageTitle' => 'Bug Tracking'
        ]);
    }

    public function updateStatus($bugId) {
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) { $this->redirect('/bugs'); }
        $currentUser = $this->getCurrentUser();
        // Only assigned developer, PM, Admins can change bug status
        $can = in_array($currentUser['role'], ['super_admin','admin','project_manager']) || ($bug['assigned_to'] == $currentUser['id']);
        if (!$can) { $this->redirect('/bugs/view/' . $bugId); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            $allowed = [
                'new' => ['assigned','in_progress','resolved','closed'],
                'assigned' => ['in_progress','resolved','closed'],
                'in_progress' => ['resolved','closed'],
                'resolved' => ['closed','in_progress'],
                'closed' => []
            ];
            $current = $bug['status'];
            if (isset($allowed[$current]) && in_array($status, $allowed[$current], true)) {
                $updateData = ['status' => $status];
                if ($status === 'resolved') {
                    $updateData['resolved_by'] = $currentUser['id'];
                }
                $this->bugModel->update($bugId, $updateData);
                $this->logActivity('update_bug_status', 'bug', $bugId, ['status' => $status]);
            }
        }
        $this->redirect('/bugs/view/' . $bugId);
    }

    public function comment($bugId) {
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) { $this->redirect('/bugs'); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentUser = $this->getCurrentUser();

            // Permission: Admin/PM always; Developer only if assigned; QA allowed
            $role = $currentUser['role'];
            $canInteract = in_array($role, ['super_admin','admin','project_manager','qa_tester']) || ($role === 'developer' && $bug['assigned_to'] == $currentUser['id']);
            if (!$canInteract) { $this->redirect('/bugs/view/' . $bugId); }

            $commentText = trim($_POST['comment'] ?? '');
            $parentIdRaw = $_POST['parent_comment_id'] ?? null;
            $parentCommentId = ($parentIdRaw === '' || $parentIdRaw === null) ? null : (int)$parentIdRaw;
            $hasFile = isset($_FILES['attachments']) && is_array($_FILES['attachments']['name']);

            // Save comment when present and get the comment ID
            $commentId = null;
            if ($commentText !== '') {
                // Check for profanity in comment
                require_once ROOT_PATH . '/app/helpers/ProfanityFilter.php';
                
                if (ProfanityFilter::containsProfanity($commentText)) {
                    $detectedWords = ProfanityFilter::getDetectedProfanity($commentText);
                    
                    // Log the attempt for moderation
                    error_log("Profanity detected in bug comment by user {$currentUser['id']}: " . implode(', ', $detectedWords));
                    
                    $_SESSION['error_message'] = 'Komentar Anda mengandung kata-kata yang tidak pantas. Silakan gunakan bahasa yang sopan.';
                    $this->redirect('/bugs/view/' . $bugId);
                    return;
                }
                
                $commentId = $this->bugModel->addComment($bugId, $currentUser['id'], $commentText, $parentCommentId);
                if ($commentId) {
                    $this->logActivity('add_bug_comment', 'bug', $bugId);
                }
            }

            // Save attachment when present - associate with comment if one was created
            if ($hasFile) {
                $files = $_FILES['attachments'];
                $count = count($files['name']);
                $uploadDir = ROOT_PATH . '/uploads/bugs/';
                if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0755, true); }
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $orig = $files['name'][$i];
                    $safeName = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $orig);
                    $filename = time() . '_' . $i . '_' . $safeName;
                    $dest = $uploadDir . $filename;
                    if (move_uploaded_file($files['tmp_name'][$i], $dest)) {
                        $dbPath = 'uploads/bugs/' . $filename;
                        // Try to insert with comment_id, fallback to without if column doesn't exist
                        try {
                            $this->db->prepare("INSERT INTO bug_attachments (bug_id, comment_id, uploaded_by, file_name, file_path, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?, ?)")
                                ->execute([$bugId, $commentId, $currentUser['id'], $filename, $dbPath, (int)$files['size'][$i], ($files['type'][$i] ?? 'application/octet-stream')]);
                        } catch (\PDOException $e) {
                            // Fallback without comment_id
                            $this->db->prepare("INSERT INTO bug_attachments (bug_id, uploaded_by, file_name, file_path, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?)")
                                ->execute([$bugId, $currentUser['id'], $filename, $dbPath, (int)$files['size'][$i], ($files['type'][$i] ?? 'application/octet-stream')]);
                        }
                        $this->logActivity('upload_bug_attachment', 'bug', $bugId, ['filename' => $filename]);
                    }
                }
            }
        }

        $this->redirect('/bugs/view/' . $bugId);
    }

    public function addComment($bugId) {
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) { $this->redirect('/bugs'); }
        $currentUser = $this->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentText = trim($_POST['comment'] ?? '');
            $parentIdRaw = $_POST['parent_comment_id'] ?? null;
            $parentCommentId = ($parentIdRaw === '' || $parentIdRaw === null) ? null : (int)$parentIdRaw;
            $hasFile = isset($_FILES['attachments']) && is_array($_FILES['attachments']['name']);

            // Save comment when present
            if ($commentText !== '') {
                // Check for profanity in comment
                require_once ROOT_PATH . '/app/helpers/ProfanityFilter.php';
                
                if (ProfanityFilter::containsProfanity($commentText)) {
                    $detectedWords = ProfanityFilter::getDetectedProfanity($commentText);
                    
                    // Log the attempt for moderation
                    error_log("Profanity detected in bug comment by user {$currentUser['id']}: " . implode(', ', $detectedWords));
                    
                    $_SESSION['error_message'] = 'Komentar Anda mengandung kata-kata yang tidak pantas. Silakan gunakan bahasa yang sopan.';
                    $this->redirect('/bugs/view/' . $bugId);
                    return;
                }
                
                if ($this->bugModel->addComment($bugId, $currentUser['id'], $commentText, $parentCommentId)) {
                    $this->logActivity('add_bug_comment', 'bug', $bugId);
                }
            }

            // Save attachment when present
            if ($hasFile) {
                $files = $_FILES['attachments'];
                $count = count($files['name']);
                $uploadDir = ROOT_PATH . '/uploads/bugs/';
                if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0755, true); }
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $orig = $files['name'][$i];
                    $safeName = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $orig);
                    $filename = time() . '_' . $i . '_' . $safeName;
                    $dest = $uploadDir . $filename;
                    if (move_uploaded_file($files['tmp_name'][$i], $dest)) {
                        $dbPath = 'uploads/bugs/' . $filename;
                        $this->db->prepare("INSERT INTO bug_attachments (bug_id, uploaded_by, file_name, file_path, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?)")
                            ->execute([$bugId, $currentUser['id'], $filename, $dbPath, (int)$files['size'][$i], ($files['type'][$i] ?? 'application/octet-stream')]);
                        $this->logActivity('upload_bug_attachment', 'bug', $bugId, ['filename' => $filename]);
                    }
                }
            }
        }
        $this->redirect('/bugs/view/' . $bugId);
    }
    
    /**
     * Edit comment in bug
     */
    public function editComment($bugId, $commentId) {
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) { $this->redirect('/bugs'); }
        $currentUser = $this->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentText = trim($_POST['comment'] ?? '');
            
            if ($commentText === '') {
                $_SESSION['error_message'] = 'Komentar tidak boleh kosong.';
                $this->redirect('/bugs/view/' . $bugId);
                return;
            }
            
            // Check for profanity in comment
            require_once ROOT_PATH . '/app/helpers/ProfanityFilter.php';
            
            if (ProfanityFilter::containsProfanity($commentText)) {
                $_SESSION['error_message'] = 'Komentar Anda mengandung kata-kata yang tidak pantas. Silakan gunakan bahasa yang sopan.';
                $this->redirect('/bugs/view/' . $bugId);
                return;
            }
            
            // Get the current comment to save original text
            $stmt = $this->db->prepare("SELECT comment, original_comment FROM bug_comments WHERE id = ? AND bug_id = ?");
            $stmt->execute([$commentId, $bugId]);
            $currentComment = $stmt->fetch();
            
            if (!$currentComment) {
                $_SESSION['error_message'] = 'Komentar tidak ditemukan.';
                $this->redirect('/bugs/view/' . $bugId);
                return;
            }
            
            // Check if comment is already deleted
            $checkDeleted = $this->db->prepare("SELECT is_deleted FROM bug_comments WHERE id = ?");
            $checkDeleted->execute([$commentId]);
            $isDeleted = $checkDeleted->fetchColumn();
            
            if ($isDeleted) {
                $_SESSION['error_message'] = 'Tidak dapat mengedit komentar yang telah dihapus.';
                $this->redirect('/bugs/view/' . $bugId);
                return;
            }
            
            // If this is the first edit, save the original comment
            $originalComment = $currentComment['original_comment'] ?? null;
            if ($originalComment === null) {
                $originalComment = $currentComment['comment'];
            }
            
            // Update the comment with edit tracking
            $stmt = $this->db->prepare("
                UPDATE bug_comments 
                SET comment = ?, 
                    original_comment = ?, 
                    is_edited = 1, 
                    edited_at = NOW(),
                    edited_by = ?
                WHERE id = ? AND bug_id = ?
            ");
            
            $result = $stmt->execute([$commentText, $originalComment, $currentUser['id'], $commentId, $bugId]);
            
            if ($result) {
                $this->logActivity('edit_bug_comment', 'bug', $bugId, ['comment_id' => $commentId]);
                $_SESSION['success_message'] = 'Komentar berhasil diperbarui.';
            } else {
                $_SESSION['error_message'] = 'Gagal memperbarui komentar.';
            }
        }
        
        $this->redirect('/bugs/view/' . $bugId);
    }
    
    /**
     * Delete comment from bug
     */
    public function deleteComment($bugId, $commentId) {
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) {
            $this->redirect('/bugs');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Only super admin and project manager can delete comments
        if (!in_array($currentUser['role'], ['super_admin', 'project_manager'])) {
            $_SESSION['error_message'] = 'Anda tidak memiliki izin untuk menghapus komentar.';
            $this->redirect('/bugs/view/' . $bugId);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $confirm = $_POST['confirm'] ?? '';
            
            if ($confirm === 'yes') {
                // Soft delete the comment
                $stmt = $this->db->prepare("UPDATE bug_comments SET is_deleted = 1, deleted_at = NOW(), deleted_by = ? WHERE id = ? AND bug_id = ?");
                $result = $stmt->execute([$currentUser['id'], $commentId, $bugId]);
                
                if ($result) {
                    $this->logActivity('delete_bug_comment', 'bug', $bugId, ['comment_id' => $commentId]);
                    $_SESSION['success_message'] = 'Komentar berhasil dihapus.';
                } else {
                    $_SESSION['error_message'] = 'Gagal menghapus komentar.';
                }
            }
        }
        
        $this->redirect('/bugs/view/' . $bugId);
    }

    /**
     * View deleted comments history
     */
    public function deletedComments() {
        $currentUser = $this->getCurrentUser();
        
        // Only super admin and project manager can view deleted comments
        if (!in_array($currentUser['role'], ['super_admin', 'project_manager'])) {
            $this->redirect('/bugs');
        }
        
        // Get all deleted comments with details
        $sql = "SELECT bc.*, 
                       u.full_name, u.username, u.profile_photo,
                       deleted_user.username as deleted_by_username,
                       deleted_user.full_name as deleted_by_name,
                       b.title as bug_title,
                       b.id as bug_id,
                       p.name as project_name
                FROM bug_comments bc
                LEFT JOIN users u ON bc.user_id = u.id
                LEFT JOIN users deleted_user ON bc.deleted_by = deleted_user.id
                LEFT JOIN bugs b ON bc.bug_id = b.id
                LEFT JOIN projects p ON b.project_id = p.id
                WHERE bc.is_deleted = 1
                ORDER BY bc.deleted_at DESC";
        
        $stmt = $this->db->query($sql);
        $deletedComments = $stmt->fetchAll();
        
        $this->view('bugs/deleted_comments', [
            'deletedComments' => $deletedComments,
            'currentUser' => $currentUser,
            'pageTitle' => 'History Komentar Bug Dihapus'
        ]);
    }
    
    /**
     * Restore deleted comment
     */
    public function restoreComment($bugId, $commentId) {
        $currentUser = $this->getCurrentUser();
        
        // Only super admin and project manager can restore comments
        if (!in_array($currentUser['role'], ['super_admin', 'project_manager'])) {
            $_SESSION['error_message'] = 'Anda tidak memiliki izin untuk mengembalikan komentar.';
            $this->redirect('/bugs/view/' . $bugId);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $confirm = $_POST['confirm'] ?? '';
            
            if ($confirm === 'yes') {
                // Restore the comment
                $stmt = $this->db->prepare("UPDATE bug_comments SET is_deleted = 0, deleted_at = NULL, deleted_by = NULL WHERE id = ? AND bug_id = ?");
                $result = $stmt->execute([$commentId, $bugId]);
                
                if ($result) {
                    $this->logActivity('restore_bug_comment', 'bug', $bugId, ['comment_id' => $commentId]);
                    $_SESSION['success_message'] = 'Komentar berhasil dikembalikan.';
                } else {
                    $_SESSION['error_message'] = 'Gagal mengembalikan komentar.';
                }
            }
        }
        
        $this->redirect('/bugs/view/' . $bugId);
    }

    public function assignBug($bugId) {
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) { $this->redirect('/bugs'); }
        $currentUser = $this->getCurrentUser();
        
        // Only PM/Admin can assign bugs
        if (!in_array($currentUser['role'], ['super_admin','admin','project_manager'])) {
            $this->redirect('/bugs/view/' . $bugId);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $assignedTo = $_POST['assigned_to'] ?? null;
            $priority = $_POST['priority'] ?? $bug['priority'];
            
            $updateData = ['priority' => $priority];
            if ($assignedTo) {
                $updateData['assigned_to'] = $assignedTo;
                $updateData['status'] = 'assigned';
            }
            
            if ($this->bugModel->update($bugId, $updateData)) {
                $this->logActivity('assign_bug', 'bug', $bugId, ['assigned_to' => $assignedTo, 'priority' => $priority]);
                $_SESSION['success_message'] = 'Bug assigned successfully.';
            }
        }
        $this->redirect('/bugs/view/' . $bugId);
    }

    public function reopenBug($bugId) {
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) { $this->redirect('/bugs'); }
        $currentUser = $this->getCurrentUser();
        
        // Only QA/PM/Admin can reopen bugs
        if (!in_array($currentUser['role'], ['super_admin','admin','project_manager','qa_tester'])) {
            $this->redirect('/bugs/view/' . $bugId);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reason = trim($_POST['reason'] ?? '');
            if ($this->bugModel->update($bugId, ['status' => 'in_progress'])) {
                if ($reason) {
                    $this->db->prepare("INSERT INTO bug_comments (bug_id, user_id, comment) VALUES (?, ?, ?)")
                        ->execute([$bugId, $currentUser['id'], "Bug reopened: " . $reason]);
                }
                $this->logActivity('reopen_bug', 'bug', $bugId);
                $_SESSION['success_message'] = 'Bug reopened successfully.';
            }
        }
        $this->redirect('/bugs/view/' . $bugId);
    }
    
    public function viewBug($bugId) {
        $bug = $this->bugModel->getBugWithDetails($bugId);
        if (!$bug) {
            $this->redirect('/bugs');
        }
        
        $currentUser = $this->getCurrentUser();
        $comments = $this->bugModel->getBugComments($bugId, $currentUser['role']);
        $attachments = $this->bugModel->getBugAttachments($bugId);
        
        $this->view('bugs/view', [
            'bug' => $bug,
            'comments' => $comments,
            'attachments' => $attachments,
            'currentUser' => $currentUser,
            'pageTitle' => $bug['title']
        ]);
    }

    public function edit($bugId) {
        $currentUser = $this->getCurrentUser();
        $bug = $this->bugModel->getBugWithDetails($bugId);
        if (!$bug) { $this->redirect('/bugs'); }
        $attachments = $this->bugModel->getBugAttachments($bugId);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'severity' => $_POST['severity'],
                'priority' => $_POST['priority'],
                'status' => $_POST['status'] ?? $bug['status'],
                'steps_to_reproduce' => $_POST['steps_to_reproduce'] ?? $bug['steps_to_reproduce'],
                'expected_result' => $_POST['expected_result'] ?? $bug['expected_result'],
                'actual_result' => $_POST['actual_result'] ?? $bug['actual_result'],
                'category_id' => $_POST['category_id'] ?? $bug['category_id'],
                'browser' => $_POST['browser'] ?? $bug['browser'],
                'os' => $_POST['os'] ?? $bug['os'],
                'due_date' => $_POST['due_date'] ?? $bug['due_date'],
                'task_id' => $_POST['task_id'] ?? $bug['task_id'],
                'assigned_to' => $_POST['assigned_to'] ?? $bug['assigned_to'],
            ];
            foreach (["task_id", "category_id", "assigned_to"] as $key) {
                if (isset($data[$key]) && $data[$key] === '') {
                    $data[$key] = null;
                }
            }
            $updated = $this->bugModel->update($bugId, $data);
            $hasFile = isset($_FILES['attachments']) && is_array($_FILES['attachments']['name']) && !empty($_FILES['attachments']['name'][0]);
            if ($updated && $hasFile) {
                // HAPUS SEMUA LAMPIRAN UTAMA LAMA (comment_id IS NULL)
                $stmt = $this->db->prepare("SELECT file_path FROM bug_attachments WHERE bug_id = ? AND (comment_id IS NULL OR comment_id = 0)");
                $stmt->execute([$bugId]);
                $oldFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($oldFiles as $f) {
                    $fpath = isset($f['file_path']) ? ROOT_PATH . '/' . $f['file_path'] : '';
                    if (is_file($fpath)) { @unlink($fpath); }
                }
                $this->db->prepare("DELETE FROM bug_attachments WHERE bug_id = ? AND (comment_id IS NULL OR comment_id = 0)")->execute([$bugId]);
                // --- lalu simpan lampiran baru seperti biasa ---
                $files = $_FILES['attachments'];
                $count = count($files['name']);
                $uploadDir = ROOT_PATH . '/uploads/bugs/';
                if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0755, true); }
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $orig = $files['name'][$i];
                    $safeName = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $orig);
                    $filename = time() . '_' . $i . '_' . $safeName;
                    $dest = $uploadDir . $filename;
                    if (move_uploaded_file($files['tmp_name'][$i], $dest)) {
                        $dbPath = 'uploads/bugs/' . $filename;
                        try {
                            $this->db->prepare("INSERT INTO bug_attachments (bug_id, comment_id, uploaded_by, file_name, file_path, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?, ?)")
                                ->execute([$bugId, null, $currentUser['id'], $filename, $dbPath, (int)$files['size'][$i], ($files['type'][$i] ?? 'application/octet-stream')]);
                        } catch (\PDOException $e) {
                            $this->db->prepare("INSERT INTO bug_attachments (bug_id, uploaded_by, file_name, file_path, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?)")
                                ->execute([$bugId, $currentUser['id'], $filename, $dbPath, (int)$files['size'][$i], ($files['type'][$i] ?? 'application/octet-stream')]);
                        }
                        $this->logActivity('upload_bug_attachment', 'bug', $bugId, ['filename' => $filename]);
                    }
                }
            }
            if ($updated) {
                $this->logActivity('update_bug', 'bug', $bugId);
                $this->redirect('/bugs/view/' . $bugId);
            }
        }
        $currentUser = $this->getCurrentUser();
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            $projects = $this->projectModel->findAll();
        } else {
            $projects = $this->projectModel->getUserProjects($currentUser['id']);
        }
        $categories = $this->bugCategoryModel->findAll();
        $users = $this->userModel->findAll();
        if (!isset($bug['tags'])) { $bug['tags'] = ''; }
        $this->view('bugs/create', [
            'bug' => $bug,
            'projects' => $projects,
            'categories' => $categories,
            'users' => $users,
            'attachments' => $attachments,
            'isEdit' => true,
            'pageTitle' => 'Edit Bug',
        ]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentUser = $this->getCurrentUser();
            
            $data = [
                'project_id' => (int)$_POST['project_id'],
                'task_id' => !empty($_POST['task_id']) ? (int)$_POST['task_id'] : null,
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'steps_to_reproduce' => $_POST['steps_to_reproduce'],
                'expected_result' => $_POST['expected_result'],
                'actual_result' => $_POST['actual_result'],
                'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
                'severity' => $_POST['severity'],
                'priority' => $_POST['priority'],
                'status' => !empty($_POST['assigned_to']) ? 'assigned' : 'new',
                'reported_by' => $currentUser['id'],
                'assigned_to' => !empty($_POST['assigned_to']) ? (int)$_POST['assigned_to'] : null,
                'browser' => $_POST['browser'] ?? null,
                'os' => $_POST['os'] ?? null,
                'environment' => $_POST['environment'] ?? 'development'
            ];
            
            $errors = $this->validate($_POST, [
                'project_id' => 'required',
                'title' => 'required|max:200',
                'description' => 'required',
                'steps_to_reproduce' => 'required',
                'expected_result' => 'required',
                'actual_result' => 'required',
                'category_id' => 'required',
                'severity' => 'required',
                'priority' => 'required'
            ]);
            
            // Validate attachments (required)
            if (empty($_FILES['attachments']) || empty($_FILES['attachments']['name'][0])) {
                $errors['attachments'] = 'At least one attachment (screenshot/log) is required';
            }
            
            if (empty($errors)) {
                $bugId = $this->bugModel->create($data);
                
                if ($bugId) {
                    // Handle file uploads
                    if (!empty($_FILES['attachments']) && is_array($_FILES['attachments']['name'])) {
                        $files = $_FILES['attachments'];
                        $uploadDir = ROOT_PATH . '/uploads/bugs/';
                        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0755, true); }
                        
                        $count = count($files['name']);
                        for ($i = 0; $i < $count; $i++) {
                            if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                            
                            $orig = $files['name'][$i];
                            $safe = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $orig);
                            $filename = time() . '_' . $i . '_' . $safe;
                            $dest = $uploadDir . $filename;
                            
                            if (move_uploaded_file($files['tmp_name'][$i], $dest)) {
                                $dbPath = 'uploads/bugs/' . $filename;
                                $this->db->prepare("INSERT INTO bug_attachments (bug_id, uploaded_by, file_name, file_path, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?)")
                                    ->execute([$bugId, $currentUser['id'], $filename, $dbPath, (int)$files['size'][$i], ($files['type'][$i] ?? 'application/octet-stream')]);
                            }
                        }
                    }
                    
                    $this->logActivity('report_bug', 'bug', $bugId);
                    $_SESSION['success_message'] = 'Bug report created successfully with attachments.';
                    $this->redirect('/bugs/view/' . $bugId);
                } else {
                    $errors['general'] = 'Failed to create bug report';
                }
            }
        }
        
        // Get projects and categories for dropdowns
        $currentUser = $this->getCurrentUser();
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            $projects = $this->projectModel->findAll();
        } else {
            $projects = $this->projectModel->getUserProjects($currentUser['id']);
        }
        
        $categories = $this->bugCategoryModel->findAll();
        $users = $this->userModel->findAll(); // For developer assignment dropdown
        
        $this->view('bugs/create', [
            'projects' => $projects,
            'categories' => $categories,
            'users' => $users,
            'errors' => $errors ?? [],
            'pageTitle' => 'Report Bug'
        ]);
    }

    public function delete($bugId) {
        // Only super_admin, admin, and project_manager can delete
        $this->requireRole(['super_admin', 'admin', 'project_manager']);
        $bug = $this->bugModel->findById($bugId);
        if (!$bug) {
            $this->redirect('/bugs');
        }
        try {
            $deleted = $this->bugModel->delete($bugId);
            if ($deleted) {
                $this->logActivity('delete_bug', 'bug', $bugId);
                $_SESSION['success_message'] = 'Bug berhasil dihapus.';
            } else {
                $_SESSION['error_message'] = 'Gagal menghapus bug.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Terjadi kesalahan: ' . $e->getMessage();
        }
        $this->redirect('/bugs');
    }
}
?>