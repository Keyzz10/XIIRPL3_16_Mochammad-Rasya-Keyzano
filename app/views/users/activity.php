<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0 text-dark">
                <i class="fas fa-history me-3" style="color: #0ea5e9;"></i>Aktivitas Pengguna
            </h1>
            <p class="text-muted mb-0">Riwayat aktivitas untuk <?php echo htmlspecialchars($user['full_name'] ?? 'Pengguna tidak diketahui'); ?></p>
        </div>
        <div class="btn-group">
            <a href="index.php?url=users" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Pengguna
            </a>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <?php if (isset($user['profile_photo']) && $user['profile_photo']): ?>
                    <img src="<?php echo UPLOADS_URL . '/' . $user['profile_photo']; ?>" 
                         class="rounded-circle me-3 shadow-sm" 
                         style="width: 64px; height: 64px; object-fit: cover; border: 3px solid #e2e8f0;" 
                         alt="Profile">
                <?php else: ?>
                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" 
                         style="width: 64px; height: 64px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); font-size: 24px; border: 3px solid #e2e8f0;">
                        <?php echo strtoupper(substr($user['full_name'] ?? 'U', 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <div>
                    <h4 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($user['full_name'] ?? 'Pengguna tidak diketahui'); ?></h4>
                    <p class="text-muted mb-1">@<?php echo htmlspecialchars($user['username'] ?? 'unknown'); ?> • <?php echo htmlspecialchars($user['email'] ?? 'unknown@example.com'); ?></p>
                    <div class="d-flex align-items-center">
                        <?php
                        $roleColors = [
                            'super_admin' => 'dark',
                            'admin' => 'primary',
                            'project_manager' => 'primary',
                            'developer' => 'success',
                            'qa_tester' => 'info',
                            'client' => 'secondary'
                        ];
                        $roleColor = $roleColors[$user['role'] ?? 'client'] ?? 'secondary';
                        $roleText = ucfirst(str_replace('_', ' ', $user['role'] ?? 'client'));
                        ?>
                        <?php 
                        $roleLabels = [
                            'super_admin' => 'Super Admin',
                            'admin' => 'Administrator',
                            'project_manager' => 'Manajer Proyek',
                            'developer' => 'Developer',
                            'qa_tester' => 'QA Tester',
                            'client' => 'Klien',
                        ];
                        $roleText = $roleLabels[$user['role'] ?? 'client'] ?? 'Pengguna';
                        ?>
                        <span class="badge bg-<?php echo $roleColor; ?> me-2">
                            <?php if (($user['role'] ?? '') === 'super_admin'): ?>
                                <i class="fas fa-crown me-1"></i>
                            <?php elseif (($user['role'] ?? '') === 'admin'): ?>
                                <i class="fas fa-user-shield me-1"></i>
                            <?php endif; ?>
                            <?php echo $roleText; ?>
                        </span>
                        <span class="badge bg-<?php echo (($user['status'] ?? '') === 'active') ? 'success' : 'secondary'; ?>">
                            <i class="fas fa-circle fa-xs me-1"></i><?php echo (($user['status'] ?? '') === 'active') ? 'Aktif' : 'Nonaktif'; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-4">
            <h5 class="card-title mb-0 fw-semibold">
                <i class="fas fa-clock me-2" style="color: #0ea5e9;"></i>Linimasa Aktivitas
            </h5>
        </div>
        <div class="card-body p-0">
            <?php if (empty($activities)): ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="background-color: rgba(14, 165, 233, 0.1); width: 80px; height: 80px;">
                            <i class="fas fa-history fa-2x" style="color: #0ea5e9;"></i>
                        </div>
                    </div>
                    <h5 class="text-dark mb-2 fw-semibold">Tidak Ada Aktivitas</h5>
                    <p class="text-muted mb-0">Pengguna ini belum melakukan aktivitas apapun.</p>
                </div>
            <?php else: ?>
                <div class="timeline p-4">
                    <?php foreach ($activities as $activity): ?>
                        <div class="timeline-item d-flex mb-4">
                            <div class="timeline-marker me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
                                    <?php
                                    $activityIcons = [
                                        'create' => 'fas fa-plus',
                                        'update' => 'fas fa-edit',
                                        'delete' => 'fas fa-trash',
                                        'login' => 'fas fa-sign-in-alt',
                                        'logout' => 'fas fa-sign-out-alt',
                                        'create_user' => 'fas fa-user-plus',
                                        'update_user' => 'fas fa-user-edit',
                                        'delete_user' => 'fas fa-user-minus',
                                        'activate_user' => 'fas fa-user-check',
                                        'deactivate_user' => 'fas fa-user-times',
                                        'update_profile' => 'fas fa-user-cog'
                                    ];
                                    $iconClass = $activityIcons[$activity['action'] ?? ''] ?? 'fas fa-circle';
                                    ?>
                                    <i class="<?php echo $iconClass; ?> text-white fa-sm"></i>
                                </div>
                            </div>
                            <div class="timeline-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-semibold text-dark">
                                            <?php echo ucfirst(str_replace('_', ' ', $activity['action'] ?? 'unknown')); ?>
                                        </h6>
                                        <p class="mb-1 text-muted">
                                            <?php if ((isset($activity['entity_type']) && $activity['entity_type']) && (isset($activity['entity_id']) && $activity['entity_id'])): ?>
                                                <span class="badge bg-light text-dark me-1"><?php echo ucfirst($activity['entity_type']); ?></span>
                                                <span class="text-primary fw-semibold">#<?php echo $activity['entity_id']; ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <?php if (isset($activity['old_values']) && $activity['old_values']): ?>
                                            <small class="text-muted">Previous data: <?php echo htmlspecialchars($activity['old_values']); ?></small>
                                        <?php elseif (isset($activity['new_values']) && $activity['new_values']): ?>
                                            <small class="text-muted">New data: <?php echo htmlspecialchars($activity['new_values']); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block"><?php echo isset($activity['created_at']) ? date('M j, Y', strtotime($activity['created_at'])) : 'Unknown date'; ?></small>
                                        <small class="text-primary fw-semibold"><?php echo isset($activity['created_at']) ? date('g:i A', strtotime($activity['created_at'])) : 'Unknown time'; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.timeline-item:last-child .timeline-marker::after {
    display: none;
}

.timeline-marker {
    position: relative;
}

.timeline-marker::after {
    content: '';
    position: absolute;
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 40px;
    background: linear-gradient(to bottom, #0ea5e9, rgba(14, 165, 233, 0.3));
}

.timeline-content {
    padding-top: 8px;
}

/* Dark mode support */
body.dark-mode .timeline-marker::after {
    background: linear-gradient(to bottom, #0ea5e9, rgba(14, 165, 233, 0.2));
}

body.dark-mode .timeline-content .badge.bg-light {
    background-color: #475569 !important;
    color: #e2e8f0 !important;
}
</style>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>