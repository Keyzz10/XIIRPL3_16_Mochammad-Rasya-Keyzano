<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0 text-dark">
                <i class="fas fa-user-edit me-3" style="color: #0ea5e9;"></i>Edit Pengguna
            </h1>
            <p class="text-muted mb-0">Perbarui informasi dan pengaturan pengguna</p>
        </div>
        <div class="btn-group">
            <a href="index.php?url=users" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Pengguna
            </a>
        </div>
    </div>

    <!-- Edit User Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-user me-2" style="color: #0ea5e9;"></i>Informasi Pengguna
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <h6 class="alert-heading mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>Perbaiki kesalahan berikut:
                            </h6>
                            <ul class="mb-0">
                                <?php foreach ($errors as $field => $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?url=users/edit/<?php echo $user['id']; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label fw-semibold">
                                    <i class="fas fa-at me-1" style="color: #0ea5e9;"></i>Username
                                </label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-1" style="color: #0ea5e9;"></i>Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-semibold">
                                <i class="fas fa-user me-1" style="color: #0ea5e9;"></i>Nama Lengkap
                            </label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-semibold">
                                    <i class="fas fa-user-tag me-1" style="color: #0ea5e9;"></i>Peran
                                </label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Pilih Peran</option>
                                    <?php if (($currentUserRole ?? '') === 'super_admin'): ?>
                                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrator</option>
                                    <?php endif; ?>
                                    <option value="project_manager" <?php echo $user['role'] === 'project_manager' ? 'selected' : ''; ?>>Project Manager</option>
                                    <option value="developer" <?php echo $user['role'] === 'developer' ? 'selected' : ''; ?>>Developer</option>
                                    <option value="qa_tester" <?php echo $user['role'] === 'qa_tester' ? 'selected' : ''; ?>>QA Tester</option>
                                    <option value="client" <?php echo $user['role'] === 'client' ? 'selected' : ''; ?>>Client</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-semibold">
                                    <i class="fas fa-circle me-1" style="color: #0ea5e9;"></i>Status
                                </label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="inactive" <?php echo $user['status'] === 'inactive' ? 'selected' : ''; ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="fas fa-phone me-1" style="color: #0ea5e9;"></i>No. Telepon
                            </label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1" style="color: #0ea5e9;"></i>Password Baru
                            </label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Update Pengguna
                            </button>
                            <a href="index.php?url=users" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Preview Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-eye me-2" style="color: #0ea5e9;"></i>Preview Pengguna
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    <?php if ($user['profile_photo']): ?>
                        <img src="<?php echo UPLOADS_URL . '/' . $user['profile_photo']; ?>" 
                             class="rounded-circle mb-3 shadow-sm" 
                             style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #e2e8f0;" 
                             alt="Profile">
                    <?php else: ?>
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); font-size: 28px; border: 3px solid #e2e8f0;">
                            <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <h5 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($user['full_name']); ?></h5>
                    <p class="text-muted mb-2">@<?php echo htmlspecialchars($user['username']); ?></p>
                    <p class="text-muted mb-3"><?php echo htmlspecialchars($user['email']); ?></p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <?php
                        $roleColors = [
                            'super_admin' => 'dark',
                            'admin' => 'primary',
                            'project_manager' => 'primary',
                            'developer' => 'success',
                            'qa_tester' => 'info',
                            'client' => 'secondary'
                        ];
                        $roleColor = $roleColors[$user['role']] ?? 'secondary';
                        $roleText = ucfirst(str_replace('_', ' ', $user['role']));
                        ?>
                        <span class="badge bg-<?php echo $roleColor; ?>">
                            <?php if ($user['role'] === 'super_admin'): ?>
                                <i class="fas fa-crown me-1"></i>
                            <?php elseif ($user['role'] === 'admin'): ?>
                                <i class="fas fa-user-shield me-1"></i>
                            <?php endif; ?>
                            <?php echo $roleText; ?>
                        </span>
                        <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : 'secondary'; ?>">
                            <i class="fas fa-circle fa-xs me-1"></i><?php echo ucfirst($user['status']); ?>
                        </span>
                    </div>
                    
                    <div class="border-top pt-3">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="text-muted small">Anggota Sejak</div>
                                <div class="fw-semibold text-dark"><?php echo date('M Y', strtotime($user['created_at'])); ?></div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small">Login Terakhir</div>
                                <div class="fw-semibold text-dark">
                                    <?php if ($user['last_login']): ?>
                                        <?php echo date('M j', strtotime($user['last_login'])); ?>
                                    <?php else: ?>
                                        Tidak Pernah
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0 py-4">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-bolt me-2" style="color: #0ea5e9;"></i>Tindakan Cepat
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="index.php?url=users/activity/<?php echo $user['id']; ?>" class="btn btn-outline-info">
                            <i class="fas fa-history me-2"></i>Lihat Aktivitas
                        </a>
                        <?php if ($user['status'] === 'active'): ?>
                            <button class="btn btn-outline-warning" onclick="toggleUserStatus(<?php echo $user['id']; ?>, 'deactivate')">
                                <i class="fas fa-user-times me-2"></i>Nonaktifkan Pengguna
                            </button>
                        <?php else: ?>
                            <button class="btn btn-outline-success" onclick="toggleUserStatus(<?php echo $user['id']; ?>, 'activate')">
                                <i class="fas fa-user-check me-2"></i>Aktifkan Pengguna
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleUserStatus(userId, action) {
    const actionText = action === 'activate' ? 'aktifkan' : 'nonaktifkan';
    
    if (confirm(`Apakah Anda yakin ingin ${actionText} pengguna ini?`)) {
        fetch(`index.php?url=users/${action}/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>