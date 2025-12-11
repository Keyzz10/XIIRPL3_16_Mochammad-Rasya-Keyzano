<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0 text-dark">
                <i class="fas fa-users me-3" style="color: #0ea5e9;"></i><?php _e('users.title'); ?>
            </h1>
            <p class="text-muted mb-0"><?php _e('users.subtitle'); ?></p>
        </div>
        <div class="btn-group">
            <a href="index.php?url=users/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i><?php _e('users.add_user'); ?>
            </a>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-2"></i><?php _e('users.export'); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><a class="dropdown-item" href="index.php?url=users/export/csv"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                    <li><a class="dropdown-item" href="index.php?url=users/export/excel"><i class="fas fa-file-excel me-2" style="color:#16a34a;"></i>Excel (.xls)</a></li>
                    <li><a class="dropdown-item" href="index.php?url=users/export/pdf" target="_blank"><i class="fas fa-file-pdf me-2" style="color:#dc2626;"></i>PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm hover-lift stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md rounded-circle me-3 d-flex align-items-center justify-content-center" style="background-color: #0ea5e9; width: 48px; height: 48px;">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <div class="h3 mb-0 fw-bold" style="color: #0ea5e9;"><?php echo count($users ?? []); ?></div>
                            <small class="text-muted fw-medium"><?php _e('users.total_users'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm hover-lift stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md rounded-circle me-3 d-flex align-items-center justify-content-center" style="background-color: #10b981; width: 48px; height: 48px;">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                        <div>
                            <div class="h3 mb-0 fw-bold" style="color: #10b981;"><?php echo $stats['active_users'] ?? 0; ?></div>
                            <small class="text-muted fw-medium"><?php _e('users.active_users'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm hover-lift stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md rounded-circle me-3 d-flex align-items-center justify-content-center" style="background-color: #0ea5e9; width: 48px; height: 48px;">
                            <i class="fas fa-user-shield text-white"></i>
                        </div>
                        <div>
                            <div class="h3 mb-0 fw-bold" style="color: #0ea5e9;"><?php echo $stats['admin_users'] ?? 0; ?></div>
                            <small class="text-muted fw-medium"><?php _e('users.admins'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm hover-lift stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md rounded-circle me-3 d-flex align-items-center justify-content-center" style="background-color: #0ea5e9; width: 48px; height: 48px;">
                            <i class="fas fa-sign-in-alt text-white"></i>
                        </div>
                        <div>
                            <div class="h3 mb-0 fw-bold" style="color: #0ea5e9;"><?php echo $stats['recent_logins'] ?? 0; ?></div>
                            <small class="text-muted fw-medium">Recent Logins</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-4">
            <h6 class="mb-0 fw-semibold text-dark">
                <i class="fas fa-filter me-2" style="color: #0ea5e9;"></i><?php _e('users.search_filter_title'); ?>
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0" style="border-color: #e2e8f0;">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" style="border-color: #e2e8f0;" placeholder="<?php echo __('users.search_placeholder'); ?>" id="userSearch">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" style="border-color: #e2e8f0;" id="roleFilter">
                        <option value=""><?php _e('users.all_roles'); ?></option>
                        <option value="super_admin">Super Admin</option>
                        <option value="admin"><?php echo __('roles.admin'); ?></option>
                        <option value="project_manager"><?php echo __('roles.project_manager'); ?></option>
                        <option value="developer"><?php echo __('roles.developer'); ?></option>
                        <option value="qa_tester"><?php echo __('roles.qa_tester'); ?></option>
                        <option value="client"><?php echo __('roles.client'); ?></option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" style="border-color: #e2e8f0;" id="statusFilter">
                        <option value=""><?php _e('users.all_status'); ?></option>
                        <option value="active"><?php _e('profile.active'); ?></option>
                        <option value="inactive"><?php _e('profile.inactive'); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-4">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="fas fa-table me-2" style="color: #0ea5e9;"></i><?php _e('users.all_users'); ?>
                </h5>
                <div class="text-muted small fw-medium">
                    <?php echo count($users ?? []); ?> <?php _e('users.total_users_label'); ?>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($users)): ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(14, 165, 233, 0.1); width: 80px; height: 80px;">
                            <i class="fas fa-users fa-2x" style="color: #0ea5e9;"></i>
                        </div>
                    </div>
                    <h5 class="text-dark mb-2 fw-semibold"><?php _e('users.empty_title'); ?></h5>
                    <p class="text-muted mb-4"><?php _e('users.empty_desc'); ?></p>
                    <a href="index.php?url=users/create" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-plus me-2"></i><?php _e('users.add_user'); ?>
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="usersTable">
                        <thead>
                            <tr style="border-bottom: 2px solid #64748b;">
                                <th class="border-0 fw-bold text-dark py-4 ps-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    <i class="fas fa-user me-2" style="color: #0ea5e9;"></i><?php _e('users.th_user'); ?>
                                </th>
                                <th class="border-0 fw-bold text-dark py-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    <i class="fas fa-envelope me-2" style="color: #0ea5e9;"></i><?php _e('users.th_contact'); ?>
                                </th>
                                <th class="border-0 fw-bold text-dark py-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    <i class="fas fa-user-tag me-2" style="color: #0ea5e9;"></i><?php _e('users.th_role'); ?>
                                </th>
                                <th class="border-0 fw-bold text-dark py-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    <i class="fas fa-circle me-2" style="color: #0ea5e9;"></i><?php _e('users.th_status'); ?>
                                </th>
                                <th class="border-0 fw-bold text-dark py-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    <i class="fas fa-clock me-2" style="color: #0ea5e9;"></i><?php _e('users.th_last_login'); ?>
                                </th>
                                <th class="border-0 fw-bold text-dark text-center py-4 pe-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); font-size: 0.875rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                    <i class="fas fa-cogs me-2" style="color: #0ea5e9;"></i><?php _e('users.th_actions'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                        <?php 
                        // Determine specific permissions for this user
                        $canEditThisUser = $canEdit;
                        $canDeleteThisUser = $canDelete;
                        
                        // Super admin restrictions
                        if ($user['role'] === 'super_admin') {
                            $canEditThisUser = ($currentUser['role'] === 'super_admin');
                            $canDeleteThisUser = false; // Never allow deletion of super_admin
                        }
                        
                        // Admin restrictions
                        if ($user['role'] === 'admin') {
                            $canEditThisUser = ($currentUser['role'] === 'super_admin') || ($currentUser['id'] == $user['id']);
                            $canDeleteThisUser = ($currentUser['role'] === 'super_admin') && ($stats['admin_users'] > 1);
                        }
                        ?>
                        <tr class="border-bottom user-row" style="border-color: #e2e8f0 !important; transition: all 0.3s ease;">
                            <td class="py-4 ps-4" style="background-color: rgba(248, 250, 252, 0.5);">
                                <div class="d-flex align-items-center">
                                    <?php if ($user['profile_photo']): ?>
                                        <img src="<?php echo UPLOADS_URL . '/' . $user['profile_photo']; ?>" 
                                             class="rounded-circle me-3 shadow-sm" 
                                             style="width: 52px; height: 52px; object-fit: cover; border: 3px solid #e2e8f0;" 
                                             alt="Profile">
                                    <?php else: ?>
                                        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" 
                                             style="width: 52px; height: 52px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); font-size: 20px; border: 3px solid #e2e8f0;">
                                            <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.1rem; line-height: 1.3;"><?php echo htmlspecialchars($user['full_name']); ?></div>
                                        <small class="text-muted fw-medium" style="font-size: 0.85rem;">@<?php echo htmlspecialchars($user['username']); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4" style="background-color: rgba(248, 250, 252, 0.3);">
                                <div>
                                    <div class="text-dark mb-1 fw-semibold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($user['email']); ?></div>
                                    <?php if ($user['phone']): ?>
                                        <small class="text-muted fw-medium d-flex align-items-center" style="font-size: 0.8rem;">
                                            <i class="fas fa-phone fa-xs me-2" style="color: #0ea5e9;"></i><?php echo htmlspecialchars($user['phone']); ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="py-4" style="background-color: rgba(248, 250, 252, 0.2);">
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
                                <span class="badge bg-<?php echo $roleColor; ?> px-3 py-2 fw-semibold shadow-sm" style="font-size: 0.8rem; border-radius: 20px;">
                                    <?php if ($user['role'] === 'super_admin'): ?>
                                        <i class="fas fa-crown me-1"></i>
                                    <?php elseif ($user['role'] === 'admin'): ?>
                                        <i class="fas fa-user-shield me-1"></i>
                                    <?php endif; ?>
                                    <?php echo $roleText; ?>
                                </span>
                            </td>
                            <td class="py-4" style="background-color: rgba(248, 250, 252, 0.1);">
                                <?php if ($user['status'] === 'active'): ?>
                                    <span class="badge bg-success px-3 py-2 fw-semibold shadow-sm d-flex align-items-center justify-content-center" style="font-size: 0.8rem; border-radius: 20px; width: fit-content;">
                                        <i class="fas fa-circle fa-xs me-1" style="color: #ffffff;"></i><?php _e('profile.active'); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-2 fw-semibold shadow-sm d-flex align-items-center justify-content-center" style="font-size: 0.8rem; border-radius: 20px; width: fit-content;">
                                        <i class="fas fa-circle fa-xs me-1" style="color: #ffffff;"></i><?php _e('profile.inactive'); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4" style="background-color: rgba(248, 250, 252, 0.05);">
                                <?php if ($user['last_login']): ?>
                                    <?php 
                                    $lastLogin = new DateTime($user['last_login']);
                                    ?>
                                    <div class="text-dark fw-semibold" style="font-size: 0.9rem;"><?php echo $lastLogin->format('M j, Y'); ?></div>
                                    <small class="text-muted fw-medium" style="font-size: 0.8rem;"><?php echo $lastLogin->format('g:i A'); ?></small>
                                <?php else: ?>
                                    <div class="text-muted fw-semibold" style="font-size: 0.9rem;"><?php _e('users.never_logged_in'); ?></div>
                                    <small class="text-muted" style="font-size: 0.75rem;"><?php _e('users.first_time_user'); ?></small>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 text-center pe-4" style="background-color: rgba(248, 250, 252, 0.3);">
                                <div class="btn-group shadow-sm" role="group" style="border-radius: 10px; overflow: hidden;">
                                    <a href="index.php?url=users/activity/<?php echo $user['id']; ?>" 
                                       class="btn btn-outline-info btn-sm px-3 py-2" 
                                       title="View Activity" 
                                       data-bs-toggle="tooltip"
                                       style="border-radius: 8px 0 0 8px; border-color: #0ea5e9; color: #0ea5e9;">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    
                                    <?php if ($canEditThisUser): ?>
                                        <a href="index.php?url=users/edit/<?php echo $user['id']; ?>" 
                                           class="btn btn-outline-primary btn-sm px-3 py-2" title="Edit User" data-bs-toggle="tooltip"
                                           style="border-radius: 0; border-color: #0ea5e9; color: #0ea5e9; border-left: 0;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-outline-secondary btn-sm px-3 py-2" disabled title="Cannot edit this user" data-bs-toggle="tooltip"
                                                style="border-radius: 0; border-left: 0;">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($user['status'] === 'active' && $canEditThisUser): ?>
                                        <button class="btn btn-outline-warning btn-sm px-3 py-2" 
                                                onclick="toggleUserStatus(<?php echo $user['id']; ?>, 'deactivate')"
                                                title="Deactivate User" data-bs-toggle="tooltip"
                                                style="border-radius: 0; border-left: 0;">
                                            <i class="fas fa-user-times"></i>
                                        </button>
                                    <?php elseif ($user['status'] !== 'active' && $canEditThisUser): ?>
                                        <button class="btn btn-outline-success btn-sm px-3 py-2" 
                                                onclick="toggleUserStatus(<?php echo $user['id']; ?>, 'activate')"
                                                title="Activate User" data-bs-toggle="tooltip"
                                                style="border-radius: 0; border-left: 0;">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($canDeleteThisUser): ?>
                                        <button class="btn btn-outline-danger btn-sm px-3 py-2" 
                                                onclick="deleteUser(<?php echo $user['id']; ?>)"
                                                title="Delete User" data-bs-toggle="tooltip"
                                                style="border-radius: 0 8px 8px 0; border-left: 0;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-secondary btn-sm px-3 py-2" disabled 
                                                title="<?php echo $user['role'] === 'super_admin' ? 'Cannot delete Super Admin' : ($user['role'] === 'admin' && $stats['admin_users'] <= 1 ? 'Cannot delete the only admin' : 'Cannot delete this user'); ?>" data-bs-toggle="tooltip"
                                                style="border-radius: 0 8px 8px 0; border-left: 0;">
                                            <i class="fas fa-shield-alt"></i>
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
</div>

<!-- Deactivate User Confirmation Modal -->
<div class="modal fade" id="deactivateUserModal" tabindex="-1" aria-labelledby="deactivateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-warning text-white">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="fas fa-user-times fa-lg text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="deactivateUserModalLabel">Konfirmasi Deactivate User</h5>
                        <small class="text-white-50">Konfirmasi Deactivate User</small>
                    </div>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="text-center">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-question-circle fa-2x text-warning"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-3">Apakah Anda yakin ingin deactivate user ini?</h6>
                    <p class="text-muted mb-0">User akan diubah statusnya menjadi inactive dan tidak dapat mengakses sistem.</p>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal" id="cancelDeactivateBtn">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-warning btn-lg px-4" onclick="proceedDeactivate()" id="confirmDeactivateBtn">
                    <i class="fas fa-user-times me-2"></i>Deactivate
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Activate User Confirmation Modal -->
<div class="modal fade" id="activateUserModal" tabindex="-1" aria-labelledby="activateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-success text-white">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="fas fa-user-check fa-lg text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="activateUserModalLabel">Konfirmasi Activate User</h5>
                        <small class="text-white-50">Konfirmasi Activate User</small>
                    </div>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="text-center">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-question-circle fa-2x text-success"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-3">Apakah Anda yakin ingin activate user ini?</h6>
                    <p class="text-muted mb-0">User akan diubah statusnya menjadi active dan dapat mengakses sistem.</p>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal" id="cancelActivateBtn">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-success btn-lg px-4" onclick="proceedActivate()" id="confirmActivateBtn">
                    <i class="fas fa-user-check me-2"></i>Activate
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-danger text-white">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="fas fa-trash fa-lg text-white"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="deleteUserModalLabel">Konfirmasi Delete User</h5>
                        <small class="text-white-50">Konfirmasi Delete User</small>
                    </div>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="text-center">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-question-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-3">Apakah Anda yakin ingin menghapus user ini?</h6>
                    <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan. User akan dihapus dari sistem.</p>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal" id="cancelDeleteBtn">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-danger btn-lg px-4" onclick="proceedDelete()" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Delete
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced Users Page Styling */
.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Modal Styles for User Actions */
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #198754 0%, #157347 100%);
}

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

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3);
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

.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(14, 165, 233, 0.2) !important;
}

/* Ensure statistic cards have consistent height */
.stats-card {
    min-height: 130px;
}

#usersTable tbody tr.user-row {
    transition: all 0.3s ease;
    position: relative;
}

#usersTable tbody tr.user-row:hover {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.08) 0%, rgba(14, 165, 233, 0.04) 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(14, 165, 233, 0.15);
}

#usersTable tbody tr.user-row:hover td {
    background-color: transparent !important;
}

.btn-group .btn {
    border-radius: 6px !important;
    margin: 0 1px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-width: 1.5px;
}

.btn-group .btn:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    z-index: 10;
}

.btn-group {
    gap: 2px;
}

.card {
    transition: all 0.3s ease;
    border-radius: 16px !important;
}

.input-group-text {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
    border-color: #e2e8f0 !important;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.15) !important;
    transform: translateY(-1px);
}

.badge {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.025em;
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

.avatar-md {
    font-size: 16px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.table thead th {
    position: relative;
    overflow: hidden;
}

.table thead th::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.1), transparent);
    transition: left 0.5s;
}

.table thead th:hover::before {
    left: 100%;
}

/* Advanced dark mode support */
body.dark-mode .table thead th {
    background: linear-gradient(135deg, #475569 0%, #3f4c59 100%) !important;
    border-bottom: 2px solid #0ea5e9 !important;
}

body.dark-mode .table tbody tr.user-row:hover {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0.08) 100%) !important;
}

body.dark-mode .table tbody tr.user-row td {
    background-color: rgba(51, 65, 85, 0.3) !important;
}

body.dark-mode .table tbody tr.user-row:hover td {
    background-color: transparent !important;
}

body.dark-mode .input-group-text {
    background: linear-gradient(135deg, #475569 0%, #3f4c59 100%) !important;
    border-color: #64748b !important;
    color: #e2e8f0;
}

body.dark-mode .form-control,
body.dark-mode .form-select {
    background-color: #475569 !important;
    border-color: #64748b !important;
    color: #e2e8f0 !important;
}

body.dark-mode .form-control:focus,
body.dark-mode .form-select:focus {
    background-color: #475569 !important;
    border-color: #0ea5e9 !important;
    color: #e2e8f0 !important;
    box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.25) !important;
}

body.dark-mode .card-header {
    background: linear-gradient(135deg, #475569 0%, #3f4c59 100%) !important;
    border-color: #64748b !important;
}

body.dark-mode .border-bottom {
    border-color: #475569 !important;
}

body.dark-mode .text-center .rounded-circle {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.3) 0%, rgba(14, 165, 233, 0.2) 100%) !important;
}

body.dark-mode .btn-outline-info,
body.dark-mode .btn-outline-primary,
body.dark-mode .btn-outline-warning,
body.dark-mode .btn-outline-success,
body.dark-mode .btn-outline-danger,
body.dark-mode .btn-outline-secondary {
    border-color: currentColor;
    background-color: rgba(51, 65, 85, 0.3);
    backdrop-filter: blur(10px);
}

body.dark-mode .btn-outline-info:hover,
body.dark-mode .btn-outline-primary:hover,
body.dark-mode .btn-outline-warning:hover,
body.dark-mode .btn-outline-success:hover,
body.dark-mode .btn-outline-danger:hover {
    background-color: currentColor;
    color: white;
    box-shadow: 0 4px 20px rgba(14, 165, 233, 0.3);
}

body.dark-mode .btn-outline-secondary:hover {
    background-color: #64748b;
    border-color: #64748b;
    color: white;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .btn-group .btn {
        padding: 0.5rem;
        font-size: 0.875rem;
    }
    
    .user-row td {
        padding: 1rem 0.5rem !important;
    }
}

/* Dark mode support for users page */
body.dark-mode .table tbody tr:hover {
    background-color: rgba(14, 165, 233, 0.1) !important;
}

body.dark-mode .input-group-text {
    background-color: #475569 !important;
    border-color: #64748b !important;
    color: #e2e8f0;
}

body.dark-mode .form-control,
body.dark-mode .form-select {
    background-color: #475569 !important;
    border-color: #64748b !important;
    color: #e2e8f0 !important;
}

body.dark-mode .form-control:focus,
body.dark-mode .form-select:focus {
    background-color: #475569 !important;
    border-color: #0ea5e9 !important;
    color: #e2e8f0 !important;
}

/* Dark mode for card headers and table headers */
body.dark-mode .card-header {
    background-color: #475569 !important;
    border-color: #64748b !important;
}

body.dark-mode thead {
    background-color: #475569 !important;
}

body.dark-mode thead th {
    background-color: #475569 !important;
    color: #e2e8f0 !important;
    border-color: #64748b !important;
}

/* Dark mode for table borders */
body.dark-mode .table tbody tr {
    border-color: #475569 !important;
}

body.dark-mode .border-bottom {
    border-color: #475569 !important;
}

/* Dark mode for empty state */
body.dark-mode .text-center .rounded-circle {
    background-color: rgba(14, 165, 233, 0.2) !important;
}

/* Dark mode for action buttons */
body.dark-mode .btn-outline-info,
body.dark-mode .btn-outline-primary,
body.dark-mode .btn-outline-warning,
body.dark-mode .btn-outline-success,
body.dark-mode .btn-outline-danger,
body.dark-mode .btn-outline-secondary {
    border-color: currentColor;
    background-color: transparent;
}

body.dark-mode .btn-outline-info:hover,
body.dark-mode .btn-outline-primary:hover,
body.dark-mode .btn-outline-warning:hover,
body.dark-mode .btn-outline-success:hover,
body.dark-mode .btn-outline-danger:hover {
    background-color: currentColor;
    color: white;
}

body.dark-mode .btn-outline-secondary:hover {
    background-color: #64748b;
    border-color: #64748b;
    color: white;
}
</style>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Search functionality
document.getElementById('userSearch').addEventListener('input', function() {
    filterTable();
});

document.getElementById('roleFilter').addEventListener('change', function() {
    filterTable();
});

document.getElementById('statusFilter').addEventListener('change', function() {
    filterTable();
});

function filterTable() {
    const searchTerm = document.getElementById('userSearch').value.toLowerCase();
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const table = document.getElementById('usersTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const name = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        const role = row.cells[2].textContent.toLowerCase();
        const status = row.cells[3].textContent.toLowerCase();

        const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
        const matchesRole = !roleFilter || role.includes(roleFilter.replace('_', ' '));
        const matchesStatus = !statusFilter || status.includes(statusFilter);

        if (matchesSearch && matchesRole && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Global variables to store current user ID and action
let currentUserId = null;
let currentAction = null;

function toggleUserStatus(userId, action) {
    currentUserId = userId;
    currentAction = action;
    
    if (action === 'deactivate') {
        showDeactivateModal();
    } else if (action === 'activate') {
        showActivateModal();
    }
}

function deleteUser(userId) {
    currentUserId = userId;
    showDeleteModal();
}

function showDeactivateModal() {
    const modal = document.getElementById('deactivateUserModal');
    if (modal) {
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }
}

function showActivateModal() {
    const modal = document.getElementById('activateUserModal');
    if (modal) {
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }
}

function showDeleteModal() {
    const modal = document.getElementById('deleteUserModal');
    if (modal) {
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }
}

function proceedDeactivate() {
    // Add loading effect
    const deactivateBtn = document.getElementById('confirmDeactivateBtn');
    const cancelBtn = document.getElementById('cancelDeactivateBtn');
    
    deactivateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
    deactivateBtn.disabled = true;
    cancelBtn.disabled = true;
    
    fetch(`index.php?url=users/deactivate/${currentUserId}`, {
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
            alert(data.error || 'An error occurred');
            // Reset button state
            deactivateBtn.innerHTML = '<i class="fas fa-user-times me-2"></i>Deactivate';
            deactivateBtn.disabled = false;
            cancelBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
        // Reset button state
        deactivateBtn.innerHTML = '<i class="fas fa-user-times me-2"></i>Deactivate';
        deactivateBtn.disabled = false;
        cancelBtn.disabled = false;
    });
}

function proceedDelete() {
    // Add loading effect
    const deleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
    deleteBtn.disabled = true;
    cancelBtn.disabled = true;
    
    fetch(`index.php?url=users/delete/${currentUserId}`, {
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
            alert(data.error || 'An error occurred');
            // Reset button state
            deleteBtn.innerHTML = '<i class="fas fa-trash me-2"></i>Delete';
            deleteBtn.disabled = false;
            cancelBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
        // Reset button state
        deleteBtn.innerHTML = '<i class="fas fa-trash me-2"></i>Delete';
        deleteBtn.disabled = false;
        cancelBtn.disabled = false;
    });
}

function proceedActivate() {
    // Add loading effect
    const activateBtn = document.getElementById('confirmActivateBtn');
    const cancelBtn = document.getElementById('cancelActivateBtn');
    
    activateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
    activateBtn.disabled = true;
    cancelBtn.disabled = true;
    
    fetch(`index.php?url=users/activate/${currentUserId}`, {
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
            alert(data.error || 'An error occurred');
            // Reset button state
            activateBtn.innerHTML = '<i class="fas fa-user-check me-2"></i>Activate';
            activateBtn.disabled = false;
            cancelBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
        // Reset button state
        activateBtn.innerHTML = '<i class="fas fa-user-check me-2"></i>Activate';
        activateBtn.disabled = false;
        cancelBtn.disabled = false;
    });
}
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>