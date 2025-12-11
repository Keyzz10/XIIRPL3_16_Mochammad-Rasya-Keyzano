<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

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

<!-- Task Edit Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Edit Tugas</h1>
        <p class="text-muted mb-0">Perbarui informasi tugas</p>
    </div>
    <a href="index.php?url=tasks/view/<?php echo $task['id']; ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Tugas
    </a>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <h6>Perbaiki kesalahan berikut:</h6>
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-edit me-2"></i>
                    Informasi Tugas
                </h5>
            </div>
            <div class="card-body">
                <?php if ($currentUser['role'] === 'developer'): ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Tugas</label>
                            <select class="form-select" id="status" name="status">
                                <option value="to_do" <?php echo $task['status'] == 'to_do' ? 'selected' : ''; ?>>Belum Dikerjakan</option>
                                <option value="in_progress" <?php echo $task['status'] == 'in_progress' ? 'selected' : ''; ?>>Sedang Dikerjakan</option>
                                <option value="done" <?php echo $task['status'] == 'done' ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <a href="index.php?url=tasks/view/<?php echo $task['id']; ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i><?php echo ($task['status'] !== 'done') ? 'Simpan Perubahan' : 'Tugas Selesai'; ?>
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="<?php echo htmlspecialchars($task['title']); ?>" 
                                       <?php echo ($currentUser['role'] === 'developer') ? 'readonly' : ''; ?> required>
                                <?php if ($currentUser['role'] === 'developer'): ?>
                                <div class="form-text">Hanya Manajer Proyek/Admin yang bisa mengubah judul.</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      <?php echo ($currentUser['role'] === 'developer') ? 'readonly' : ''; ?>
                                      required><?php echo htmlspecialchars($task['description']); ?></textarea>
                            <?php if ($currentUser['role'] === 'developer'): ?>
                            <div class="form-text">Hanya PM/QA/Admin yang bisa mengubah deskripsi.</div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="project_id" class="form-label">Proyek <span class="text-danger">*</span></label>
                                <select class="form-select" id="project_id" name="project_id" required <?php echo ($currentUser['role'] === 'developer') ? 'disabled' : ''; ?>>
                                    <option value="">Pilih Proyek</option>
                                    <?php if (!empty($projects)): ?>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?php echo $project['id']; ?>" 
                                                    <?php echo $task['project_id'] == $project['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($project['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="assigned_to" class="form-label">Ditugaskan Ke <span class="text-danger">*</span></label>
                                <select class="form-select" id="assigned_to" name="assigned_to" required <?php echo ($currentUser['role'] === 'developer') ? 'disabled' : ''; ?>>
                                    <option value="">Pilih Pengguna</option>
                                    <?php 
                                    $developers = array_filter($users ?? [], function($u) { return ($u['role'] ?? '') === 'developer'; });
                                    $qaTesters  = array_filter($users ?? [], function($u) { return ($u['role'] ?? '') === 'qa_tester'; });
                                    $sortByName = function(&$arr) { usort($arr, function($a, $b) { return strcasecmp($a['full_name'], $b['full_name']); }); };
                                    $sortByName($developers);
                                    $sortByName($qaTesters);
                                    ?>
                                    <?php if (!empty($developers)): ?>
                                    <optgroup label="Pengembang">
                                        <?php foreach ($developers as $user): ?>
                                            <option value="<?php echo $user['id']; ?>" <?php echo $task['assigned_to'] == $user['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($user['full_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <?php endif; ?>
                                    <?php if (!empty($qaTesters)): ?>
                                    <optgroup label="QA Tester">
                                        <?php foreach ($qaTesters as $user): ?>
                                            <option value="<?php echo $user['id']; ?>" <?php echo $task['assigned_to'] == $user['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($user['full_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="to_do" <?php echo $task['status'] == 'to_do' ? 'selected' : ''; ?>>Akan Dikerjakan</option>
                                    <option value="in_progress" <?php echo $task['status'] == 'in_progress' ? 'selected' : ''; ?>>Sedang Dikerjakan</option>
                                    <option value="done" <?php echo $task['status'] == 'done' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                <select class="form-select" id="priority" name="priority" required <?php echo ($currentUser['role'] === 'developer') ? 'disabled' : ''; ?>>
                                    <option value="">Pilih Prioritas</option>
                                    <option value="low" <?php echo $task['priority'] == 'low' ? 'selected' : ''; ?>>Rendah</option>
                                    <option value="medium" <?php echo $task['priority'] == 'medium' ? 'selected' : ''; ?>>Sedang</option>
                                    <option value="high" <?php echo $task['priority'] == 'high' ? 'selected' : ''; ?>>Tinggi</option>
                                    <option value="critical" <?php echo $task['priority'] == 'critical' ? 'selected' : ''; ?>>Kritis</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="estimated_hours" class="form-label">Perkiraan Jam</label>
                                <input type="number" class="form-control" id="estimated_hours" name="estimated_hours" 
                                       value="<?php echo htmlspecialchars($task['estimated_hours'] ?? ''); ?>" 
                                       min="0" step="0.5" max="100">
                                <?php if ($currentUser['role'] === 'developer' && !empty($_SESSION['pending_estimated_hours'][$task['id']])): ?>
                                <?php $p = $_SESSION['pending_estimated_hours'][$task['id']]; ?>
                                <div class="small mt-1">
                                    <span class="badge bg-warning text-dark">Menunggu persetujuan PM</span>
                                    <div class="text-muted">Diusulkan: <?php echo number_format($p['new'], 2); ?> jam (saat ini <?php echo number_format($p['old'], 2); ?>)</div>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Progress input disembunyikan -->
                            <input type="hidden" id="progress" name="progress" value="<?php echo htmlspecialchars($task['progress'] ?? 0); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Batas Waktu</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" 
                                   value="<?php echo htmlspecialchars($task['due_date'] ?? ''); ?>" <?php echo ($currentUser['role'] === 'developer') ? 'readonly' : ''; ?>>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="index.php?url=tasks/view/<?php echo $task['id']; ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui Tugas
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    Detail Tugas
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Dibuat:</strong>
                    <div class="text-muted"><?php echo !empty($task['created_at']) ? date('M d, Y H:i', strtotime($task['created_at'])) : '-'; ?></div>
                </div>
                
                <div class="mb-3">
                    <strong>Terakhir Diperbarui:</strong>
                    <div class="text-muted"><?php echo date('M d, Y H:i', strtotime($task['updated_at'] ?? $task['created_at'])); ?></div>
                </div>
                
                <div class="mb-3">
                    <strong>Dibuat Oleh:</strong>
                    <div class="text-muted"><?php echo htmlspecialchars($task['created_by_name'] ?? 'Tidak diketahui'); ?></div>
                </div>
                
                <?php if ($task['due_date']): ?>
                <div class="mb-3">
                    <strong>Batas Waktu:</strong>
                    <div class="text-muted">
                        <?php 
                        $dueDate = new DateTime($task['due_date']);
                        $now = new DateTime();
                        $isOverdue = $dueDate < $now && $task['status'] !== 'done';
                        ?>
                        <span class="<?php echo $isOverdue ? 'text-danger' : ''; ?>">
                            <?php echo $dueDate->format('M d, Y'); ?>
                            <?php if ($isOverdue): ?>
                                <i class="fas fa-exclamation-triangle ms-1"></i>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips Pengeditan
                </h5>
            </div>
            <div class="card-body">
                <ul class="small text-muted mb-0">
                    <li>Perbarui progress secara berkala untuk melacak penyelesaian</li>
                    <li>Ubah status saat tugas berpindah tahapan</li>
                    <li>Tugaskan ulang tugas jika diperlukan</li>
                    <li>Perbarui batas waktu jika prioritas berubah</li>
                    <li>Tambahkan deskripsi detail untuk kejelasan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>
