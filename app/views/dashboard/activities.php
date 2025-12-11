<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0 text-dark">
                <i class="fas fa-history me-3" style="color: #0ea5e9;"></i><?php _e('dashboard.all_activities'); ?>
            </h1>
            <p class="text-muted mb-0">
                <?php if (in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
                    System-wide activity log
                <?php else: ?>
                    Your activity history
                <?php endif; ?>
            </p>
        </div>
        <div class="btn-group">
            <a href="index.php?url=dashboard" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Activity Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-list fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo $totalActivities; ?></h4>
                    <small>Total Activities</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-day fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo count(array_filter($activities, function($a) { return date('Y-m-d', strtotime($a['created_at'])) === date('Y-m-d'); })); ?></h4>
                    <small>Today's Activities</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-week fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo count(array_filter($activities, function($a) { return strtotime($a['created_at']) >= strtotime('-7 days'); })); ?></h4>
                    <small>This Week</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo count(array_unique(array_column($activities, 'user_id'))); ?></h4>
                    <small>Active Users</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="fas fa-clock me-2" style="color: #0ea5e9;"></i>Activity Timeline
                </h5>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?filter=all">All Activities</a></li>
                        <li><a class="dropdown-item" href="?filter=create">Create</a></li>
                        <li><a class="dropdown-item" href="?filter=update">Update</a></li>
                        <li><a class="dropdown-item" href="?filter=delete">Delete</a></li>
                    </ul>
                </div>
            </div>
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
                    <h5 class="text-dark mb-2 fw-semibold">No Activities Found</h5>
                    <p class="text-muted mb-0">No activities have been recorded yet.</p>
                </div>
            <?php else: ?>
                <div class="timeline p-4">
                    <?php foreach ($activities as $activity): ?>
                        <div class="timeline-item d-flex mb-4">
                            <div class="timeline-marker me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
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
                                        'update_profile' => 'fas fa-user-cog',
                                        'complete' => 'fas fa-check',
                                        'assign' => 'fas fa-user-plus'
                                    ];
                                    $iconClass = $activityIcons[$activity['action'] ?? ''] ?? 'fas fa-circle';
                                    ?>
                                    <i class="<?php echo $iconClass; ?> text-white fa-sm"></i>
                                </div>
                            </div>
                            <div class="timeline-content flex-grow-1 bg-light rounded-3 p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <?php if (isset($activity['full_name']) && $activity['full_name']): ?>
                                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <span class="text-white fw-bold"><?php echo strtoupper(substr($activity['full_name'], 0, 1)); ?></span>
                                                </div>
                                                <h6 class="mb-0 fw-semibold text-dark"><?php echo htmlspecialchars($activity['full_name']); ?></h6>
                                            <?php else: ?>
                                                <div class="avatar-sm bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user text-white fa-sm"></i>
                                                </div>
                                                <h6 class="mb-0 fw-semibold text-dark">Unknown User</h6>
                                            <?php endif; ?>
                                        </div>
                                        <p class="mb-1 text-muted">
                                            <span class="fw-semibold text-dark"><?php echo ucfirst(str_replace('_', ' ', $activity['action'] ?? 'unknown')); ?></span>
                                            <?php if ((isset($activity['entity_type']) && $activity['entity_type']) && (isset($activity['entity_id']) && $activity['entity_id'])): ?>
                                                <span class="badge bg-light text-dark me-1"><?php echo ucfirst($activity['entity_type']); ?></span>
                                                <span class="text-primary fw-semibold">#<?php echo $activity['entity_id']; ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <?php if (isset($activity['ip_address']) && $activity['ip_address']): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-globe me-1"></i>IP: <?php echo htmlspecialchars($activity['ip_address']); ?>
                                            </small>
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

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="card-footer bg-white border-0 py-3">
                        <nav aria-label="Activities pagination">
                            <ul class="pagination justify-content-center mb-0">
                                <?php if ($currentPage > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">
                                            <i class="fas fa-chevron-left me-1"></i>Previous
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                    <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">
                                            Next<i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <div class="text-center mt-2">
                            <small class="text-muted">
                                Showing page <?php echo $currentPage; ?> of <?php echo $totalPages; ?> 
                                (<?php echo $totalActivities; ?> total activities)
                            </small>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 12px;
}

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
    margin-top: 8px;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    transition: box-shadow 0.15s ease-in-out;
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