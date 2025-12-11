<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
.avatar-sm img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #e9ecef;
}

[data-theme="dark"] .avatar-sm img {
    border-color: #495057;
}

[data-theme="dark"],
body.dark-mode {
    /* ensure base text contrast */
    color-scheme: dark;
}

/* Dark mode card/table overrides to avoid putih background */
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .bg-light { background-color: #334155 !important; }
body.dark-mode .text-dark { color: #e2e8f0 !important; }
body.dark-mode .text-muted { color: #94a3b8 !important; }
body.dark-mode .table { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table thead { background-color: #0f172a; color: #e2e8f0; }
body.dark-mode .table tbody tr:nth-child(even) { background-color: #253041; }
body.dark-mode .table tbody tr:nth-child(odd) { background-color: #1f2a3a; }
body.dark-mode .table > :not(caption) > * > * { background-color: transparent !important; color: #e2e8f0; }

.avatar-sm .bg-primary {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
}
</style>

<div class="content-wrapper">

<!-- Project Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?url=projects">Proyek</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($project['name']); ?></li>
            </ol>
        </nav>
        <h1 class="h2 mb-0 text-dark"><?php echo htmlspecialchars($project['name']); ?></h1>
        <p class="text-muted mb-0"><?php echo htmlspecialchars($project['description']); ?></p>
    </div>
    <div class="d-flex gap-2">
        <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
        <a href="index.php?url=projects/edit/<?php echo $project['id']; ?>" class="btn btn-outline-primary">
            <i class="fas fa-edit me-2"></i>Edit Proyek
        </a>
        <?php endif; ?>
        <a href="index.php?url=tasks/create?project_id=<?php echo $project['id']; ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Tugas
        </a>
        <?php 
            $canComplete = $currentUser && in_array($currentUser['role'], ['super_admin','admin','project_manager']);
            $isCompleted = ($project['status'] ?? '') === 'completed';
            
            // Check if there are incomplete tasks
            $incompleteTasksCount = 0;
            if (!$isCompleted) {
                foreach ($tasks as $task) {
                    if (in_array($task['status'], ['to_do', 'in_progress'])) {
                        $incompleteTasksCount++;
                    }
                }
            }
            $hasIncompleteTasks = $incompleteTasksCount > 0;
        ?>
        <?php if ($canComplete && !$isCompleted): ?>
            <?php if ($hasIncompleteTasks): ?>
                <button type="button" class="btn btn-success" disabled title="Tidak dapat menyelesaikan proyek. Masih ada <?php echo $incompleteTasksCount; ?> tugas yang belum selesai.">
                    <i class="fas fa-check me-2"></i>Selesaikan Proyek
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeProjectModal">
                    <i class="fas fa-check me-2"></i>Selesaikan Proyek
                </button>
            <?php endif; ?>
        <?php elseif ($canComplete && $isCompleted): ?>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reopenProjectModal">
            <i class="fas fa-undo me-2"></i>Buka Kembali
        </button>
        <?php endif; ?>
    </div>
</div>

<?php if ($hasIncompleteTasks && !$isCompleted): ?>
<div class="alert alert-warning mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Perhatian!</strong> Proyek tidak dapat diselesaikan karena masih ada <strong><?php echo $incompleteTasksCount; ?> tugas</strong> yang belum selesai. 
    Selesaikan semua tugas terlebih dahulu sebelum menandai proyek sebagai selesai.
</div>
<?php endif; ?>

<!-- Project Overview Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Total Tugas</h6>
                <div class="h4 mb-0 text-primary"><?php echo $stats['total_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h6 class="text-muted mb-1">Tertunda</h6>
                <div class="h4 mb-0 text-warning"><?php echo $stats['pending_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-spinner fa-2x text-info mb-2"></i>
                <h6 class="text-muted mb-1">Sedang Dikerjakan</h6>
                <div class="h4 mb-0 text-info"><?php echo $stats['active_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h6 class="text-muted mb-1">Selesai</h6>
                <div class="h4 mb-0 text-success"><?php echo $stats['completed_tasks'] ?? 0; ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Project Details -->
    <div class="col-md-8">
        <!-- Project Information -->
        <div class="card mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-info-circle me-2 text-muted"></i>
                    Informasi Proyek
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tanggal Mulai</label>
                            <div><?php echo date('M d, Y', strtotime($project['start_date'])); ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Tanggal Selesai</label>
                            <div><?php echo date('M d, Y', strtotime($project['end_date'])); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks -->
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-tasks me-2 text-muted"></i>
                        Tugas
                    </h5>
                    <a href="index.php?url=tasks/create?project_id=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Tugas
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($tasks)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                        <h5>Belum Ada Tugas</h5>
                        <p class="text-muted">Mulai dengan membuat tugas untuk proyek ini.</p>
                        <a href="index.php?url=tasks/create?project_id=<?php echo $project['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Tugas Pertama
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tugas</th>
                                    <th>Ditugaskan Ke</th>
                                    <th>Status</th>
                                    <th>Prioritas</th>
                                    <th>Batas Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td>
                                        <div>
                                            <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                                            <?php if ($task['description']): ?>
                                            <br><small class="text-muted"><?php echo substr(htmlspecialchars($task['description']), 0, 50) . '...'; ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Belum ditugaskan'); ?></td>
                                    <td>
                                        <?php
                                        $taskStatusColors = [
                                            'to_do' => 'secondary',
                                            'in_progress' => 'primary',
                                            'done' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $taskColor = $taskStatusColors[$task['status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $taskColor; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $priorityColor = $priorityColors[$task['priority']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $priorityColor; ?>">
                                            <?php echo ucfirst($task['priority']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $task['due_date'] ? date('M d, Y', strtotime($task['due_date'])) : '-'; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="index.php?url=tasks/view/<?php echo $task['id']; ?>" 
                                               class="btn btn-outline-primary" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($currentUser && ($currentUser['role'] == 'admin' || $task['assigned_to'] == $currentUser['id'] || $project['project_manager_id'] == $currentUser['id'])): ?>
                                            <a href="index.php?url=tasks/edit/<?php echo $task['id']; ?>" 
                                               class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
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
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Team Members -->
        <div class="card mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-users me-2 text-muted"></i>
                    Anggota Tim
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($teamMembers)): ?>
                    <p class="text-muted text-center py-3">Belum ada anggota tim</p>
                <?php else: ?>
                    <?php foreach ($teamMembers as $member): ?>
                    <div class="d-flex align-items-center mb-3">
                            <div class="avatar-sm me-3">
                            <?php 
                            $profilePhoto = $member['profile_photo'] ?? '';
                            $imagePath = '';
                            $imageExists = false;
                            
                            if (!empty($profilePhoto)) {
                                // Handle both old format (profiles/filename) and new format (filename)
                                if (strpos($profilePhoto, 'profiles/') === 0) {
                                    $imagePath = 'uploads/' . $profilePhoto;
                                } else {
                                    $imagePath = 'uploads/profiles/' . $profilePhoto;
                                }
                                
                                $fullPath = ROOT_PATH . '/' . $imagePath;
                                $imageExists = file_exists($fullPath);
                                
                                // Debug: Show what we're looking for
                                // echo "<!-- Looking for: $fullPath -->";
                                // echo "<!-- Exists: " . ($imageExists ? 'YES' : 'NO') . " -->";
                            }
                            ?>
                            
                            <?php if ($imageExists): ?>
                                <img src="<?php echo $imagePath; ?>" alt="Profil" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <?php echo strtoupper(substr($member['username'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium"><?php echo htmlspecialchars($member['username']); ?></div>
                            <small class="text-muted"><?php echo ucfirst(str_replace('_', ' ', $member['role_in_project'])); ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bug Statistics -->
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-bug me-2 text-muted"></i>
                    Statistik Bug
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <div class="h4 mb-0 text-danger"><?php echo $stats['total_bugs'] ?? 0; ?></div>
                            <small class="text-muted">Total Bug</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h4 mb-0 text-warning"><?php echo $stats['open_bugs'] ?? 0; ?></div>
                        <small class="text-muted">Bug Terbuka</small>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="index.php?url=bugs&project_id=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-bug me-1"></i>Lihat Semua Bug
                    </a>
                </div>
                <div class="mt-2 text-center">
                    <div class="text-danger small">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Kritis: <?php echo $stats['critical_bugs'] ?? 0; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<!-- Modal Reopen Project -->
<div class="modal fade" id="reopenProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="index.php?url=projects/reopen/<?php echo $project['id']; ?>" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buka Kembali Proyek</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Alasan membuka kembali</label>
          <select class="form-select" name="reason" required>
            <option value="maintenance">Maintenance lanjutan</option>
            <option value="new_requirements">Kebutuhan baru</option>
            <option value="bug_fixing">Perbaikan bug</option>
            <option value="client_request">Permintaan klien</option>
            <option value="other">Lainnya</option>
          </select>
        </div>
        <small class="text-muted">Status proyek akan berubah menjadi "Sedang dikerjakan".</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Buka Kembali</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Complete Project -->
<div class="modal fade" id="completeProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="index.php" class="modal-content">
      <input type="hidden" name="url" value="projects/complete/<?php echo $project['id']; ?>">
      <div class="modal-header">
        <h5 class="modal-title">Selesaikan Proyek</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Yakin ingin menandai proyek ini sebagai selesai? Tindakan ini akan mengatur progres menjadi 100%.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Selesaikan</button>
      </div>
    </form>
  </div>
</div>