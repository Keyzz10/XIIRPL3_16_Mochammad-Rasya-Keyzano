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

<!-- Tasks Create Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Buat Tugas Baru</h1>
        <p class="text-muted mb-0">Tambahkan tugas baru ke proyek Anda</p>
    </div>
    <a href="index.php?url=tasks" class="btn btn-outline-secondary">
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
                    <i class="fas fa-tasks me-2"></i>
                    Informasi Tugas
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="project_id" class="form-label">Proyek <span class="text-danger">*</span></label>
                            <select class="form-select" id="project_id" name="project_id" required>
                                <option value="">Pilih Proyek</option>
                                <?php if (!empty($projects)): ?>
                                    <?php foreach ($projects as $project): ?>
                                        <option value="<?php echo $project['id']; ?>" 
                                                <?php echo ($_POST['project_id'] ?? '') == $project['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($project['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="assigned_to" class="form-label">Ditugaskan Ke <span class="text-danger">*</span></label>
                            <select class="form-select" id="assigned_to" name="assigned_to" required>
                                <option value="">Pilih Pengguna</option>
                                <?php 
                                // Group users by role for a tidy dropdown
                                $developers = array_filter($users ?? [], function($u) { return ($u['role'] ?? '') === 'developer'; });
                                $qaTesters  = array_filter($users ?? [], function($u) { return ($u['role'] ?? '') === 'qa_tester'; });
                                
                                // Sort alphabetically by full_name
                                $sortByName = function(&$arr) { usort($arr, function($a, $b) { return strcasecmp($a['full_name'], $b['full_name']); }); };
                                $sortByName($developers);
                                $sortByName($qaTesters);
                                ?>
                                <?php if (!empty($developers)): ?>
                                <optgroup label="Pengembang">
                                    <?php foreach ($developers as $user): ?>
                                        <option value="<?php echo $user['id']; ?>" <?php echo ($_POST['assigned_to'] ?? '') == $user['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($user['full_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <?php endif; ?>
                                <?php if (!empty($qaTesters)): ?>
                                <optgroup label="QA Tester">
                                    <?php foreach ($qaTesters as $user): ?>
                                        <option value="<?php echo $user['id']; ?>" <?php echo ($_POST['assigned_to'] ?? '') == $user['id'] ? 'selected' : ''; ?>>
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
                                <option value="to_do" <?php echo ($_POST['status'] ?? 'to_do') == 'to_do' ? 'selected' : ''; ?>>Akan Dikerjakan</option>
                                <option value="in_progress" <?php echo ($_POST['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>Sedang Dikerjakan</option>
                                <option value="done" <?php echo ($_POST['status'] ?? '') == 'done' ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="">Pilih Prioritas</option>
                                <option value="low" <?php echo ($_POST['priority'] ?? '') == 'low' ? 'selected' : ''; ?>>Rendah</option>
                                <option value="medium" <?php echo ($_POST['priority'] ?? '') == 'medium' ? 'selected' : ''; ?>>Sedang</option>
                                <option value="high" <?php echo ($_POST['priority'] ?? '') == 'high' ? 'selected' : ''; ?>>Tinggi</option>
                                <option value="critical" <?php echo ($_POST['priority'] ?? '') == 'critical' ? 'selected' : ''; ?>>Kritis</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="task_type" class="form-label">Jenis Tugas <span class="text-danger">*</span></label>
                            <select class="form-select" id="task_type" name="task_type" required>
                                <option value="feature" <?php echo ($_POST['task_type'] ?? 'feature') == 'feature' ? 'selected' : ''; ?>>Fitur</option>
                                <option value="bug" <?php echo ($_POST['task_type'] ?? '') == 'bug' ? 'selected' : ''; ?>>Bug</option>
                                <option value="improvement" <?php echo ($_POST['task_type'] ?? '') == 'improvement' ? 'selected' : ''; ?>>Peningkatan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tags" class="form-label">Tag</label>
                            <input type="text" class="form-control" id="tags" name="tags" 
                                   value="<?php echo htmlspecialchars($_POST['tags'] ?? ''); ?>" 
                                   placeholder="misal: Frontend, Backend, Database, Testing">
                            <small class="form-text text-muted">Pisahkan beberapa tag dengan koma</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="estimated_hours" class="form-label">Perkiraan Jam</label>
                            <input type="number" class="form-control" id="estimated_hours" name="estimated_hours" 
                                   value="<?php echo htmlspecialchars($_POST['estimated_hours'] ?? ''); ?>" 
                                   min="0" step="0.5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="parent_task_id" class="form-label">Tugas Induk (Opsional)</label>
                            <select class="form-select" id="parent_task_id" name="parent_task_id">
                                <option value="">Pilih Tugas Induk (untuk subtask)</option>
                                <?php if (!empty($parentTasks)): ?>
                                    <?php foreach ($parentTasks as $parentTask): ?>
                                        <option value="<?php echo $parentTask['id']; ?>" 
                                                <?php echo ($_POST['parent_task_id'] ?? '') == $parentTask['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($parentTask['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="visibility" class="form-label">Visibilitas</label>
                            <select class="form-select" id="visibility" name="visibility">
                                <option value="project" <?php echo ($_POST['visibility'] ?? 'project') == 'project' ? 'selected' : ''; ?>>Anggota Proyek</option>
                                <option value="assigned_only" <?php echo ($_POST['visibility'] ?? '') == 'assigned_only' ? 'selected' : ''; ?>>Hanya Pengguna yang Ditugaskan</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Batas Waktu</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" 
                               value="<?php echo htmlspecialchars($_POST['due_date'] ?? ''); ?>">
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="index.php?url=tasks" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    Panduan Tugas
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-lightbulb me-2"></i>Tips Sukses
                    </h6>
                    <ul class="small text-muted mb-0">
                        <li>Tulis judul tugas yang jelas dan spesifik</li>
                        <li>Berikan deskripsi tugas yang detail</li>
                        <li>Tetapkan tenggat waktu yang realistis</li>
                        <li>Tugaskan ke anggota tim yang tepat</li>
                        <li>Pilih level prioritas yang benar</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-flag me-2"></i>Level Prioritas
                    </h6>
                    <small class="text-muted">
                        <strong>Kritis:</strong> Masalah mendesak yang menghambat progress<br>
                        <strong>Tinggi:</strong> Tugas penting dengan tenggat ketat<br>
                        <strong>Sedang:</strong> Tugas dengan prioritas standar<br>
                        <strong>Rendah:</strong> Fitur tambahan atau perbaikan
                    </small>
                </div>

                <div>
                    <h6 class="text-primary">
                        <i class="fas fa-clock me-2"></i>Estimasi Waktu
                    </h6>
                    <small class="text-muted">
                        Berikan perkiraan jam untuk membantu perencanaan proyek dan alokasi sumber daya. 
                        Ini membantu melacak progress dan mengidentifikasi potensi hambatan.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>