<?php
class ProjectController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }
    
    public function index() {
        $currentUser = $this->getCurrentUser();
        
        if (in_array($currentUser['role'], ['super_admin', 'admin'])) {
            // Super admin dan admin bisa lihat semua project
            $projects = $this->projectModel->getAllWithDetails();
        } else {
            // Project manager, developer, qa_tester, dan client hanya lihat project yang assigned ke mereka
            $projects = $this->projectModel->getUserProjects($currentUser['id']);
        }
        
        $this->view('projects/index', [
            'projects' => $projects,
            'pageTitle' => 'Projects',
            'currentUser' => $currentUser
        ]);
    }
    
    public function viewProject($projectId) {
        $project = $this->projectModel->findById($projectId);
        if (!$project) {
            $this->redirect('/projects');
        }
        
        // Check if user has access to this project
        $currentUser = $this->getCurrentUser();
        if (!in_array($currentUser['role'], ['super_admin', 'admin']) && $project['project_manager_id'] != $currentUser['id']) {
            // Check if user is team member
            $teamMembers = $this->projectModel->getTeamMembers($projectId);
            $hasAccess = false;
            foreach ($teamMembers as $member) {
                if ($member['user_id'] == $currentUser['id']) {
                    $hasAccess = true;
                    break;
                }
            }
            if (!$hasAccess) {
                $this->redirect('/projects');
            }
        }
        
        $stats = $this->projectModel->getProjectStats($projectId);
        $teamMembers = $this->projectModel->getTeamMembers($projectId);
        $tasks = $this->taskModel->getProjectTasks($projectId);
        
        // Get project manager data
        $projectManager = null;
        if (!empty($project['project_manager_id'])) {
            $projectManager = $this->userModel->findById($project['project_manager_id']);
        }
        
        $this->view('projects/view', [
            'project' => $project,
            'projectManager' => $projectManager,
            'stats' => $stats,
            'teamMembers' => $teamMembers,
            'tasks' => $tasks,
            'pageTitle' => $project['name']
        ]);
    }
    
    public function create() {
        $this->requireRole(['super_admin', 'admin', 'project_manager']);
        
        // Additional check for Developer and QA Tester
        $currentUser = $this->getCurrentUser();
        if (in_array($currentUser['role'], ['developer', 'qa_tester'])) {
            $this->redirect('/projects');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                // client handled below via free-text name
                'client_id' => null,
                'project_manager_id' => null, // Will be set from current user
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date']
            ];
            
            $errors = $this->validate($_POST, [
                'name' => 'required|max:100',
                'description' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date'
            ]);
            
            // Validate additional team members (optional)
            if (!empty($_POST['team_members']) && is_array($_POST['team_members'])) {
                $allowedRoles = ['developer', 'qa_tester', 'project_manager'];
                foreach ($_POST['team_members'] as $member) {
                    if (empty($member['user_id']) || empty($member['role'])) {
                        $errors['team_members'] = 'All team members must have user and role selected';
                        break;
                    }
                    if (!in_array($member['role'], $allowedRoles)) {
                        $errors['team_members'] = 'Invalid role selected. Only Developer, QA Tester, and Project Manager are allowed.';
                        break;
                    }
                }
            }
            
            // For create operation, current user is automatically project manager
            // No need to validate project manager requirement for create
            
            if (empty($errors)) {
                // Map client_name (free text) to client_id (create if not exists)
                $clientName = trim($_POST['client_name'] ?? '');
                if ($clientName !== '') {
                    $existing = $this->clientModel->findBy('company_name', $clientName);
                    if (!empty($existing)) {
                        $data['client_id'] = $existing[0]['id'];
                    } else {
                        $newClientId = $this->clientModel->create([
                            'company_name' => $clientName,
                            'contact_person' => $clientName,
                            'email' => strtolower(preg_replace('/\s+/', '', $clientName)) . '@example.com',
                            'phone' => null,
                            'address' => null
                        ]);
                        if ($newClientId) {
                            $data['client_id'] = $newClientId;
                        }
                    }
                }
                
                // Set current user as primary project manager
                $currentUser = $this->getCurrentUser();
                $data['project_manager_id'] = $currentUser['id'];
                
                // Prepare team members data - add current user as project manager first
                $teamMembers = [];
                $teamMembers[] = [
                    'user_id' => $currentUser['id'],
                    'role' => 'project_manager'
                ];
                
                // Add additional team members if any
                if (!empty($_POST['team_members'])) {
                    foreach ($_POST['team_members'] as $member) {
                        // Skip if same as current user (already added)
                        if ($member['user_id'] != $currentUser['id']) {
                            $teamMembers[] = $member;
                        }
                    }
                }
                
                $projectId = $this->projectModel->createProject($data, $teamMembers);
                
                if ($projectId) {
                    $this->logActivity('create_project', 'project', $projectId);
                    $this->redirect('/projects/view/' . $projectId);
                } else {
                    $errors['general'] = 'Failed to create project';
                }
            }
        }
        
        // Get all users for team selection
        $allUsers = $this->userModel->findAll();
        
        // Auto-select current user if they are a project manager
        $currentUser = $this->getCurrentUser();
        $autoSelectedManagerId = null;
        if ($currentUser && $currentUser['role'] === 'project_manager') {
            $autoSelectedManagerId = $currentUser['id'];
        }
        
        $this->view('projects/create', [
            'allUsers' => $allUsers,
            'currentUser' => $currentUser,
            'autoSelectedManagerId' => $autoSelectedManagerId,
            'errors' => $errors ?? [],
            'pageTitle' => 'Create Project'
        ]);
    }
    
    public function edit($projectId) {
        $this->requireRole(['super_admin', 'admin', 'project_manager']);
        
        // Additional check for Developer and QA Tester
        $currentUser = $this->getCurrentUser();
        if (in_array($currentUser['role'], ['developer', 'qa_tester'])) {
            $this->redirect('/projects');
        }
        
        $project = $this->projectModel->findById($projectId);
        if (!$project) {
            $this->redirect('/projects');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'client_id' => null,
                'project_manager_id' => null, // Will be set from team members
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date']
            ];
            
            $errors = $this->validate($_POST, [
                'name' => 'required|max:100',
                'description' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date'
            ]);
            
            // Validate additional team members (optional)
            if (!empty($_POST['team_members']) && is_array($_POST['team_members'])) {
                $allowedRoles = ['developer', 'qa_tester', 'project_manager'];
                foreach ($_POST['team_members'] as $member) {
                    if (empty($member['user_id']) || empty($member['role'])) {
                        $errors['team_members'] = 'All team members must have user and role selected';
                        break;
                    }
                    if (!in_array($member['role'], $allowedRoles)) {
                        $errors['team_members'] = 'Invalid role selected. Only Developer, QA Tester, and Project Manager are allowed.';
                        break;
                    }
                }
            }
            
            // Validate that at least one project manager is assigned
            $hasProjectManager = false;
            if (!empty($_POST['team_members']) && is_array($_POST['team_members'])) {
                foreach ($_POST['team_members'] as $member) {
                    if ($member['role'] === 'project_manager') {
                        $hasProjectManager = true;
                        break;
                    }
                }
            }
            
            // Validate that at least one project manager is assigned
            $hasProjectManager = false;
            if (!empty($_POST['team_members']) && is_array($_POST['team_members'])) {
                foreach ($_POST['team_members'] as $member) {
                    if ($member['role'] === 'project_manager') {
                        $hasProjectManager = true;
                        break;
                    }
                }
            }
            
            // For edit operation, we must have at least one project manager
            if (!$hasProjectManager) {
                $errors['team_members'] = 'Setidaknya satu anggota tim harus ditetapkan sebagai Manajer Proyek.';
            }
            
            if (empty($errors)) {
                // Map/Upsert client by name
                $clientName = trim($_POST['client_name'] ?? '');
                if ($clientName !== '') {
                    $existing = $this->clientModel->findBy('company_name', $clientName);
                    if (!empty($existing)) {
                        $data['client_id'] = $existing[0]['id'];
                    } else {
                        $newClientId = $this->clientModel->create([
                            'company_name' => $clientName,
                            'contact_person' => $clientName,
                            'email' => strtolower(preg_replace('/\s+/', '', $clientName)) . '@example.com',
                            'phone' => null,
                            'address' => null
                        ]);
                        if ($newClientId) {
                            $data['client_id'] = $newClientId;
                        }
                    }
                } else {
                    $data['client_id'] = null;
                }
                
                // Set primary project manager (first project manager in team)
                foreach ($_POST['team_members'] as $member) {
                    if ($member['role'] === 'project_manager') {
                        $data['project_manager_id'] = $member['user_id'];
                        break;
                    }
                }
                
                // Prepare team members data
                $teamMembers = $_POST['team_members'];
                
                $success = $this->projectModel->updateProject($projectId, $data, $teamMembers);
                
                if ($success) {
                    $this->logActivity('update_project', 'project', $projectId);
                    $this->redirect('/projects/view/' . $projectId);
                } else {
                    $errors['general'] = 'Failed to update project';
                }
            }
        }
        
        // Get all users for team selection
        $allUsers = $this->userModel->findAll();
        
        // Get existing team members
        $existingTeamMembers = $this->projectModel->getTeamMembers($projectId);
        
        // Prefill client free-text
        $clientName = '';
        if (!empty($project['client_id'])) {
            $client = $this->clientModel->findById($project['client_id']);
            if ($client) { $clientName = $client['company_name']; }
        }
        
        // Get project manager data
        $projectManager = null;
        if (!empty($project['project_manager_id'])) {
            $projectManager = $this->userModel->findById($project['project_manager_id']);
        }
        
        $this->view('projects/edit', [
            'project' => $project,
            'projectManager' => $projectManager,
            'allUsers' => $allUsers,
            'existingTeamMembers' => $existingTeamMembers,
            'clientName' => $clientName,
            'errors' => $errors ?? [],
            'pageTitle' => 'Edit Project'
        ]);
    }
    
    public function delete($projectId) {
        $this->requireRole(['super_admin', 'admin', 'project_manager']);
        
        // Additional check for Developer and QA Tester
        $currentUser = $this->getCurrentUser();
        if (in_array($currentUser['role'], ['developer', 'qa_tester'])) {
            $this->redirect('/projects');
        }
        
        $project = $this->projectModel->findById($projectId);
        if (!$project) {
            $this->redirect('/projects');
        }
        
        try {
            // Delete related data first
            $this->db->beginTransaction();
            
            // Delete project tasks
            $this->taskModel->deleteByProject($projectId);
            
            // Delete project bugs
            $this->bugModel->deleteByProject($projectId);
            
            // Delete project test cases
            $this->testCaseModel->deleteByProject($projectId);
            
            // Delete project test suites
            $this->testSuiteModel->deleteByProject($projectId);
            
            // Delete project team assignments
            $stmt = $this->db->prepare("DELETE FROM project_teams WHERE project_id = ?");
            $stmt->execute([$projectId]);
            
            // Delete the project
            $success = $this->projectModel->delete($projectId);
            
            if ($success) {
                $this->logActivity('delete_project', 'project', $projectId);
                $this->db->commit();
                
                // Redirect with success message
                $_SESSION['success_message'] = 'Proyek "' . $project['name'] . '" berhasil dihapus.';
                $this->redirect('/projects');
            } else {
                $this->db->rollback();
                $_SESSION['error_message'] = 'Gagal menghapus proyek.';
                $this->redirect('/projects');
            }
            
        } catch (Exception $e) {
            $this->db->rollback();
            $_SESSION['error_message'] = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->redirect('/projects');
        }
    }

    public function complete($projectId) {
        $this->requireRole(['super_admin', 'admin', 'project_manager']);
        $project = $this->projectModel->findById($projectId);
        if (!$project) { $this->redirect('/projects'); }

        // Only PM of this project or admin roles can complete
        $currentUser = $this->getCurrentUser();
        if (!in_array($currentUser['role'], ['super_admin', 'admin']) && ($project['project_manager_id'] ?? null) != $currentUser['id']) {
            $this->redirect('/projects/view/' . $projectId);
        }

        // Check if there are any incomplete tasks
        $incompleteTasks = $this->taskModel->getProjectTasksByStatus($projectId, ['to_do', 'in_progress']);
        if (!empty($incompleteTasks)) {
            $_SESSION['error_message'] = 'Tidak dapat menyelesaikan proyek. Masih ada ' . count($incompleteTasks) . ' tugas yang belum selesai.';
            $this->redirect('/projects/view/' . $projectId);
        }

        $success = $this->projectModel->completeProject($projectId);
        if ($success) {
            $this->logActivity('complete_project', 'project', $projectId);
            $_SESSION['success_message'] = 'Proyek berhasil diselesaikan.';
        } else {
            $_SESSION['error_message'] = 'Gagal menyelesaikan proyek.';
        }
        $this->redirect('/projects/view/' . $projectId);
    }

    public function reopen($projectId) {
        $this->requireRole(['super_admin', 'admin', 'project_manager']);
        $project = $this->projectModel->findById($projectId);
        if (!$project) { $this->redirect('/projects'); }

        $currentUser = $this->getCurrentUser();
        if (!in_array($currentUser['role'], ['super_admin', 'admin']) && ($project['project_manager_id'] ?? null) != $currentUser['id']) {
            $this->redirect('/projects/view/' . $projectId);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reason = trim($_POST['reason'] ?? 'maintenance');
            $success = $this->projectModel->reopenProject($projectId);
            if ($success) {
                $this->logActivity('reopen_project', 'project', $projectId, ['status' => 'completed'], ['status' => 'in_progress', 'reason' => $reason]);
                $_SESSION['success_message'] = 'Proyek dibuka kembali (' . htmlspecialchars($reason) . ').';
            } else {
                $_SESSION['error_message'] = 'Gagal membuka kembali proyek.';
            }
            $this->redirect('/projects/view/' . $projectId);
        }

        // If GET, just redirect back
        $this->redirect('/projects/view/' . $projectId);
    }
}
?>