<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
/* Dark mode styling for Bugs table */
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .table { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table thead { background-color: #0f172a; color: #e2e8f0; }
body.dark-mode .table tbody tr:nth-child(even) { background-color: #253041; }
body.dark-mode .table tbody tr:nth-child(odd) { background-color: #1f2a3a; }
body.dark-mode .table > :not(caption) > * > * { background-color: transparent !important; color: #e2e8f0; }
body.dark-mode .table tbody tr:hover { background-color: #2a3649 !important; }
body.dark-mode .text-muted { color: #94a3b8 !important; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark"><?php _e('bugs.title'); ?></h1>
        <p class="text-muted mb-0">
            <?php 
            $role = $currentUser['role'] ?? '';
            if ($role === 'developer') {
                echo __('bugs.subtitle_developer');
            } elseif ($role === 'qa_tester') {
                echo __('bugs.subtitle_qa');
            } elseif ($role === 'project_manager') {
                echo __('bugs.subtitle_pm');
            } else {
                echo __('bugs.subtitle');
            }
            ?>
        </p>
    </div>
    <?php if (in_array($role, ['qa_tester', 'project_manager', 'admin', 'super_admin'])): ?>
    <a href="index.php?url=bugs/create" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i><?php _e('bugs.report_bug'); ?>
    </a>
    <?php endif; ?>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-bug fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1"><?php _e('bugs.total_bugs'); ?></h6>
                <div class="h4 mb-0 text-primary"><?php echo $stats['total_bugs'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1"><?php _e('bugs.open_bugs'); ?></h6>
                <div class="h4 mb-0 text-primary"><?php echo ($stats['new_bugs'] ?? 0) + ($stats['assigned_bugs'] ?? 0) + ($stats['progress_bugs'] ?? 0); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-fire fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1"><?php _e('bugs.critical_bugs'); ?></h6>
                <div class="h4 mb-0 text-primary"><?php echo $stats['critical_bugs'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1"><?php _e('bugs.resolved'); ?></h6>
                <div class="h4 mb-0 text-primary"><?php echo $stats['resolved_bugs'] ?? 0; ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-list me-2 text-muted"></i>
            <?php _e('bugs.list_title'); ?>
        </h5>
    </div>
    <div class="card-body">
        <?php if (in_array(($currentUser['role'] ?? ''), ['developer', 'qa_tester'])): ?>
        <form class="row g-2 mb-3" method="GET" action="">
            <input type="hidden" name="url" value="bugs">
            <div class="col-auto">
                <select class="form-select form-select-sm" name="status">
                    <?php $sel = $selectedStatus ?? ''; ?>
                    <option value="">All Status</option>
                    <option value="new" <?php echo $sel==='new'?'selected':''; ?>>New</option>
                    <option value="assigned" <?php echo $sel==='assigned'?'selected':''; ?>>Assigned</option>
                    <option value="in_progress" <?php echo $sel==='in_progress'?'selected':''; ?>>In Progress</option>
                    <option value="resolved" <?php echo $sel==='resolved'?'selected':''; ?>>Resolved</option>
                    <option value="closed" <?php echo $sel==='closed'?'selected':''; ?>>Closed</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-outline-primary" type="submit"><i class="fas fa-filter me-1"></i>Filter</button>
            </div>
        </form>
        <?php endif; ?>
        <?php if (empty($bugs)): ?>
            <div class="text-center py-4">
                <i class="fas fa-bug fa-3x text-muted mb-3"></i>
                <h5><?php _e('bugs.empty_title'); ?></h5>
                <p class="text-muted">
                    <?php 
                    $role = $currentUser['role'] ?? '';
                    if ($role === 'developer') {
                        echo __('bugs.empty_desc_developer');
                    } elseif ($role === 'qa_tester') {
                        echo __('bugs.empty_desc_qa');
                    } elseif ($role === 'project_manager') {
                        echo __('bugs.empty_desc_pm');
                    } else {
                        echo __('bugs.empty_desc');
                    }
                    ?>
                </p>
                <?php if (in_array($role, ['qa_tester', 'project_manager', 'admin', 'super_admin'])): ?>
                <a href="index.php?url=bugs/create" class="btn btn-primary"><?php _e('bugs.report_bug'); ?></a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php _e('bugs.th_report'); ?></th>
                            <th><?php _e('bugs.th_project'); ?></th>
                            <th><?php _e('bugs.th_category'); ?></th>
                            <th><?php _e('bugs.th_severity'); ?></th>
                            <th><?php _e('bugs.th_priority'); ?></th>
                            <th><?php _e('bugs.th_status'); ?></th>
                            <th><?php _e('bugs.th_reported_by'); ?></th>
                            <th><?php _e('bugs.th_actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bugs as $bug): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bug me-2 text-danger"></i>
                                    <div>
                                        <strong><?php echo htmlspecialchars($bug['title']); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo substr(htmlspecialchars($bug['description']), 0, 50) . '...'; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($bug['project_name'] ?? __('bugs.no_project')); ?></td>
                            <td><?php echo htmlspecialchars($bug['category_name'] ?? __('bugs.uncategorized')); ?></td>
                            <td>
                                <?php
                                $severityColors = [
                                    'low' => 'success',
                                    'minor' => 'info',
                                    'major' => 'warning',
                                    'critical' => 'danger'
                                ];
                                $color = $severityColors[$bug['severity']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $color; ?>">
                                    <?php echo ucfirst($bug['severity']); ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $priorityColors = [
                                    'low' => 'success',
                                    'medium' => 'warning',
                                    'high' => 'danger',
                                    'urgent' => 'dark'
                                ];
                                $color = $priorityColors[$bug['priority']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $color; ?>">
                                    <?php echo ucfirst($bug['priority']); ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $statusColors = [
                                    'new' => 'primary',
                                    'assigned' => 'info',
                                    'in_progress' => 'warning',
                                    'resolved' => 'success',
                                    'closed' => 'secondary'
                                ];
                                $color = $statusColors[$bug['status']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $color; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $bug['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($bug['reported_by_name'] ?? __('bugs.unknown')); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?url=bugs/view/<?php echo $bug['id']; ?>" 
                                       class="btn btn-outline-primary" title="<?php echo __('common.view'); ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (in_array($currentUser['role'], ['super_admin','admin','project_manager','qa_tester'])): ?>
                                    <a href="index.php?url=bugs/edit/<?php echo $bug['id']; ?>"
                                       class="btn btn-outline-secondary" title="<?php echo __('common.edit'); ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (in_array($currentUser['role'], ['super_admin','admin','project_manager'])): ?>
                                    <button type="button" class="btn btn-outline-danger" title="<?php echo __('common.delete'); ?>"
                                            onclick="confirmDeleteBug(<?php echo $bug['id']; ?>, '<?php echo addslashes($bug['title']); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($currentUser['role'] === 'project_manager' && $bug['status'] === 'new'): ?>
                                    <button class="btn btn-outline-success btn-sm" title="Assign Bug" 
                                            onclick="showAssignModal(<?php echo $bug['id']; ?>, '<?php echo addslashes($bug['title']); ?>')">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
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

<!-- Assign Bug Modal -->
<div class="modal fade" id="assignBugModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Bug</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="assignBugForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Bug Title</label>
                        <input type="text" class="form-control" id="bugTitle" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign to Developer</label>
                        <select name="assigned_to" class="form-select" required>
                            <option value="">Select Developer</option>
                            <?php 
                            $developers = $this->userModel->findBy('role', 'developer');
                            foreach ($developers as $dev): ?>
                                <option value="<?php echo $dev['id']; ?>"><?php echo htmlspecialchars($dev['full_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Bug</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBugModal" tabindex="-1" aria-labelledby="deleteBugModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteBugModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Bug
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-2x fa-md-3x text-danger mb-3"></i>
                    <h6>Apakah Anda yakin ingin menghapus bug ini?</h6>
                    <p class="text-muted mb-3">Bug: <strong id="bugNameToDelete"></strong></p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Semua data terkait bug akan terhapus.
                    </div>
                </div>
            </div>
            <div class="modal-footer p-3 p-md-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBugBtn">
                        <i class="fas fa-trash me-1"></i>Ya, Hapus Bug
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let bugIdToDelete = null;

function confirmDeleteBug(bugId, bugName) {
    bugIdToDelete = bugId;
    document.getElementById('bugNameToDelete').textContent = bugName;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteBugModal'));
    deleteModal.show();
}

document.getElementById('confirmDeleteBugBtn').addEventListener('click', function() {
    if (bugIdToDelete) {
        // Show loading state
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...';
        this.disabled = true;
        
        // Redirect to delete endpoint
        window.location.href = `index.php?url=bugs/delete/${bugIdToDelete}`;
    }
});

function showAssignModal(bugId, bugTitle) {
    document.getElementById('bugTitle').value = bugTitle;
    document.getElementById('assignBugForm').action = 'index.php?url=bugs/assign/' + bugId;
    new bootstrap.Modal(document.getElementById('assignBugModal')).show();
}
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>