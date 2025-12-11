<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
/* Dark mode improvements for dashboard project items */
body.dark-mode .project-item {
    background-color: #334155 !important;
    border-color: #475569 !important;
    color: #ffffff !important;
}

body.dark-mode .project-item h6 {
    color: #ffffff !important;
}

body.dark-mode .project-item .text-muted {
    color: #cbd5e1 !important;
}

body.dark-mode .project-item small {
    color: #cbd5e1 !important;
}

body.dark-mode .project-item .fw-semibold {
    color: #ffffff !important;
}

/* Dark mode fixes for dashboard table */
body.dark-mode .dashboard-table {
    background-color: #334155 !important;
    color: #e2e8f0 !important;
}

body.dark-mode .dashboard-table thead th {
    background-color: #475569 !important;
    color: #e2e8f0 !important;
    border-color: #64748b !important;
}

body.dark-mode .dashboard-table tbody tr {
    background-color: #334155 !important;
    color: #e2e8f0 !important;
}

body.dark-mode .dashboard-table tbody tr:hover {
    background-color: #475569 !important;
}

body.dark-mode .dashboard-table tbody td {
    background-color: #334155 !important;
    color: #e2e8f0 !important;
    border-color: #64748b !important;
}

body.dark-mode .dashboard-table tbody tr:hover td {
    background-color: #475569 !important;
}

/* Dark mode fixes for card body containing tables */
body.dark-mode .card-body {
    background-color: #334155 !important;
}

body.dark-mode .card-body .table {
    background-color: #334155 !important;
}

/* Dark mode fixes for activity items */
body.dark-mode .dashboard-activity-item {
    background-color: #334155 !important;
    color: #e2e8f0 !important;
    border-color: #475569 !important;
}

body.dark-mode .dashboard-activity-item:hover {
    background-color: #475569 !important;
}

body.dark-mode .dashboard-activity-item h6 {
    color: #e2e8f0 !important;
}

body.dark-mode .dashboard-activity-item .text-muted {
    color: #94a3b8 !important;
}

body.dark-mode .dashboard-activity-item .text-dark {
    color: #e2e8f0 !important;
}

/* Dark mode fixes for bug items */
body.dark-mode .bug-item {
    background-color: #334155 !important;
    border-color: #475569 !important;
    color: #e2e8f0 !important;
}

body.dark-mode .bug-item h6 {
    color: #e2e8f0 !important;
}

body.dark-mode .bug-item .text-muted {
    color: #94a3b8 !important;
}
</style>

<!-- Dashboard Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div class="mb-3 mb-md-0">
        <h1 class="h2 mb-0 text-dark">
            <i class="fas fa-tachometer-alt me-2 me-md-3" style="color: #0ea5e9;"></i><?php _e('dashboard.title'); ?>
        </h1>
        <p class="text-muted mb-0"><?php echo __('dashboard.welcome_message', ['name' => htmlspecialchars($currentUser['username'])]); ?></p>
    </div>
    <div class="d-flex justify-content-end w-100 w-md-auto">
        <span class="badge bg-primary fs-6 px-3 py-2">
            <i class="fas fa-user-tag me-2"></i>
            <?php echo ucfirst(str_replace('_', ' ', $currentUser['role'])); ?>
        </span>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <?php if ($currentUser['role'] === 'admin'): ?>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-project-diagram fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.total_projects'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['total_projects'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.total_users'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['total_users'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.pending_tasks'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['pending_tasks'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-exclamation-triangle fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.critical_bugs'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['critical_bugs'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
    <?php elseif ($currentUser['role'] === 'developer'): ?>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.my_tasks'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['my_tasks'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.to_do'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['pending_tasks'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-spinner fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.in_progress'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['in_progress_tasks'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3 p-md-4">
                    <i class="fas fa-bug fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.assigned_bugs'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['open_bugs'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
    <?php elseif ($currentUser['role'] === 'qa_tester'): ?>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3">
                    <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.my_tasks'); ?></h6>
                    <div class="h4 mb-0 text-primary"><?php echo $stats['my_tasks'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3">
                    <i class="fas fa-bug fa-2x text-danger mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('profile.bugs_reported'); ?></h6>
                    <div class="h4 mb-0 text-danger"><?php echo $stats['bugs_reported'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3">
                    <i class="fas fa-clipboard-check fa-2x text-warning mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.ready_to_test'); ?></h6>
                    <div class="h4 mb-0 text-warning"><?php echo $stats['bugs_to_test'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="card bg-light border-0 h-100">
                <div class="card-body text-center p-3">
                    <i class="fas fa-vial fa-2x text-success mb-2"></i>
                    <h6 class="text-muted mb-1 small"><?php _e('dashboard.test_cases'); ?></h6>
                    <div class="h4 mb-0 text-success"><?php echo $stats['test_cases'] ?? 0; ?></div>
                </div>
            </div>
        </div>
        
    <?php elseif ($currentUser['role'] === 'client'): ?>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="stat-card bg-gradient-primary text-white h-100">
                <div class="d-flex justify-content-between align-items-center p-3 p-md-4">
                    <div>
                        <div class="stat-number"><?php echo $stats['my_projects'] ?? 0; ?></div>
                        <div class="text-white-50 small"><?php _e('dashboard.my_projects'); ?></div>
                    </div>
                    <div class="text-white">
                        <i class="fas fa-project-diagram fa-2x fa-md-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="stat-card bg-gradient-success text-white h-100">
                <div class="d-flex justify-content-between align-items-center p-3 p-md-4">
                    <div>
                        <div class="stat-number"><?php echo $stats['completed_projects'] ?? 0; ?></div>
                        <div class="text-white-50 small">Proyek Selesai</div>
                    </div>
                    <div class="text-white">
                        <i class="fas fa-check-circle fa-2x fa-md-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-3 mb-md-4">
            <div class="stat-card bg-gradient-info text-white h-100">
                <div class="d-flex justify-content-between align-items-center p-3 p-md-4">
                    <div>
                        <div class="stat-number"><?php echo count($stats['recent_updates'] ?? []); ?></div>
                        <div class="text-white-50 small"><?php _e('dashboard.recent_updates'); ?></div>
                    </div>
                    <div class="text-white">
                        <i class="fas fa-bell fa-2x fa-md-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Left Column -->
    <div class="col-lg-8 col-md-12 mb-4 mb-lg-0">
        <!-- Recent Activities -->
        <div class="card shadow-lg mb-4 overflow-hidden">
            <div class="card-header position-relative" style="background: #0ea5e9; border: none;">
                <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                    <h5 class="card-title mb-0 text-white fw-bold">
                        <i class="fas fa-clock me-2"></i>
                        <?php _e('dashboard.recent_activities'); ?>
                    </h5>
                    <a href="index.php?url=activities" class="btn btn-light btn-sm shadow-sm hover-lift">
                        <i class="fas fa-external-link-alt me-1"></i><?php _e('dashboard.view_all'); ?>
                    </a>
                </div>

            </div>
            <div class="card-body p-0">
                <?php if (!empty($recent_activities)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recent_activities as $activity): ?>
                            <div class="list-group-item border-0 py-3 px-4 hover-bg-light transition-all dashboard-activity-item">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-md bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm">
                                        <?php 
                                        $activityIcons = [
                                            'create' => 'fas fa-plus',
                                            'update' => 'fas fa-edit',
                                            'delete' => 'fas fa-trash',
                                            'complete' => 'fas fa-check',
                                            'assign' => 'fas fa-user-plus'
                                        ];
                                        $iconClass = $activityIcons[$activity['action']] ?? 'fas fa-circle';
                                        ?>
                                        <i class="<?php echo $iconClass; ?> text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0 fw-bold text-dark"><?php echo htmlspecialchars($activity['username'] ?? 'Unknown User'); ?> (<?php echo htmlspecialchars($activity['role'] ?? 'Unknown'); ?>)</h6>
                                            <div class="text-end">
                                                <small class="text-muted d-block"><?php echo date('M j, Y', strtotime($activity['created_at'])); ?></small>
                                                <small class="text-primary fw-bold"><?php echo date('g:i A', strtotime($activity['created_at'])); ?></small>
                                            </div>
                                        </div>
                                        <p class="mb-1 text-muted lh-sm">
                                            <span class="fw-semibold text-dark"><?php echo ucfirst(str_replace('_', ' ', $activity['action'])); ?></span> 
                                            <span class="badge bg-light text-dark me-1"><?php echo ucfirst($activity['entity_type']); ?></span>
                                            <span class="text-primary fw-bold">#<?php echo $activity['entity_id']; ?></span>
                                        </p>
                                        <div class="progress progress-sm mt-2" style="height: 3px;">
                                            <div class="progress-bar bg-gradient-primary" style="width: 100%; animation: progressLoad 1.5s ease-in-out;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 px-4">
                        <div class="mb-4 position-relative">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px;">
                                <i class="fas fa-clock fa-2x text-muted"></i>
                            </div>
                            <div class="position-absolute top-0 start-50 translate-middle">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                    <i class="fas fa-plus fa-xs text-white"></i>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-dark mb-2 fw-bold"><?php _e('dashboard.no_recent_activities'); ?></h5>
                        <p class="text-muted mb-4 lh-sm"><?php _e('dashboard.no_activities_desc'); ?></p>
                        <a href="index.php?url=tasks/create" class="btn btn-primary btn-lg shadow-sm hover-lift">
                            <i class="fas fa-plus me-2"></i><?php _e('dashboard.create_first_task'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- My Tasks -->
        <?php if (!empty($user_tasks)): ?>
        <div class="card shadow-lg overflow-hidden">
            <div class="card-header position-relative" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none;">
                <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                    <h5 class="card-title mb-0 text-white fw-bold">
                        <i class="fas fa-tasks me-2"></i>
                        <?php _e('dashboard.my_tasks'); ?>
                    </h5>
                    <a href="index.php?url=tasks" class="btn btn-light btn-sm shadow-sm hover-lift">
                        <i class="fas fa-external-link-alt me-1"></i><?php _e('dashboard.view_all'); ?> Tasks
                    </a>
                </div>

            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 dashboard-table">
                        <thead>
                            <tr>
                                <th>Task</th>   
                                <th>Project</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_tasks as $task): ?>
                                <tr>
                                    <td data-label="Task">
                                        <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                                        <?php if ($task['description']): ?>
                                            <br><small class="text-muted"><?php echo htmlspecialchars(substr($task['description'], 0, 50)) . '...'; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Project"><?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?></td>
                                    <td data-label="Priority">
                                        <?php 
                                        $priorityColors = ['low' => 'success', 'medium' => 'warning', 'high' => 'danger', 'critical' => 'dark'];
                                        $priorityColor = $priorityColors[$task['priority']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $priorityColor; ?>">
                                            <?php echo ucfirst($task['priority']); ?>
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <?php 
                                        $statusColors = ['to_do' => 'secondary', 'in_progress' => 'primary', 'done' => 'success', 'cancelled' => 'danger'];
                                        $statusColor = $statusColors[$task['status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $statusColor; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?>
                                        </span>
                                    </td>
                                    <td data-label="Due Date">
                                        <?php if ($task['due_date']): ?>
                                            <?php 
                                            $dueDate = new DateTime($task['due_date']);
                                            $now = new DateTime();
                                            $isOverdue = $dueDate < $now && $task['status'] !== 'done';
                                            ?>
                                            <span class="<?php echo $isOverdue ? 'text-danger' : 'text-muted'; ?>">
                                                <?php echo $dueDate->format('M j, Y'); ?>
                                                <?php if ($isOverdue): ?>
                                                    <i class="fas fa-exclamation-triangle ms-1"></i>
                                                <?php endif; ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">No due date</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Right Column -->
    <div class="col-lg-4 col-md-12">
        <!-- My Projects -->
        <?php if (!empty($user_projects)): ?>
        <div class="card shadow-lg mb-4 overflow-hidden">
            <div class="card-header position-relative" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none;">
                <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                    <h5 class="card-title mb-0 text-white fw-bold">
                        <i class="fas fa-project-diagram me-2"></i>
                        <?php _e('dashboard.my_projects'); ?>
                    </h5>
                    <?php if (in_array($currentUser['role'], ['admin', 'project_manager'])): ?>
                    <a href="index.php?url=projects" class="btn btn-light btn-sm shadow-sm hover-lift">
                        <i class="fas fa-external-link-alt me-1"></i><?php _e('dashboard.view_all'); ?>
                    </a>
                    <?php endif; ?>
                </div>

            </div>
            <div class="card-body p-3">
                <?php foreach ($user_projects as $project): ?>
                    <div class="project-item p-2 mb-2 bg-light rounded-2 hover-shadow transition-all">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($project['name']); ?></h6>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-calendar-alt me-1 text-muted" style="font-size: 0.75rem;"></i>
                                    <small class="text-muted" style="font-size: 0.75rem;">Due: <span class="fw-semibold"><?php echo date('M j, Y', strtotime($project['end_date'])); ?></span></small>
                                </div>
                            </div>
                            <div class="text-end ms-2">
                                <?php 
                                $progress = (float)($project['progress'] ?? 0);
                                if ($progress >= 100) {
                                    echo '<span class="badge bg-success" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">Selesai</span>';
                                } else {
                                    echo '<span class="badge bg-warning" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">Belum Selesai</span>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs bg-primary rounded-circle me-1" style="width: 18px; height: 18px;">
                                    <i class="fas fa-users" style="font-size: 0.6rem;"></i>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;">Team Project</small>
                            </div>
                            <a href="index.php?url=projects/view&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-primary hover-lift" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- My Bugs (for developers) -->
        <?php if (!empty($user_bugs) && in_array($currentUser['role'], ['developer', 'qa_tester'])): ?>
        <div class="card shadow-lg mb-4 overflow-hidden">
            <div class="card-header position-relative" style="background: #0ea5e9; border: none;">
                <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                    <h5 class="card-title mb-0 text-white fw-bold">
                        <i class="fas fa-bug me-2"></i>
                        <?php echo $currentUser['role'] === 'developer' ? 'Assigned Bugs' : 'Reported Bugs'; ?>
                    </h5>
                    <a href="index.php?url=bugs" class="btn btn-light btn-sm shadow-sm hover-lift">
                        <i class="fas fa-external-link-alt me-1"></i>View All
                    </a>
                </div>

            </div>
            <div class="card-body p-4">
                <?php foreach ($user_bugs as $bug): ?>
                    <div class="bug-item p-3 mb-3 bg-light rounded-3 hover-shadow transition-all border-start border-4 border-danger">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <h6 class="mb-2 fw-bold text-dark lh-sm"><?php echo htmlspecialchars($bug['title']); ?></h6>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <?php 
                                    $severityColors = ['critical' => 'danger', 'major' => 'warning', 'minor' => 'info', 'trivial' => 'secondary'];
                                    $severityColor = $severityColors[$bug['severity']] ?? 'secondary';
                                    $severityIcons = ['critical' => 'fas fa-exclamation-triangle', 'major' => 'fas fa-exclamation', 'minor' => 'fas fa-info', 'trivial' => 'fas fa-circle'];
                                    $severityIcon = $severityIcons[$bug['severity']] ?? 'fas fa-circle';
                                    ?>
                                    <span class="badge bg-<?php echo $severityColor; ?> d-flex align-items-center gap-1">
                                        <i class="<?php echo $severityIcon; ?> fa-xs"></i>
                                        <?php echo ucfirst($bug['severity']); ?>
                                    </span>
                                    <?php 
                                    $statusColors = ['new' => 'warning', 'assigned' => 'info', 'in_progress' => 'primary', 'resolved' => 'success', 'closed' => 'dark'];
                                    $statusColor = $statusColors[$bug['status']] ?? 'secondary';
                                    $statusIcons = ['new' => 'fas fa-plus', 'assigned' => 'fas fa-user', 'in_progress' => 'fas fa-cog', 'resolved' => 'fas fa-check', 'closed' => 'fas fa-times'];
                                    $statusIcon = $statusIcons[$bug['status']] ?? 'fas fa-circle';
                                    ?>
                                    <span class="badge bg-<?php echo $statusColor; ?> d-flex align-items-center gap-1">
                                        <i class="<?php echo $statusIcon; ?> fa-xs"></i>
                                        <?php echo ucfirst(str_replace('_', ' ', $bug['status'])); ?>
                                    </span>
                                </div>
                            </div>
                            <a href="index.php?url=bugs/view&id=<?php echo $bug['id']; ?>" class="btn btn-sm btn-outline-danger hover-lift ms-2">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between text-muted">
                            <small><i class="fas fa-clock me-1"></i>Updated <?php echo date('M j', strtotime($bug['updated_at'])); ?></small>
                            <small><i class="fas fa-hashtag me-1"></i><?php echo $bug['id']; ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Quick Actions -->
        <div class="card shadow-lg overflow-hidden">
            <div class="card-header position-relative" style="background: #0ea5e9; border: none;">
                <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                    <h5 class="card-title mb-0 text-white fw-bold">
                        <i class="fas fa-bolt me-2"></i>
                        <?php _e('dashboard.quick_actions'); ?>
                    </h5>

                </div>

            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <?php if (in_array($currentUser['role'], ['admin', 'project_manager'])): ?>
                        <a href="index.php?url=projects/create" class="btn btn-outline-primary btn-lg hover-lift d-flex align-items-center justify-content-start">
                            <div class="avatar-xs bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus fa-xs text-white"></i>
                            </div>
                            <span class="fw-semibold"><?php _e('dashboard.new_project'); ?></span>
                            <i class="fas fa-arrow-right ms-auto opacity-50"></i>
                        </a>
                    <?php endif; ?>
                    
                    <a href="index.php?url=tasks/create" class="btn btn-outline-success btn-lg hover-lift d-flex align-items-center justify-content-start">
                        <div class="avatar-xs bg-success rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-plus fa-xs text-white"></i>
                        </div>
                        <span class="fw-semibold"><?php _e('dashboard.new_task'); ?></span>
                        <i class="fas fa-arrow-right ms-auto opacity-50"></i>
                    </a>
                    
                    <a href="index.php?url=bugs/create" class="btn btn-outline-danger btn-lg hover-lift d-flex align-items-center justify-content-start">
                        <div class="avatar-xs bg-danger rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-bug fa-xs text-white"></i>
                        </div>
                        <span class="fw-semibold"><?php _e('dashboard.report_bug'); ?></span>
                        <i class="fas fa-arrow-right ms-auto opacity-50"></i>
                    </a>
                    
                    <?php if (in_array($currentUser['role'], ['qa_tester', 'admin'])): ?>
                        <a href="index.php?url=qa/test-cases/create" class="btn btn-outline-info btn-lg hover-lift d-flex align-items-center justify-content-start">
                            <div class="avatar-xs bg-info rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="fas fa-vial fa-xs text-white"></i>
                            </div>
                            <span class="fw-semibold"><?php _e('dashboard.new_test_case'); ?></span>
                            <i class="fas fa-arrow-right ms-auto opacity-50"></i>
                        </a>
                    <?php endif; ?>
                    
                    <hr class="my-3 opacity-25">
                    
                    <a href="index.php?url=profile" class="btn btn-outline-secondary btn-lg hover-lift d-flex align-items-center justify-content-start">
                        <div class="avatar-xs bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user fa-xs text-white"></i>
                        </div>
                        <span class="fw-semibold"><?php _e('dashboard.edit_profile'); ?></span>
                        <i class="fas fa-arrow-right ms-auto opacity-50"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // You can add AJAX calls here to refresh dashboard data
        console.log('Auto-refreshing dashboard data...');
    }, 300000);
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Add stagger animation to cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in');
        });
        
        // Add pulse animation to stat cards
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Force dark mode styling for tables and cards
        function applyDarkModeStyling() {
            if (document.body.classList.contains('dark-mode')) {
                // Apply dark mode styling to tables
                const tables = document.querySelectorAll('.dashboard-table, .table');
                tables.forEach(table => {
                    table.style.backgroundColor = '#334155';
                    table.style.color = '#e2e8f0';
                    
                    const headers = table.querySelectorAll('thead th');
                    headers.forEach(header => {
                        header.style.backgroundColor = '#475569';
                        header.style.color = '#e2e8f0';
                        header.style.borderColor = '#64748b';
                    });
                    
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        row.style.backgroundColor = '#334155';
                        row.style.color = '#e2e8f0';
                        const cells = row.querySelectorAll('td, th');
                        cells.forEach(cell => {
                            cell.style.backgroundColor = '#334155';
                            cell.style.color = '#e2e8f0';
                            cell.style.borderColor = '#64748b';
                        });
                    });
                });
                
                // Apply dark mode styling to card bodies
                const cardBodies = document.querySelectorAll('.card-body');
                cardBodies.forEach(cardBody => {
                    cardBody.style.backgroundColor = '#334155';
                });
                
                // Apply dark mode styling to activity items
                const activityItems = document.querySelectorAll('.dashboard-activity-item');
                activityItems.forEach(item => {
                    item.style.backgroundColor = '#334155';
                    item.style.color = '#e2e8f0';
                    item.style.borderColor = '#475569';
                });
                
                // Apply dark mode styling to project items
                const projectItems = document.querySelectorAll('.project-item');
                projectItems.forEach(item => {
                    item.style.backgroundColor = '#334155';
                    item.style.color = '#ffffff';
                    item.style.borderColor = '#475569';
                });
                
                // Apply dark mode styling to bug items
                const bugItems = document.querySelectorAll('.bug-item');
                bugItems.forEach(item => {
                    item.style.backgroundColor = '#334155';
                    item.style.color = '#e2e8f0';
                    item.style.borderColor = '#475569';
                });
            }
        }
        
        // Apply styling immediately
        applyDarkModeStyling();
        
        // Apply styling when theme changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    setTimeout(applyDarkModeStyling, 100);
                }
            });
        });
        
        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });
        
        // Existing JavaScript code...
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    });

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>