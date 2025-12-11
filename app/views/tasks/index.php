<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
.table tbody tr:hover {
    background-color: #f1f3f5 !important; /* soften hover in light mode */
}

.table tbody td {
    color: #212529 !important;
    font-weight: 500;
}

.table tbody td strong {
    color: #000 !important;
    font-weight: 600;
}

.table tbody td small {
    color: #6c757d !important;
}

.table thead th {
    color: #fff !important;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.badge {
    font-weight: 600;
    font-size: 0.75rem;
}

.btn-group .btn {
    border-width: 1px;
    font-weight: 500;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    background-color: #0d6efd;
    border-radius: 10px;
}

.table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.table tbody tr:nth-child(odd) {
    background-color: #fff;
}

/* Dark mode overrides for readability */
body.dark-mode .table tbody td {
    color: #e2e8f0 !important;
}

body.dark-mode .table tbody td strong {
    color: #ffffff !important;
}

body.dark-mode .table tbody td small {
    color: #cbd5e1 !important;
}

body.dark-mode .table tbody tr:nth-child(even) {
    background-color: #253041;
}

body.dark-mode .table tbody tr:nth-child(odd) {
    background-color: #1f2a3a;
}

/* Dark mode hover should be subtle, not bright */
body.dark-mode .table tbody tr:hover {
    background-color: #2a3649 !important;
}

/* Ensure table container and header fit dark mode */
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .table { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table thead.table-dark { background-color: #0f172a !important; }
body.dark-mode .text-muted { color: #94a3b8 !important; }

/* Override Bootstrap table cell backgrounds in dark mode */
body.dark-mode .table > :not(caption) > * > * {
    background-color: transparent !important;
    color: #e2e8f0 !important;
}

body.dark-mode .table tbody td {
    background-color: transparent !important;
}
</style>

<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['success_message']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['error_message']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0 flex-grow-1">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
            <div class="mb-2 mb-md-0">
                <h1 class="h2 mb-0 text-dark fw-bold"><?php _e('tasks.title'); ?></h1>
                <p class="text-muted mb-0 fw-medium">
                    <?php 
                    if ($currentUser['role'] === 'project_manager') {
                        echo 'Monitor and manage all tasks in your projects.';
                    } elseif ($currentUser['role'] === 'developer') {
                        echo 'View and work on your assigned tasks.';
                    } elseif ($currentUser['role'] === 'qa_tester') {
                        echo 'Review and test tasks in your assigned projects.';
                    } else {
                        echo _e('tasks.subtitle');
                    }
                    ?>
                </p>
            </div>
            <?php if (in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
            <div class="ms-md-3">
                <a href="index.php?url=tasks/create" class="btn btn-primary fw-bold">
                    <i class="fas fa-plus me-2"></i><?php _e('tasks.new_task'); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 shadow-sm h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                <h6 class="text-dark fw-bold mb-1 small"><?php _e('tasks.total_tasks'); ?></h6>
                <div class="h4 mb-0 text-primary fw-bold"><?php echo $stats['total_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 shadow-sm h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-list fa-2x text-primary mb-2"></i>
                <h6 class="text-dark fw-bold mb-1 small"><?php _e('tasks.todo_tasks'); ?></h6>
                <div class="h4 mb-0 text-primary fw-bold"><?php echo $stats['todo_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 shadow-sm h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-spinner fa-2x text-primary mb-2"></i>
                <h6 class="text-dark fw-bold mb-1 small">In Progress</h6>
                <div class="h4 mb-0 text-primary fw-bold"><?php echo $stats['progress_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 shadow-sm h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                <h6 class="text-dark fw-bold mb-1 small">Completed</h6>
                <div class="h4 mb-0 text-primary fw-bold"><?php echo $stats['done_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
</div>

        <div class="card shadow-sm">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i>
                    Task List
                </h5>
            </div>
            <div class="card-body p-0">
        <?php if (empty($tasks)): ?>
            <div class="text-center py-5 px-4">
                <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                <h5 class="text-dark fw-bold">No Tasks Found</h5>
                <p class="text-muted mb-4 fw-medium">
                    <?php 
                    if ($currentUser['role'] === 'project_manager') {
                        echo 'No tasks found in your projects. Create your first task to get started.';
                    } elseif ($currentUser['role'] === 'developer') {
                        echo 'No tasks assigned to you yet. Contact your project manager for task assignments.';
                    } elseif ($currentUser['role'] === 'qa_tester') {
                        echo 'No tasks found in your assigned projects. Tasks will appear here when developers complete their work.';
                    } else {
                        echo 'Start by creating your first task.';
                    }
                    ?>
                </p>
                <?php if (in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
                <a href="index.php?url=tasks/create" class="btn btn-primary btn-lg fw-bold">
                    <i class="fas fa-plus me-2"></i>Create Task
                </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="fw-bold"><?php _e('tasks.task'); ?></th>
                            <th class="fw-bold"><?php _e('tasks.project'); ?></th>
                            <th class="fw-bold">Assigned To</th>
                            <th class="fw-bold"><?php _e('tasks.status'); ?></th>
                            <th class="fw-bold"><?php _e('tasks.priority'); ?></th>
                            <th class="fw-bold">Status Pengerjaan</th>
                            <th class="fw-bold"><?php _e('tasks.due_date'); ?></th>
                            <th class="fw-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                        <tr class="align-middle border-bottom">
                            <td data-label="<?php _e('tasks.task'); ?>">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-task me-2 text-primary"></i>
                                    <div>
                                        <strong class="text-dark"><?php echo htmlspecialchars($task['title']); ?></strong>
                                        <br>
                                        <small class="text-secondary"><?php echo substr(htmlspecialchars($task['description']), 0, 50) . '...'; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td data-label="<?php _e('tasks.project'); ?>" class="text-dark fw-medium"><?php echo htmlspecialchars($task['project_name'] ?? 'No Project'); ?></td>
                            <td data-label="Assigned To" class="text-dark fw-medium"><?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Unassigned'); ?></td>
                            <td data-label="<?php _e('tasks.status'); ?>">
                                <?php
                                $statusColors = [
                                    'to_do' => 'secondary',
                                    'in_progress' => 'primary',
                                    'done' => 'success'
                                ];
                                $color = $statusColors[$task['status']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $color; ?> fw-bold">
                                    <?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?>
                                </span>
                            </td>
                            <td data-label="<?php _e('tasks.priority'); ?>">
                                <?php
                                $priorityColors = [
                                    'low' => 'success',
                                    'medium' => 'warning',
                                    'high' => 'danger',
                                    'critical' => 'dark'
                                ];
                                $color = $priorityColors[$task['priority']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $color; ?> fw-bold">
                                    <?php echo ucfirst($task['priority']); ?>
                                </span>
                            </td>
                            <td data-label="Status Pengerjaan" class="text-dark fw-medium">
                                <?php
                                // Map numeric progress or status into human-readable Indonesian text
                                $progressValue = isset($task['progress']) ? (float)$task['progress'] : null;
                                $statusText = '';
                                if (!is_null($progressValue)) {
                                    if ($progressValue <= 0) {
                                        $statusText = 'Belum mulai';
                                    } elseif ($progressValue >= 100) {
                                        $statusText = 'Selesai';
                                    } else {
                                        $statusText = 'Sedang dikerjakan';
                                    }
                                } else {
                                    // Fallback to status field
                                    $map = [
                                        'to_do' => 'Belum mulai',
                                        'in_progress' => 'Sedang dikerjakan',
                                        'done' => 'Selesai'
                                    ];
                                    $statusText = $map[$task['status']] ?? 'Sedang dikerjakan';
                                }
                                ?>
                                <span class="badge bg-info text-dark bg-opacity-10 border border-info fw-bold px-3 py-2">
                                    <?php echo $statusText; ?>
                                </span>
                            </td>
                            <td data-label="<?php _e('tasks.due_date'); ?>">
                                <?php if ($task['due_date']): ?>
                                    <?php 
                                    $dueDate = new DateTime($task['due_date']);
                                    $now = new DateTime();
                                    $isOverdue = $dueDate < $now && $task['status'] !== 'done';
                                    ?>
                                    <span class="<?php echo $isOverdue ? 'text-danger fw-bold' : 'text-dark fw-medium'; ?>">
                                        <?php echo $dueDate->format('M d, Y'); ?>
                                        <?php if ($isOverdue): ?>
                                            <i class="fas fa-exclamation-triangle ms-1"></i>
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-secondary fw-medium"><?php _e('tasks.no_due_date'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Actions">
                                <div class="btn-group btn-group-sm d-flex d-md-inline-flex">
                                    <a href="index.php?url=tasks/view/<?php echo $task['id']; ?>" 
                                       class="btn btn-outline-primary btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <?php if (in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
                                    <!-- Project Manager, Super Admin, Admin: Full access -->
                                    <a href="index.php?url=tasks/edit/<?php echo $task['id']; ?>" 
                                       class="btn btn-outline-secondary btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" title="Delete"
                                            onclick="confirmDeleteTask(<?php echo $task['id']; ?>, '<?php echo addslashes($task['title']); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <?php elseif ($currentUser['role'] === 'developer' && $task['assigned_to'] == $currentUser['id']): ?>
                                    <!-- Developer: Can edit only their assigned tasks -->
                                    <a href="index.php?url=tasks/edit/<?php echo $task['id']; ?>" 
                                       class="btn btn-outline-secondary btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <?php elseif ($currentUser['role'] === 'qa_tester'): ?>
                                    <!-- QA Tester: Can create bug report and verify tasks -->
                                    <?php if ($task['status'] === 'done'): ?>
                                    <a href="index.php?url=tasks/verify/<?php echo $task['id']; ?>" 
                                       class="btn btn-outline-success btn-sm" title="Verify Task">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="index.php?url=tasks/bug-report/<?php echo $task['id']; ?>" 
                                       class="btn btn-outline-warning btn-sm" title="Create Bug Report">
                                        <i class="fas fa-bug"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteTaskModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Tugas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-2x fa-md-3x text-danger mb-3"></i>
                    <h6>Apakah Anda yakin ingin menghapus tugas ini?</h6>
                    <p class="text-muted mb-3">Tugas: <strong id="taskNameToDelete"></strong></p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Semua data terkait tugas akan terhapus.
                    </div>
                </div>
            </div>
            <div class="modal-footer p-3 p-md-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteTaskBtn">
                        <i class="fas fa-trash me-1"></i>Ya, Hapus Tugas
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let taskIdToDelete = null;

function confirmDeleteTask(taskId, taskName) {
    taskIdToDelete = taskId;
    document.getElementById('taskNameToDelete').textContent = taskName;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteTaskModal'));
    deleteModal.show();
}

document.getElementById('confirmDeleteTaskBtn').addEventListener('click', function() {
    if (taskIdToDelete) {
        // Show loading state
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...';
        this.disabled = true;
        
        // Redirect to delete endpoint
        window.location.href = `index.php?url=tasks/delete/${taskIdToDelete}`;
    }
});
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>