<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
/* Dark mode table styling for Projects page */
body.dark-mode .card {
    background-color: #334155;
    border-color: #475569;
}

body.dark-mode .card-header {
    background-color: #475569 !important;
    border-color: #64748b !important;
}

body.dark-mode .table {
    background-color: #1f2a3a !important;
    color: #e2e8f0 !important;
}

body.dark-mode .table thead.table-dark {
    background-color: #0f172a !important;
}

body.dark-mode .table tbody,
body.dark-mode .table tbody tr,
body.dark-mode .table tbody tr td {
    background-color: transparent !important;
    color: #ffffff !important; /* Increased contrast for better visibility */
}

body.dark-mode .table tbody tr:nth-child(even) { background-color: #253041 !important; }
body.dark-mode .table tbody tr:nth-child(odd) { background-color: #1f2a3a !important; }

body.dark-mode .text-muted { color: #cbd5e1 !important; } /* Brighter text for better contrast */

/* Dark mode hover for project table rows */
body.dark-mode .table tbody tr:hover { background-color: #2a3649 !important; }

/* Additional dark mode text improvements */
body.dark-mode .table tbody tr td strong {
    color: #ffffff !important; /* Make strong text white for better contrast */
}

body.dark-mode .table tbody tr td small {
    color: #cbd5e1 !important; /* Brighter small text */
}

body.dark-mode .table tbody tr td div small {
    color: #cbd5e1 !important; /* Brighter description text */
}

/* Dark mode for project item cards */
body.dark-mode .project-item {
    background-color: #334155 !important;
    border-color: #475569 !important;
    color: #ffffff !important;
}

body.dark-mode .project-item h6 {
    color: #ffffff !important;
}

body.dark-mode .project-item small {
    color: #cbd5e1 !important;
}

/* Modern Modal Styles */
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.modal-content {
    border-radius: 16px;
    overflow: hidden;
}

.modal-header {
    padding: 2rem 2rem 1.5rem 2rem;
}

.avatar-lg {
    width: 60px;
    height: 60px;
}

.btn-lg {
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
}

.btn-light:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Dark mode modal styles */
body.dark-mode .modal-content {
    background-color: #1e293b;
    color: #e2e8f0;
}

body.dark-mode .modal-body .bg-light {
    background-color: #334155 !important;
}

body.dark-mode .text-muted {
    color: #94a3b8 !important;
}

body.dark-mode .btn-light {
    background-color: #475569;
    border-color: #64748b;
    color: #e2e8f0;
}

body.dark-mode .btn-light:hover {
    background-color: #64748b;
    border-color: #64748b;
    color: #e2e8f0;
}

body.dark-mode .form-control {
    background-color: #475569;
    border-color: #64748b;
    color: #e2e8f0;
}

body.dark-mode .form-control:focus {
    background-color: #475569;
    border-color: #0ea5e9;
    color: #e2e8f0;
    box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.25);
}

body.dark-mode .form-control.is-valid {
    border-color: #10b981;
    background-color: #475569;
}

body.dark-mode .form-control.is-invalid {
    border-color: #ef4444;
    background-color: #475569;
}

body.dark-mode .form-text {
    color: #94a3b8 !important;
}

body.dark-mode .alert-danger {
    background-color: rgba(239, 68, 68, 0.2);
    border-color: #ef4444;
    color: #fca5a5;
}
</style>

<!-- Projects Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0 flex-grow-1">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
            <div class="mb-2 mb-md-0">
                <h1 class="h2 mb-0 text-dark"><?php _e('projects.title'); ?></h1>
                <p class="text-muted mb-0"><?php _e('projects.subtitle'); ?></p>
            </div>
            <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
            <div class="ms-md-3">
                <a href="index.php?url=projects/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i><?php _e('projects.new_project'); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-project-diagram fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1 small"><?php _e('projects.total_projects'); ?></h6>
                <div class="h4 mb-0 text-primary"><?php echo count($projects); ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-play-circle fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1 small">Proyek Aktif</h6>
                <div class="h4 mb-0 text-primary">
                    <?php echo count(array_filter($projects, function($p) { return $p['status'] === 'in_progress'; })); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1 small">Selesai</h6>
                <div class="h4 mb-0 text-primary">
                    <?php echo count(array_filter($projects, function($p) { return $p['status'] === 'completed'; })); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
        <div class="card bg-light border-0 h-100">
            <div class="card-body text-center p-3 p-md-4">
                <i class="fas fa-pause-circle fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1 small">Ditahan</h6>
                <div class="h4 mb-0 text-primary">
                    <?php echo count(array_filter($projects, function($p) { return $p['status'] === 'on_hold'; })); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-list me-2 text-muted"></i>
            Daftar Proyek
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($projects)): ?>
            <div class="text-center py-4">
                <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                <h5>Tidak Ada Proyek</h5>
                <p class="text-muted">Mulai dengan membuat proyek pertama Anda.</p>
                <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
                <a href="index.php?url=projects/create" class="btn btn-primary">Buat Proyek</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="color: white;">Nama Proyek</th>
                            <th style="color: white;">Klien</th>
                            <th style="color: white;">Manajer</th>
                            <th style="color: white;">Status</th>
                            <th style="color: white;">Tugas</th>
                            <th style="color: white;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                        <?php foreach ($projects as $project): ?>
                        <tr style="background-color: white;">
                            <td data-label="Nama Proyek" style="color: #333; font-weight: 500;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-project-diagram me-2 text-primary"></i>
                                    <div>
                                        <strong style="color: #2c3e50;"><?php echo htmlspecialchars($project['name']); ?></strong>
                                        <br>
                                        <small style="color: #6c757d;"><?php echo substr(htmlspecialchars($project['description']), 0, 50) . '...'; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Klien" style="color: #495057; font-weight: 500;"><?php echo htmlspecialchars($project['client_name'] ?? 'Tidak Ada Klien'); ?></td>
                            <td data-label="Manajer" style="color: #495057; font-weight: 500;"><?php echo htmlspecialchars($project['manager_name'] ?? 'Tidak Ada Manajer'); ?></td>
                            
                            <td data-label="Status">
                                <?php 
                                $isCompleted = ($project['status'] ?? '') === 'completed';
                                $statusText = $isCompleted ? 'Selesai' : 'Belum Selesai';
                                $statusClass = $isCompleted ? 'bg-success' : 'bg-warning';
                                ?>
                                <span class="badge <?php echo $statusClass; ?>" style="font-weight: 500;">
                                    <?php echo $statusText; ?>
                                </span>
                            </td>
                            
                            <td data-label="Tugas">
                                <span class="badge bg-light text-dark border" style="font-weight: 500;">
                                    <?php echo $project['completed_tasks'] ?? 0; ?>/<?php echo $project['total_tasks'] ?? 0; ?>
                                </span>
                            </td>
                            <td data-label="Aksi">
                                <div class="btn-group btn-group-sm d-flex d-md-inline-flex" role="group">
                                    <a href="index.php?url=projects/view/<?php echo $project['id']; ?>" 
                                       class="btn btn-outline-info btn-sm" title="Lihat Proyek">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
                                    <a href="index.php?url=projects/edit/<?php echo $project['id']; ?>" 
                                       class="btn btn-outline-warning btn-sm" title="Edit Proyek">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm" 
                                            title="Hapus Proyek"
                                            onclick="confirmDeleteProject(<?php echo $project['id']; ?>, '<?php echo addslashes($project['name']); ?>')">
                                        <i class="fas fa-trash"></i>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-danger text-white">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="fas fa-trash-alt fa-lg text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="deleteProjectModalLabel">Hapus Proyek</h5>
                        <small class="text-white" style="opacity: 0.9;">Hapus proyek secara permanen dan semua data terkait</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-3">Ini akan menghapus proyek secara permanen dan sumber daya terkait seperti Tugas, Bug, dan penugasan QA.</h6>
                </div>
                
                <div class="mb-4">
                    <label for="confirmProjectName" class="form-label fw-semibold">
                        Untuk mengonfirmasi, ketik '<span id="projectNameConfirm" class="text-danger fw-bold"></span>'
                    </label>
                    <input type="text" class="form-control" id="confirmProjectName" placeholder="Ketik nama proyek untuk mengonfirmasi">
                    <div class="form-text text-muted">Anda harus mengetik nama proyek yang tepat untuk melanjutkan.</div>
                </div>
                
                <div class="mb-4">
                    <label for="confirmDeleteText" class="form-label fw-semibold">
                        Untuk mengonfirmasi, ketik 'hapus proyek saya'
                    </label>
                    <input type="text" class="form-control" id="confirmDeleteText" placeholder="Ketik 'hapus proyek saya' untuk mengonfirmasi">
                    <div class="form-text text-muted">Ini adalah langkah konfirmasi tambahan.</div>
                </div>
                
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>Peringatan:</strong> Menghapus <span id="projectNameWarning" class="fw-bold"></span> tidak dapat dibatalkan.
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100">
                    <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal" id="cancelDeleteBtn">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger btn-lg px-4" id="confirmDeleteBtn" disabled>
                        <i class="fas fa-trash-alt me-2"></i>Hapus Proyek
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let projectIdToDelete = null;
let projectNameToDelete = null;

function confirmDeleteProject(projectId, projectName) {
    projectIdToDelete = projectId;
    projectNameToDelete = projectName;
    
    // Set project name in modal
    document.getElementById('projectNameConfirm').textContent = projectName;
    document.getElementById('projectNameWarning').textContent = projectName;
    
    // Clear previous inputs
    document.getElementById('confirmProjectName').value = '';
    document.getElementById('confirmDeleteText').value = '';
    document.getElementById('confirmDeleteBtn').disabled = true;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteProjectModal'));
    deleteModal.show();
}

// Validation function
function validateDeleteInputs() {
    const projectNameInput = document.getElementById('confirmProjectName').value.trim();
    const deleteTextInput = document.getElementById('confirmDeleteText').value.trim();
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    const isValidProjectName = projectNameInput === projectNameToDelete;
    const isValidDeleteText = deleteTextInput === 'hapus proyek saya';
    
    confirmBtn.disabled = !(isValidProjectName && isValidDeleteText);
    
    // Visual feedback
    const projectNameField = document.getElementById('confirmProjectName');
    const deleteTextField = document.getElementById('confirmDeleteText');
    
    if (projectNameInput && !isValidProjectName) {
        projectNameField.classList.add('is-invalid');
        projectNameField.classList.remove('is-valid');
    } else if (projectNameInput && isValidProjectName) {
        projectNameField.classList.add('is-valid');
        projectNameField.classList.remove('is-invalid');
    } else {
        projectNameField.classList.remove('is-valid', 'is-invalid');
    }
    
    if (deleteTextInput && !isValidDeleteText) {
        deleteTextField.classList.add('is-invalid');
        deleteTextField.classList.remove('is-valid');
    } else if (deleteTextInput && isValidDeleteText) {
        deleteTextField.classList.add('is-valid');
        deleteTextField.classList.remove('is-invalid');
    } else {
        deleteTextField.classList.remove('is-valid', 'is-invalid');
    }
}

// Event listeners
document.getElementById('confirmProjectName').addEventListener('input', validateDeleteInputs);
document.getElementById('confirmDeleteText').addEventListener('input', validateDeleteInputs);

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (projectIdToDelete) {
        // Double check validation
        const projectNameInput = document.getElementById('confirmProjectName').value.trim();
        const deleteTextInput = document.getElementById('confirmDeleteText').value.trim();
        
        if (projectNameInput !== projectNameToDelete || deleteTextInput !== 'hapus proyek saya') {
            alert('Silakan lengkapi kedua field konfirmasi dengan benar.');
            return;
        }
        
        // Show loading state
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
        this.disabled = true;
        
        // Redirect to delete endpoint
        window.location.href = `index.php?url=projects/delete/${projectIdToDelete}`;
    }
});

// Reset modal when closed
document.getElementById('deleteProjectModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('confirmProjectName').value = '';
    document.getElementById('confirmDeleteText').value = '';
    document.getElementById('confirmProjectName').classList.remove('is-valid', 'is-invalid');
    document.getElementById('confirmDeleteText').classList.remove('is-valid', 'is-invalid');
    document.getElementById('confirmDeleteBtn').disabled = true;
    projectIdToDelete = null;
    projectNameToDelete = null;
});
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>