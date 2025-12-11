<?php
/**
 * Task Controller
 */

class TaskController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }
    
    public function index() {
        $currentUser = $this->getCurrentUser();
        
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            // Super Admin dan Admin: lihat semua task
            $tasks = $this->taskModel->getAllWithDetails();
            $stats = $this->taskModel->getTaskStats();
        } elseif ($currentUser['role'] === 'project_manager') {
            // Project Manager: lihat task di project yang dia manage
            $tasks = $this->taskModel->getTasksForProjectManager($currentUser['id']);
            $stats = $this->taskModel->getTaskStatsForProjectManager($currentUser['id']);
        } elseif ($currentUser['role'] === 'qa_tester') {
            // QA Tester: lihat semua task di project yang dia assigned (untuk testing)
            $tasks = $this->taskModel->getTasksForQA($currentUser['id']);
            $stats = $this->taskModel->getTaskStatsForQA($currentUser['id']);
        } else {
            // Developer: lihat task yang di-assign ke dia
            $tasks = $this->taskModel->getUserTasks($currentUser['id']);
            $stats = $this->taskModel->getTaskStatsForUser($currentUser['id']);
        }
        
        $this->view('tasks/index', [
            'tasks' => $tasks,
            'stats' => $stats,
            'currentUser' => $currentUser,
            'pageTitle' => 'Tasks'
        ]);
    }
    
    public function viewTask($taskId) {
        // Use detailed fetch so view has project and assignee names
        $task = $this->taskModel->findWithDetails($taskId);
        if ($task && (empty($task['created_by_name']) || $task['created_by_name'] === null)) {
            // Fallback: resolve creator name if join returned empty
            $creator = !empty($task['created_by']) ? $this->userModel->findById((int)$task['created_by']) : null;
            if ($creator) {
                $task['created_by_name'] = $creator['full_name'] ?? ($creator['username'] ?? '');
            }
        }
        if (!$task) {
            $this->redirect('/tasks');
        }
        // Auto-heal: ensure done task always shows 100% progress
        if (($task['status'] ?? '') === 'done' && (float)($task['progress'] ?? 0) < 100) {
            $this->taskModel->update($taskId, ['progress' => 100]);
            $task['progress'] = 100;
        }
        
        // Check if user has access to this task
        $currentUser = $this->getCurrentUser();
        $readOnly = false;
        if (!in_array($currentUser['role'], ['super_admin', 'admin'])) {
            if ($currentUser['role'] === 'project_manager') {
                // PM can view tasks within their projects (assumed routed from their views), allow
            } elseif ($currentUser['role'] === 'developer') {
                // Developer can view any task, but only edit if assigned
                if ($task['assigned_to'] != $currentUser['id']) {
                    $readOnly = true;
                }
            } elseif ($currentUser['role'] === 'qa_tester') {
                // QA generally read-only here (edits go via verify/bug report)
                $readOnly = true;
            } else {
                if ($task['assigned_to'] != $currentUser['id'] && $task['created_by'] != $currentUser['id']) {
                    $this->redirect('/tasks');
                }
            }
        }
        
        $comments = $this->taskModel->getTaskComments($taskId, $currentUser['role']);
        $attachments = $this->taskModel->getTaskAttachments($taskId);
        $subTasks = $this->taskModel->getSubTasks($taskId);
        
        $this->view('tasks/view', [
            'task' => $task,
            'comments' => $comments,
            'attachments' => $attachments,
            'subTasks' => $subTasks,
            'currentUser' => $currentUser,
            'readOnly' => $readOnly,
            'pageTitle' => $task['title']
        ]);
    }
    
    public function create() {
        // Only Project Managers, Super Admin, and Admin can create tasks
        $currentUser = $this->getCurrentUser();
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentUser = $this->getCurrentUser();
            
            // Normalize optional fields coming from form
            $parentTaskIdInput = $_POST['parent_task_id'] ?? null;
            $normalizedParentTaskId = ($parentTaskIdInput === '' || $parentTaskIdInput === null)
                ? null
                : (int)$parentTaskIdInput;

            $data = [
                'project_id' => $_POST['project_id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'assigned_to' => $_POST['assigned_to'],
                'created_by' => $currentUser['id'],
                'reporter_id' => $currentUser['id'], // Reporter is the same as creator for now
                'task_type' => $_POST['task_type'] ?? 'feature',
                'tags' => $_POST['tags'] ?? '',
                'parent_task_id' => $normalizedParentTaskId,
                'visibility' => $_POST['visibility'] ?? 'project',
                'status' => $_POST['status'] ?? 'to_do',
                'priority' => $_POST['priority'],
                'due_date' => $_POST['due_date'] ?? null,
                'estimated_hours' => $_POST['estimated_hours'] === '' ? 0 : $_POST['estimated_hours']
            ];
            
            $errors = $this->validate($_POST, [
                'project_id' => 'required',
                'title' => 'required|max:200',
                'description' => 'required',
                'assigned_to' => 'required',
                'priority' => 'required'
            ]);

            // Additional rule: PM may only assign to Developer or QA Tester
            if (empty($errors) && $currentUser['role'] === 'project_manager') {
                $assignee = $this->userModel->findById((int)$data['assigned_to']);
                if (!$assignee || !in_array($assignee['role'], ['developer', 'qa_tester'])) {
                    $errors['assigned_to'] = 'Project Manager can only assign tasks to Developer or QA Tester.';
                }
            }
            
            if (empty($errors)) {
                $taskId = $this->taskModel->createTask($data);
                
                if ($taskId) {
                    $this->logActivity('create_task', 'task', $taskId);
                    $this->redirect('/tasks/view/' . $taskId);
                } else {
                    $errors['general'] = 'Failed to create task';
                }
            }
        }
        
        // Get projects and users for dropdowns
        $currentUser = $this->getCurrentUser();
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            $projects = $this->projectModel->findAll();
        } else {
            $projects = $this->projectModel->getUserProjects($currentUser['id']);
        }
        
        $users = $this->userModel->findAll();
        // For PMs, show only Developer and QA Tester in assignee dropdown
        if ($currentUser['role'] === 'project_manager') {
            $users = array_values(array_filter($users, function($u) {
                return in_array($u['role'], ['developer', 'qa_tester']);
            }));
        }
        
        // Get parent tasks for subtask creation
        $parentTasks = [];
        if (!empty($projects)) {
            foreach ($projects as $project) {
                $projectTasks = $this->taskModel->getProjectTasks($project['id']);
                foreach ($projectTasks as $task) {
                    $parentTasks[] = $task;
                }
            }
        }
        
        $this->view('tasks/create', [
            'projects' => $projects,
            'users' => $users,
            'parentTasks' => $parentTasks,
            'currentUser' => $currentUser,
            'errors' => $errors ?? [],
            'pageTitle' => 'Create Task'
        ]);
    }
    
    public function comment($taskId) {
        $task = $this->taskModel->findWithDetails($taskId);
        if (!$task) { $this->redirect('/tasks'); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentUser = $this->getCurrentUser();

            // Permission: Admin/PM always; Developer only if assigned; QA allowed
            $role = $currentUser['role'];
            $canInteract = in_array($role, ['super_admin','admin','project_manager','qa_tester']) || ($role === 'developer' && $task['assigned_to'] == $currentUser['id']);
            if (!$canInteract) { $this->redirect('/tasks/view/' . $taskId); }

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
                    error_log("Profanity detected in task comment by user {$currentUser['id']}: " . implode(', ', $detectedWords));
                    
                    $_SESSION['error_message'] = 'Komentar Anda mengandung kata-kata yang tidak pantas. Silakan gunakan bahasa yang sopan.';
                    $this->redirect('/tasks/view/' . $taskId);
                    return;
                }
                
                $commentId = $this->taskModel->addComment($taskId, $currentUser['id'], $commentText, $parentCommentId);
                if ($commentId) {
                    $this->logActivity('add_comment', 'task', $taskId);
                }
            }

            // Save attachment when present - associate with comment if one was created
            if ($hasFile) {
                $files = $_FILES['attachments'];
                $count = count($files['name']);
                $uploadDir = ROOT_PATH . '/uploads/tasks/';
                if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0755, true); }
                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $orig = $files['name'][$i];
                    $safeName = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $orig);
                    $filename = time() . '_' . $i . '_' . $safeName;
                    $dest = $uploadDir . $filename;
                    if (move_uploaded_file($files['tmp_name'][$i], $dest)) {
                        $this->taskModel->addAttachment($taskId, [
                            'comment_id' => $commentId,
                            'filename' => $filename,
                            'original_name' => $orig,
                            'file_path' => 'uploads/tasks/' . $filename,
                            'file_size' => (int)$files['size'][$i],
                            'file_type' => $files['type'][$i] ?? 'application/octet-stream',
                            'uploaded_by' => $currentUser['id']
                        ]);
                        $this->logActivity('upload_attachment', 'task', $taskId, ['filename' => $filename]);
                    }
                }
            }
        }

        $this->redirect('/tasks/view/' . $taskId);
    }
    
    public function updateStatus($taskId) {
        // Use detailed fetch so sidebar shows creator name and related info
        $task = $this->taskModel->findWithDetails($taskId);
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Only assigned user, Project Manager, Super Admin, and Admin can update status
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager']) && 
            $task['assigned_to'] != $currentUser['id']) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';

            // Prevent invalid transitions
            $current = $task['status'];
            $allowed = [
                'to_do' => ['in_progress'],
                'in_progress' => ['done'],
                'done' => []
            ];

            if (isset($allowed[$current]) && in_array($status, $allowed[$current], true)) {
                $payload = ['status' => $status];
                if ($status === 'done') { $payload['progress'] = 100; }
                $result = $this->taskModel->update($taskId, $payload);
                if ($result) {
                    $this->logActivity('update_task_status', 'task', $taskId, ['status' => $status]);
                }
            }
        }
        
        $this->redirect('/tasks/view/' . $taskId);
    }

    public function approveEstimated($taskId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) { $this->redirect('/tasks'); }
        $currentUser = $this->getCurrentUser();
        if (!in_array($currentUser['role'], ['super_admin','admin','project_manager'])) {
            $this->redirect('/tasks/view/' . $taskId);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pending = $_SESSION['pending_estimated_hours'][$taskId] ?? null;
            $decision = $_POST['decision'] ?? '';
            $notes = $task['verification_notes'] ?? '';
            if (strpos((string)$notes, 'hours_pending:') === 0) {
                $value = isset($_POST['value']) ? (float)$_POST['value'] : (float)substr($notes, strlen('hours_pending:'));
                if ($decision === 'approve') {
                    $this->taskModel->update($taskId, [
                        'estimated_hours' => $value,
                        'verification_notes' => null,
                        'verified_by' => $currentUser['id'],
                        'verified_at' => date('Y-m-d H:i:s')
                    ]);
                    $_SESSION['success_message'] = 'Estimated hours updated to ' . $value . ' hrs.';
                } else {
                    $this->taskModel->update($taskId, [
                        'verification_notes' => null,
                        'verified_by' => null,
                        'verified_at' => null
                    ]);
                    $_SESSION['success_message'] = 'Proposed estimated hours rejected.';
                }
            }
        }
        $this->redirect('/tasks/view/' . $taskId);
    }
    
    public function edit($taskId) {
        $task = $this->taskModel->findWithDetails($taskId);
        if ($task && (empty($task['created_by_name']) || $task['created_by_name'] === null)) {
            $creator = !empty($task['created_by']) ? $this->userModel->findById((int)$task['created_by']) : null;
            if ($creator) {
                $task['created_by_name'] = $creator['full_name'] ?? ($creator['username'] ?? '');
            }
        }
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        // Check if user has access to edit this task
        $currentUser = $this->getCurrentUser();
        
        // Only Project Managers, Super Admin, and Admin can edit tasks
        // Developers and QA can only edit their own assigned tasks (limited fields)
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])) {
            // For Developer and QA: only if assigned to them
            if ($task['assigned_to'] != $currentUser['id']) {
                $this->redirect('/tasks');
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $parentTaskIdInput = $_POST['parent_task_id'] ?? null;
            $normalizedParentTaskId = ($parentTaskIdInput === '' || $parentTaskIdInput === null)
                ? null
                : (int)$parentTaskIdInput;

            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'assigned_to' => $_POST['assigned_to'],
                'status' => $_POST['status'],
                'priority' => $_POST['priority'],
                'due_date' => $_POST['due_date'] ?: null,
                'estimated_hours' => $_POST['estimated_hours'] === '' ? 0 : $_POST['estimated_hours'],
                'progress' => $_POST['progress'] ?: 0
            ];

            // If status is done, force progress to 100%
            if (($data['status'] ?? '') === 'done') {
                $data['progress'] = 100;
            }
            
            $rules = [
                'title' => 'required|max:200',
                'description' => 'required',
                'assigned_to' => 'required',
                'priority' => 'required'
            ];
            if ($currentUser['role'] === 'developer') {
                unset($rules['title'], $rules['description'], $rules['assigned_to'], $rules['priority']);
            }
            $errors = $this->validate($_POST, $rules);

            // Restrict fields editable by role
            if ($currentUser['role'] === 'developer') {
                // Developer cannot change title/description/assignee/priority/due_date
                unset($data['title'], $data['description'], $data['assigned_to'], $data['priority'], $data['due_date']);
                // When developer proposes change to estimated_hours, require PM approval: store as pending
                if (isset($_POST['estimated_hours']) && $_POST['estimated_hours'] !== '') {
                    // keep current hours; store pending request in verification_notes
                    $data['estimated_hours'] = $task['estimated_hours'];
                    $pendingValue = (float)$_POST['estimated_hours'];
                    $this->taskModel->update($taskId, [
                        'verification_notes' => 'hours_pending:' . $pendingValue,
                        'verified_by' => null,
                        'verified_at' => null
                    ]);
                    $_SESSION['success_message'] = 'Requested change to Estimated Hours; awaiting Project Manager approval.';
                }
            } else if ($currentUser['role'] === 'project_manager') {
                // PM may only (re)assign to Developer or QA Tester
                if (empty($errors)) {
                    $assignee = $this->userModel->findById((int)$data['assigned_to']);
                    if (!$assignee || !in_array($assignee['role'], ['developer', 'qa_tester'])) {
                        $errors['assigned_to'] = 'Project Manager can only assign tasks to Developer or QA Tester.';
                    }
                }
            }
            
            if (empty($errors)) {
                $result = $this->taskModel->updateTask($taskId, $data);
                
                if ($result) {
                    $this->logActivity('update_task', 'task', $taskId);
                    $this->redirect('/tasks/view/' . $taskId);
                } else {
                    $errors['general'] = 'Failed to update task';
                }
            }
        }
        
        // Get projects and users for dropdowns
        $currentUser = $this->getCurrentUser();
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            $projects = $this->projectModel->findAll();
        } else {
            $projects = $this->projectModel->getUserProjects($currentUser['id']);
        }
        
        $users = $this->userModel->findAll();
        if ($currentUser['role'] === 'project_manager') {
            $users = array_values(array_filter($users, function($u) {
                return in_array($u['role'], ['developer', 'qa_tester']);
            }));
        }
        
        $this->view('tasks/edit', [
            'task' => $task,
            'projects' => $projects,
            'users' => $users,
            'currentUser' => $currentUser,
            'pendingEstimated' => $_SESSION['pending_estimated_hours'][$taskId] ?? null,
            'errors' => $errors ?? [],
            'pageTitle' => 'Edit Task'
        ]);
    }
    
    public function delete($taskId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        // Check if user has permission to delete this task
        $currentUser = $this->getCurrentUser();
        // Only Project Managers, Super Admin, and Admin can delete tasks
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $confirm = $_POST['confirm'] ?? '';
            
            if ($confirm === 'yes') {
                // Delete task comments first
                $this->db->prepare("DELETE FROM task_comments WHERE task_id = ?")->execute([$taskId]);
                
                // Delete task attachments
                $this->db->prepare("DELETE FROM task_attachments WHERE task_id = ?")->execute([$taskId]);
                
                // Delete subtasks
                $this->db->prepare("DELETE FROM tasks WHERE parent_task_id = ?")->execute([$taskId]);
                
                // Delete the main task
                $result = $this->taskModel->delete($taskId);
                
                if ($result) {
                    $this->logActivity('delete_task', 'task', $taskId);
                    
                    // Update project progress
                    $projectModel = new Project($this->db);
                    $projectModel->updateProgress($task['project_id']);
                    
                    $_SESSION['success_message'] = 'Task berhasil dihapus.';
                    $this->redirect('/tasks');
                } else {
                    $_SESSION['error_message'] = 'Gagal menghapus task.';
                    $this->redirect('/tasks/view/' . $taskId);
                }
            } else {
                $this->redirect('/tasks/view/' . $taskId);
            }
        }
        
        // Show confirmation page
        $this->view('tasks/delete_confirm', [
            'task' => $task,
            'currentUser' => $currentUser,
            'pageTitle' => 'Konfirmasi Hapus Task'
        ]);
    }
    
    /**
     * QA/Tester: Create bug report for a task
     */
    public function createBugReport($taskId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Only QA Tester, Project Manager, Super Admin, and Admin can create bug reports
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager', 'qa_tester'])) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'task_id' => $taskId,
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'severity' => $_POST['severity'],
                'status' => 'open',
                'reported_by' => $currentUser['id'],
                'project_id' => $task['project_id']
            ];
            
            $errors = $this->validate($_POST, [
                'title' => 'required|max:200',
                'description' => 'required',
                'severity' => 'required'
            ]);
            
            if (empty($errors)) {
                // Create bug report (assuming you have a Bug model)
                $bugModel = new Bug($this->db);
                $bugId = $bugModel->create($data);
                
                if ($bugId) {
                    // Update task status to 'bug_found' or similar
                    $this->taskModel->update($taskId, ['status' => 'bug_found']);
                    
                    $this->logActivity('create_bug_report', 'bug', $bugId, ['task_id' => $taskId]);
                    $_SESSION['success_message'] = 'Bug report berhasil dibuat.';
                    $this->redirect('/tasks/view/' . $taskId);
                } else {
                    $errors['general'] = 'Failed to create bug report';
                }
            }
        }
        
        $this->view('tasks/create_bug_report', [
            'task' => $task,
            'currentUser' => $currentUser,
            'errors' => $errors ?? [],
            'pageTitle' => 'Create Bug Report'
        ]);
    }
    
    /**
     * QA/Tester: Verify task completion
     */
    public function verifyTask($taskId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Only QA Tester, Project Manager, Super Admin, and Admin can verify tasks
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager', 'qa_tester'])) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verified = $_POST['verified'] === 'yes';
            
            if ($verified) {
                $result = $this->taskModel->update($taskId, [
                    'status' => 'verified',
                    'verified_by' => $currentUser['id'],
                    'verified_at' => date('Y-m-d H:i:s')
                ]);
                
                if ($result) {
                    $this->logActivity('verify_task', 'task', $taskId);
                    $_SESSION['success_message'] = 'Task berhasil diverifikasi.';
                }
            } else {
                $result = $this->taskModel->update($taskId, [
                    'status' => 'needs_revision',
                    'verification_notes' => $_POST['notes'] ?? ''
                ]);
                
                if ($result) {
                    $this->logActivity('reject_task', 'task', $taskId, ['notes' => $_POST['notes'] ?? '']);
                    $_SESSION['success_message'] = 'Task ditolak dan perlu revisi.';
                }
            }
            
            $this->redirect('/tasks/view/' . $taskId);
        }
        
        $this->view('tasks/verify_task', [
            'task' => $task,
            'currentUser' => $currentUser,
            'pageTitle' => 'Verify Task'
        ]);
    }
    
    /**
     * Upload file attachment to task
     */
    public function uploadAttachment($taskId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Check if user has access to this task
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager']) && 
            $task['assigned_to'] != $currentUser['id']) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['attachment'])) {
            $file = $_FILES['attachment'];
            
            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadDir = ROOT_PATH . '/uploads/tasks/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $filename = time() . '_' . basename($file['name']);
                $filePath = $uploadDir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    $attachmentData = [
                        'filename' => $filename,
                        'original_name' => $file['name'],
                        'file_path' => 'uploads/tasks/' . $filename,
                        'file_size' => $file['size'],
                        'file_type' => $file['type'],
                        'uploaded_by' => $currentUser['id']
                    ];
                    
                    if ($this->taskModel->addAttachment($taskId, $attachmentData)) {
                        $this->logActivity('upload_attachment', 'task', $taskId);
                        $_SESSION['success_message'] = 'File berhasil diupload.';
                    } else {
                        $_SESSION['error_message'] = 'Gagal menyimpan file.';
                    }
                } else {
                    $_SESSION['error_message'] = 'Gagal mengupload file.';
                }
            } else {
                $_SESSION['error_message'] = 'Error dalam upload file.';
            }
        }
        
        $this->redirect('/tasks/view/' . $taskId);
    }
    
    /**
     * Add comment to task
     */
    public function addComment($taskId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Check if user has access to this task
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager']) && 
            $task['assigned_to'] != $currentUser['id']) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = trim($_POST['comment'] ?? '');
            
            if (!empty($comment)) {
                if ($this->taskModel->addComment($taskId, $currentUser['id'], $comment)) {
                    $this->logActivity('add_comment', 'task', $taskId);
                    $_SESSION['success_message'] = 'Komentar berhasil ditambahkan.';
                } else {
                    $_SESSION['error_message'] = 'Gagal menambahkan komentar.';
                }
            } else {
                $_SESSION['error_message'] = 'Komentar tidak boleh kosong.';
            }
        }
        
        $this->redirect('/tasks/view/' . $taskId);
    }
    
    /**
     * Edit comment in task
     */
    public function editComment($taskId, $commentId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) { 
            $this->redirect('/tasks'); 
        }
        
        $currentUser = $this->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentText = trim($_POST['comment'] ?? '');
            
            if ($commentText === '') {
                $_SESSION['error_message'] = 'Komentar tidak boleh kosong.';
                $this->redirect('/tasks/view/' . $taskId);
                return;
            }
            
            // Check for profanity in comment
            require_once ROOT_PATH . '/app/helpers/ProfanityFilter.php';
            
            if (ProfanityFilter::containsProfanity($commentText)) {
                $_SESSION['error_message'] = 'Komentar Anda mengandung kata-kata yang tidak pantas. Silakan gunakan bahasa yang sopan.';
                $this->redirect('/tasks/view/' . $taskId);
                return;
            }
            
            // Get the current comment to save original text
            $stmt = $this->db->prepare("SELECT comment, original_comment FROM task_comments WHERE id = ? AND task_id = ?");
            $stmt->execute([$commentId, $taskId]);
            $currentComment = $stmt->fetch();
            
            if (!$currentComment) {
                $_SESSION['error_message'] = 'Komentar tidak ditemukan.';
                $this->redirect('/tasks/view/' . $taskId);
                return;
            }
            
            // Check if comment is already deleted
            $checkDeleted = $this->db->prepare("SELECT is_deleted FROM task_comments WHERE id = ?");
            $checkDeleted->execute([$commentId]);
            $isDeleted = $checkDeleted->fetchColumn();
            
            if ($isDeleted) {
                $_SESSION['error_message'] = 'Tidak dapat mengedit komentar yang telah dihapus.';
                $this->redirect('/tasks/view/' . $taskId);
                return;
            }
            
            // If this is the first edit, save the original comment
            $originalComment = $currentComment['original_comment'] ?? null;
            if ($originalComment === null) {
                $originalComment = $currentComment['comment'];
            }
            
            // Update the comment with edit tracking
            $stmt = $this->db->prepare("
                UPDATE task_comments 
                SET comment = ?, 
                    original_comment = ?, 
                    is_edited = 1, 
                    edited_at = NOW(),
                    edited_by = ?
                WHERE id = ? AND task_id = ?
            ");
            
            $result = $stmt->execute([$commentText, $originalComment, $currentUser['id'], $commentId, $taskId]);
            
            if ($result) {
                $this->logActivity('edit_task_comment', 'task', $taskId, ['comment_id' => $commentId]);
                $_SESSION['success_message'] = 'Komentar berhasil diperbarui.';
            } else {
                $_SESSION['error_message'] = 'Gagal memperbarui komentar.';
            }
        }
        
        $this->redirect('/tasks/view/' . $taskId);
    }
    
    /**
     * Delete comment from task
     */
    public function deleteComment($taskId, $commentId) {
        $task = $this->taskModel->findById($taskId);
        if (!$task) {
            $this->redirect('/tasks');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Only super admin and project manager can delete comments
        if (!in_array($currentUser['role'], ['super_admin', 'project_manager'])) {
            $_SESSION['error_message'] = 'Anda tidak memiliki izin untuk menghapus komentar.';
            $this->redirect('/tasks/view/' . $taskId);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $confirm = $_POST['confirm'] ?? '';
            
            if ($confirm === 'yes') {
                // Soft delete the comment
                $stmt = $this->db->prepare("UPDATE task_comments SET is_deleted = 1, deleted_at = NOW(), deleted_by = ? WHERE id = ? AND task_id = ?");
                $result = $stmt->execute([$currentUser['id'], $commentId, $taskId]);
                
                if ($result) {
                    $this->logActivity('delete_comment', 'task', $taskId, ['comment_id' => $commentId]);
                    $_SESSION['success_message'] = 'Komentar berhasil dihapus.';
                } else {
                    $_SESSION['error_message'] = 'Gagal menghapus komentar.';
                }
            }
        }
        
        $this->redirect('/tasks/view/' . $taskId);
    }
    
    /**
     * View deleted comments history
     */
    public function deletedComments() {
        $currentUser = $this->getCurrentUser();
        
        // Only super admin and project manager can view deleted comments
        if (!in_array($currentUser['role'], ['super_admin', 'project_manager'])) {
            $this->redirect('/tasks');
        }
        
        // Get all deleted comments with details
        $sql = "SELECT tc.*, 
                       u.full_name, u.username, u.profile_photo,
                       deleted_user.username as deleted_by_username,
                       deleted_user.full_name as deleted_by_name,
                       t.title as task_title,
                       t.id as task_id,
                       p.name as project_name
                FROM task_comments tc
                LEFT JOIN users u ON tc.user_id = u.id
                LEFT JOIN users deleted_user ON tc.deleted_by = deleted_user.id
                LEFT JOIN tasks t ON tc.task_id = t.id
                LEFT JOIN projects p ON t.project_id = p.id
                WHERE tc.is_deleted = 1
                ORDER BY tc.deleted_at DESC";
        
        $stmt = $this->db->query($sql);
        $deletedComments = $stmt->fetchAll();
        
        $this->view('tasks/deleted_comments', [
            'deletedComments' => $deletedComments,
            'currentUser' => $currentUser,
            'pageTitle' => 'History Komentar Dihapus'
        ]);
    }
    
    /**
     * Restore deleted comment
     */
    public function restoreComment($taskId, $commentId) {
        $currentUser = $this->getCurrentUser();
        
        // Only super admin and project manager can restore comments
        if (!in_array($currentUser['role'], ['super_admin', 'project_manager'])) {
            $_SESSION['error_message'] = 'Anda tidak memiliki izin untuk mengembalikan komentar.';
            $this->redirect('/tasks/view/' . $taskId);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $confirm = $_POST['confirm'] ?? '';
            
            if ($confirm === 'yes') {
                // Restore the comment
                $stmt = $this->db->prepare("UPDATE task_comments SET is_deleted = 0, deleted_at = NULL, deleted_by = NULL WHERE id = ? AND task_id = ?");
                $result = $stmt->execute([$commentId, $taskId]);
                
                if ($result) {
                    $this->logActivity('restore_comment', 'task', $taskId, ['comment_id' => $commentId]);
                    $_SESSION['success_message'] = 'Komentar berhasil dikembalikan.';
                } else {
                    $_SESSION['error_message'] = 'Gagal mengembalikan komentar.';
                }
            }
        }
        
        $this->redirect('/tasks/view/' . $taskId);
    }

    /**
     * Create subtask
     */
    public function createSubTask($parentTaskId) {
        $parentTask = $this->taskModel->findById($parentTaskId);
        if (!$parentTask) {
            $this->redirect('/tasks');
        }
        
        $currentUser = $this->getCurrentUser();
        
        // Only Project Managers, Super Admin, and Admin can create subtasks
        if (!in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])) {
            $this->redirect('/tasks');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'project_id' => $parentTask['project_id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'assigned_to' => $_POST['assigned_to'],
                'created_by' => $currentUser['id'],
                'reporter_id' => $currentUser['id'],
                'task_type' => $_POST['task_type'] ?? 'feature',
                'tags' => $_POST['tags'] ?? '',
                'parent_task_id' => $parentTaskId,
                'visibility' => 'project',
                'status' => 'to_do',
                'priority' => $_POST['priority'],
                'due_date' => $_POST['due_date'] ?? null,
                'estimated_hours' => $_POST['estimated_hours'] ?? 0
            ];
            
            $errors = $this->validate($_POST, [
                'title' => 'required|max:200',
                'description' => 'required',
                'assigned_to' => 'required',
                'priority' => 'required'
            ]);
            
            if (empty($errors)) {
                $taskId = $this->taskModel->createTask($data);
                
                if ($taskId) {
                    $this->logActivity('create_subtask', 'task', $taskId, ['parent_task_id' => $parentTaskId]);
                    $_SESSION['success_message'] = 'Subtask berhasil dibuat.';
                    $this->redirect('/tasks/view/' . $parentTaskId);
                } else {
                    $errors['general'] = 'Failed to create subtask';
                }
            }
        }
        
        // Get users for assignment
        $userModel = new User($this->db);
        $users = $userModel->findAll();
        
        $this->view('tasks/create_subtask', [
            'parentTask' => $parentTask,
            'users' => $users,
            'currentUser' => $currentUser,
            'errors' => $errors ?? [],
            'pageTitle' => 'Create Subtask'
        ]);
    }
}
?>