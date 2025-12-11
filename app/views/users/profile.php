<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-primary fw-bold">
            <i class="fas fa-user-circle me-3"></i><?php _e('profile.title'); ?>
        </h1>
        <p class="text-muted mb-0 fs-5"><?php _e('profile.subtitle'); ?></p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-gradient-primary fs-6 px-4 py-3 rounded-pill shadow-lg text-dark role-badge">
            <?php if (in_array($user['role'], ['super_admin', 'admin'])): ?>
                <i class="fas fa-crown me-2 text-warning"></i>
            <?php else: ?>
                <i class="fas fa-user-shield me-2"></i>
            <?php endif; ?>
            <?php echo ucfirst(str_replace('_', ' ', $user['role'])); ?>
        </span>
    </div>
</div>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($errors['update'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?php echo $errors['update']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-id-card me-2 text-primary"></i><?php _e('profile.profile_information'); ?>
                </h5>
            </div>
            <div class="card-body text-center p-4">
                <div class="mb-4">
                    <?php if ($user['profile_photo']): ?>
                        <img src="<?php echo UPLOADS_URL . '/' . $user['profile_photo']; ?>" 
                             class="rounded-circle mb-3 shadow" 
                             alt="Profile Photo"
                             id="profileImage"
                             style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">
                    <?php else: ?>
                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mb-3 mx-auto shadow-sm" 
                             style="width: 120px; height: 120px; border: 3px solid #e9ecef !important;">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h5 class="card-title"><?php echo htmlspecialchars($user['full_name']); ?></h5>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                
                <div class="d-flex justify-content-center align-items-center mb-4 gap-2">
                    <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill text-dark role-badge">
                        <?php if (in_array($user['role'], ['super_admin', 'admin'])): ?>
                            <i class="fas fa-crown me-1 text-warning"></i>
                        <?php else: ?>
                            <i class="fas fa-user-tag me-1"></i>
                        <?php endif; ?>
                        <?php echo ucfirst(str_replace('_', ' ', $user['role'])); ?>
                    </span>
                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill" title="Info Role" data-bs-toggle="modal" data-bs-target="#roleInfoModal">
                        <i class="fas fa-circle-info"></i>
                    </button>
                </div>
                
                <hr class="my-3">
                
                <div class="row text-center">
                    <div class="col-4">
                        <div class="text-muted"><?php _e('profile.status'); ?></div>
                        <strong class="text-<?php echo $user['status'] === 'active' ? 'success' : 'danger'; ?>">
                            <?php echo $user['status'] === 'active' ? __('profile.active') : __('profile.inactive'); ?>
                        </strong>
                    </div>
                    <div class="col-4">
                        <div class="text-muted"><?php _e('profile.member_since'); ?></div>
                        <strong><?php echo date('d M Y', strtotime($user['created_at'])); ?></strong>
                    </div>
                    <div class="col-4">
                        <div class="text-muted"><?php _e('profile.last_login'); ?></div>
                        <strong>
                            <?php if ($user['last_login']): ?>
                                <?php echo date('M j', strtotime($user['last_login'])); ?>
                            <?php else: ?>
                                <?php _e('profile.never'); ?>
                            <?php endif; ?>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card shadow-lg">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-chart-bar me-2 text-info"></i>
                    <?php _e('profile.statistics'); ?>
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded border stat-item">
                    <span class="text-dark fw-bold">
                        <i class="fas fa-tasks me-2 text-primary"></i>
                        <?php _e('profile.total_tasks'); ?>
                    </span>
                    <span class="badge bg-primary fs-6"><?php echo $userStats['total_tasks'] ?? 0; ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded border stat-item">
                    <span class="text-dark fw-bold">
                        <i class="fas fa-check-circle me-2 text-success"></i>
                        <?php _e('profile.completed_tasks'); ?>
                    </span>
                    <span class="badge bg-success fs-6"><?php echo $userStats['completed_tasks'] ?? 0; ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded border stat-item">
                    <span class="text-dark fw-bold">
                        <i class="fas fa-bug me-2 text-danger"></i>
                        <?php _e('profile.bugs_reported'); ?>
                    </span>
                    <span class="badge bg-danger fs-6"><?php echo $userStats['bugs_reported'] ?? 0; ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded border stat-item">
                    <span class="text-dark fw-bold">
                        <i class="fas fa-project-diagram me-2 text-info"></i>
                        <?php _e('profile.active_projects'); ?>
                    </span>
                    <span class="badge bg-info fs-6"><?php echo $userStats['active_projects'] ?? 0; ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Profile Form -->
        <div class="card shadow-lg">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-user-edit me-2 text-success"></i>
                    <?php _e('profile.edit_profile'); ?>
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data" id="profileForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label"><?php _e('profile.full_name'); ?> *</label>
                                <input type="text" 
                                       class="form-control <?php echo isset($errors['full_name']) ? 'is-invalid' : ''; ?>" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="<?php echo htmlspecialchars($user['full_name']); ?>" 
                                       required>
                                <?php if (isset($errors['full_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['full_name']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label"><?php _e('profile.email_address'); ?> *</label>
                                <input type="email" 
                                       class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" 
                                       readonly 
                                       required>
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['email']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label"><?php _e('profile.username'); ?></label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" 
                                           id="username" 
                                           name="username"
                                           value="<?php echo htmlspecialchars($user['username']); ?>" 
                                           readonly>
                                    <button type="button" class="btn btn-outline-primary" id="editUsernameBtn">
                                        <i class="fas fa-edit"></i> <?php _e('profile.change_username'); ?>
                                    </button>
                                </div>
                                <?php if (isset($errors['username'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['username']; ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted" id="usernameHelp">
                                    <?php 
                                    $lastChanged = $user['username_last_changed'] ?? null;
                                    if ($lastChanged) {
                                        $daysSince = floor((time() - strtotime($lastChanged)) / (60 * 60 * 24));
                                        $daysRemaining = 90 - $daysSince;
                                        if ($daysRemaining > 0) {
                                            echo sprintf(__('profile.username_cooldown'), $daysRemaining);
                                        } else {
                                            echo __('profile.username_can_change');
                                        }
                                    } else {
                                        echo __('profile.username_can_change');
                                    }
                                    ?>
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label"><?php _e('profile.phone_number'); ?></label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone" 
                                       value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" 
                                       placeholder="<?php _e('profile.phone_placeholder'); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="profile_photo" class="form-label"><?php _e('profile.profile_photo'); ?></label>
                        <div class="custom-file-upload">
                            <input type="file" 
                                   class="form-control <?php echo isset($errors['profile_photo']) ? 'is-invalid' : ''; ?>" 
                                   id="profile_photo" 
                                   name="profile_photo" 
                                   accept="image/*">
                            <div class="file-upload-overlay">
                                <i class="fas fa-camera me-2"></i>
                                <span class="file-text">Choose Profile Photo</span>
                            </div>
                        </div>
                        <small class="text-muted"><?php _e('profile.photo_formats'); ?></small>
                        <?php if (isset($errors['profile_photo'])): ?>
                            <div class="invalid-feedback">
                                <?php echo $errors['profile_photo']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h6 class="mb-3"><?php _e('profile.change_password'); ?></h6>
                    
                    <div class="row password-row align-items-start">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="current_password" class="form-label"><?php _e('profile.current_password'); ?></label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?php echo isset($errors['current_password']) ? 'is-invalid' : ''; ?>" 
                                           id="current_password" 
                                           name="current_password" 
                                           placeholder="<?php _e('profile.enter_current_password'); ?>">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                        <i class="fas fa-eye" id="toggleCurrentPasswordIcon"></i>
                                    </button>
                                </div>
                                <?php if (isset($errors['current_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['current_password']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="new_password" class="form-label"><?php _e('profile.new_password'); ?></label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?php echo isset($errors['new_password']) ? 'is-invalid' : ''; ?>" 
                                           id="new_password" 
                                           name="new_password" 
                                           placeholder="<?php _e('profile.enter_new_password'); ?>">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                        <i class="fas fa-eye" id="toggleNewPasswordIcon"></i>
                                    </button>
                                </div>
                                <?php if (isset($errors['new_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['new_password']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4 d-flex flex-column">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label"><?php _e('profile.confirm_password'); ?></label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           placeholder="<?php _e('profile.confirm_new_password'); ?>">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                                    </button>
                                </div>
                                <?php if (isset($errors['confirm_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['confirm_password']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="window.location.reload()">
                            <i class="fas fa-times me-2"></i><?php _e('common.cancel'); ?>
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="saveButton">
                            <i class="fas fa-save me-2"></i><?php _e('common.save'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview profile photo
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileUpload = document.querySelector('.custom-file-upload');
        const fileText = document.querySelector('.file-text');
        
        if (file) {
            // Update file upload UI
            fileUpload.classList.add('file-selected');
            fileText.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const profileImage = document.getElementById('profileImage');
                if (profileImage) {
                    profileImage.src = e.target.result;
                } else {
                    // Create new image element if none exists
                    const container = document.querySelector('.card-body .mb-4');
                    container.innerHTML = `<img src="${e.target.result}" class="rounded-circle mb-3 shadow" alt="Profile Photo" id="profileImage" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e9ecef;">`;
                }
            };
            reader.readAsDataURL(file);
        } else {
            // Reset file upload UI
            fileUpload.classList.remove('file-selected');
            fileText.textContent = 'Choose Profile Photo';
            
            // If file input is cleared, restore original profile photo
            const profileImage = document.getElementById('profileImage');
            if (profileImage) {
                <?php if ($user['profile_photo']): ?>
                profileImage.src = '<?php echo UPLOADS_URL . '/' . $user['profile_photo']; ?>';
                <?php else: ?>
                // Restore default avatar if no photo exists
                const container = document.querySelector('.card-body .mb-4');
                container.innerHTML = `<div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mb-3 mx-auto shadow-sm" style="width: 120px; height: 120px; border: 3px solid #e9ecef !important;"><i class="fas fa-user fa-3x text-muted"></i></div>`;
                <?php endif; ?>
            }
        }
    });
    
    // Form validation
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        // If any password field is filled, all must be filled
        if (currentPassword || newPassword || confirmPassword) {
            if (!currentPassword) {
                e.preventDefault();
                alert('Please enter your current password');
                return false;
            }
            
            if (!newPassword) {
                e.preventDefault();
                alert('Please enter a new password');
                return false;
            }
            
            if (!confirmPassword) {
                e.preventDefault();
                alert('Please confirm your new password');
                return false;
            }
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New password and confirmation do not match');
                return false;
            }
            
            if (newPassword.length < 8) {
                e.preventDefault();
                alert('New password must be at least 8 characters long');
                return false;
            }
        }
        
        // Show loading state
        const saveButton = document.getElementById('saveButton');
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><?php _e("common.saving"); ?>...';
    });
    
    // Password toggle functionality
    document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('current_password');
        const toggleIcon = document.getElementById('toggleCurrentPasswordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
    
    document.getElementById('toggleNewPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('new_password');
        const toggleIcon = document.getElementById('toggleNewPasswordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
    
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('confirm_password');
        const toggleIcon = document.getElementById('toggleConfirmPasswordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
</script>

<script>
    // Clear file input on page load to prevent conflicts
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('profile_photo');
        if (fileInput) {
            fileInput.value = ''; // Clear any cached file selection
        }
        
        // Ensure profile image displays correctly after page reload
        const profileImage = document.getElementById('profileImage');
        if (profileImage && profileImage.src) {
            // Force reload the image to ensure it displays correctly
            const originalSrc = profileImage.src;
            profileImage.src = '';
            setTimeout(function() {
                profileImage.src = originalSrc;
            }, 10);
        }
    });
</script>

<style>
    /* Enhanced File Upload Styling */
    .custom-file-upload {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .custom-file-upload input[type="file"] {
        opacity: 0;
        position: absolute;
        z-index: 2;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-upload-overlay {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        border: 2px dashed var(--border-color, #e2e8f0);
        border-radius: 8px;
        background-color: var(--bg-light, #f8fafc);
        color: var(--text-muted, #64748b);
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .custom-file-upload:hover .file-upload-overlay {
        border-color: var(--primary-color, #0ea5e9);
        background-color: rgba(14, 165, 233, 0.05);
        color: var(--primary-color, #0ea5e9);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
    }
    
    .custom-file-upload.file-selected .file-upload-overlay {
        border-color: #28a745;
        background-color: rgba(40, 167, 69, 0.05);
        color: #28a745;
    }
    
    .file-upload-overlay i {
        font-size: 16px;
    }
    
    /* Language Settings Card - Dark Mode Fix */
    .language-settings-card {
        background-color: var(--bg-light, #f8fafc) !important;
    }
    
    /* Dark Mode Styles */
    body.dark-mode .language-settings-card {
        background-color: var(--secondary-color, #334155) !important;
    }
    
    body.dark-mode .file-upload-overlay {
        background-color: var(--secondary-color, #334155);
        border-color: var(--border-color, #475569);
        color: var(--text-muted, #94a3b8);
    }
    
    body.dark-mode .custom-file-upload:hover .file-upload-overlay {
        border-color: var(--primary-color, #0ea5e9);
        background-color: rgba(14, 165, 233, 0.1);
        color: var(--primary-color, #0ea5e9);
    }
    
    body.dark-mode .custom-file-upload.file-selected .file-upload-overlay {
        border-color: #28a745;
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    /* Align password inputs nicely even in dark mode */
    .password-row .input-group .form-control { height: 48px; }
    .password-row .input-group .btn { height: 48px; }
    /* Make all labels the same height so inputs align horizontally */
    .password-row .form-label { display: flex; align-items: flex-end; min-height: 48px; margin-bottom: 8px; }

    /* Ensure role text is visible in light mode on gradient badges */
    .role-badge { color: #0f172a !important; mix-blend-mode: normal; }
    body.dark-mode .role-badge { color: #e2e8f0 !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Profile page loaded');
    
    const editUsernameBtn = document.getElementById('editUsernameBtn');
    const usernameInput = document.getElementById('username');
    const usernameHelp = document.getElementById('usernameHelp');
    
    console.log('Edit button:', editUsernameBtn);
    console.log('Username input:', usernameInput);
    console.log('Username help:', usernameHelp);
    console.log('SweetAlert available:', typeof Swal !== 'undefined');
    
    if (editUsernameBtn) {
        console.log('Adding click event listener to edit button');
        editUsernameBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Edit username button clicked');
            // Check if user can change username (90-day rule)
            <?php 
            $lastChanged = $user['username_last_changed'] ?? null;
            $canChange = true;
            $daysRemaining = 0;
            
            if ($lastChanged) {
                $daysSince = floor((time() - strtotime($lastChanged)) / (60 * 60 * 24));
                $daysRemaining = 90 - $daysSince;
                $canChange = $daysRemaining <= 0;
            }
            ?>
            
            const canChange = <?php echo $canChange ? 'true' : 'false'; ?>;
            const daysRemaining = <?php echo $daysRemaining; ?>;
            
            if (!canChange) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: '<?php _e("profile.username_change_restricted"); ?>',
                        text: `<?php _e("profile.username_change_wait"); ?> ${daysRemaining} <?php _e("profile.days"); ?>`,
                        confirmButtonText: '<?php _e("common.ok"); ?>'
                    });
                } else {
                    alert(`<?php _e("profile.username_change_wait"); ?> ${daysRemaining} <?php _e("profile.days"); ?>`);
                }
                return;
            }
            
            // Show confirmation dialog
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                icon: 'warning',
                title: '<?php _e("profile.confirm_username_change"); ?>',
                html: `
                    <p><?php _e("profile.username_change_warning"); ?></p>
                    <p><strong><?php _e("profile.username_change_90day_rule"); ?></strong></p>
                    <p><?php _e("profile.username_change_confirm"); ?></p>
                `,
                showCancelButton: true,
                confirmButtonText: '<?php _e("profile.yes_change_username"); ?>',
                cancelButtonText: '<?php _e("common.cancel"); ?>',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enable username input
                    usernameInput.removeAttribute('readonly');
                    usernameInput.focus();
                    usernameInput.select();
                    
                    // Change button text and functionality
                    editUsernameBtn.innerHTML = '<i class="fas fa-times"></i> <?php _e("common.cancel"); ?>';
                    editUsernameBtn.classList.remove('btn-outline-primary');
                    editUsernameBtn.classList.add('btn-outline-secondary');
                    
                    // Update help text
                    usernameHelp.innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> <?php _e("profile.username_editing_mode"); ?>';
                    
                    // Change button functionality to cancel
                    editUsernameBtn.onclick = function() {
                        // Reset to original state
                        usernameInput.value = '<?php echo htmlspecialchars($user['username']); ?>';
                        usernameInput.setAttribute('readonly', true);
                        
                        editUsernameBtn.innerHTML = '<i class="fas fa-edit"></i> <?php _e("profile.change_username"); ?>';
                        editUsernameBtn.classList.remove('btn-outline-secondary');
                        editUsernameBtn.classList.add('btn-outline-primary');
                        
                        // Reset help text
                        usernameHelp.innerHTML = `<?php 
                        if ($lastChanged) {
                            $daysSince = floor((time() - strtotime($lastChanged)) / (60 * 60 * 24));
                            $daysRemaining = 90 - $daysSince;
                            if ($daysRemaining > 0) {
                                echo sprintf(__('profile.username_cooldown'), $daysRemaining);
                            } else {
                                echo __('profile.username_can_change');
                            }
                        } else {
                            echo __('profile.username_can_change');
                        }
                        ?>`;
                        
                        // Remove this onclick handler
                        editUsernameBtn.onclick = null;
                    };
                }
                });
            } else {
                // Fallback for browsers without SweetAlert
                if (confirm('<?php _e("profile.username_change_warning"); ?>\n<?php _e("profile.username_change_90day_rule"); ?>\n<?php _e("profile.username_change_confirm"); ?>')) {
                    // Enable username input
                    usernameInput.removeAttribute('readonly');
                    usernameInput.focus();
                    usernameInput.select();
                    
                    // Change button text and functionality
                    editUsernameBtn.innerHTML = '<i class="fas fa-times"></i> <?php _e("common.cancel"); ?>';
                    editUsernameBtn.classList.remove('btn-outline-primary');
                    editUsernameBtn.classList.add('btn-outline-secondary');
                    
                    // Update help text
                    usernameHelp.innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> <?php _e("profile.username_editing_mode"); ?>';
                    
                    // Change button functionality to cancel
                    editUsernameBtn.onclick = function() {
                        // Reset to original state
                        usernameInput.value = '<?php echo htmlspecialchars($user['username']); ?>';
                        usernameInput.setAttribute('readonly', true);
                        
                        editUsernameBtn.innerHTML = '<i class="fas fa-edit"></i> <?php _e("profile.change_username"); ?>';
                        editUsernameBtn.classList.remove('btn-outline-secondary');
                        editUsernameBtn.classList.add('btn-outline-primary');
                        
                        // Reset help text
                        usernameHelp.innerHTML = `<?php 
                        if ($lastChanged) {
                            $daysSince = floor((time() - strtotime($lastChanged)) / (60 * 60 * 24));
                            $daysRemaining = 90 - $daysSince;
                            if ($daysRemaining > 0) {
                                echo sprintf(__('profile.username_cooldown'), $daysRemaining);
                            } else {
                                echo __('profile.username_can_change');
                            }
                        } else {
                            echo __('profile.username_can_change');
                        }
                        ?>`;
                        
                        // Remove this onclick handler
                        editUsernameBtn.onclick = null;
                    };
                }
            }
        });
    } else {
        console.log('Edit username button not found');
    }
    
    // Real-time username availability check
    if (usernameInput) {
        let timeoutId;
        usernameInput.addEventListener('input', function() {
            const username = this.value.trim();
            const originalUsername = '<?php echo htmlspecialchars($user['username']); ?>';
            
            // Clear previous timeout
            clearTimeout(timeoutId);
            
            // Don't check if it's the same as original username
            if (username === originalUsername || username.length < 3) {
                return;
            }
            
            // Debounce the check
            timeoutId = setTimeout(() => {
                fetch('index.php?url=users/check-username', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ username: username })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.available === false) {
                        usernameInput.classList.add('is-invalid');
                        usernameInput.classList.remove('is-valid');
                        
                        // Show or update error message
                        let feedback = usernameInput.parentNode.parentNode.querySelector('.invalid-feedback');
                        if (!feedback) {
                            feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback';
                            usernameInput.parentNode.parentNode.appendChild(feedback);
                        }
                        feedback.textContent = '<?php _e("profile.username_taken"); ?>';
                    } else {
                        usernameInput.classList.remove('is-invalid');
                        usernameInput.classList.add('is-valid');
                        
                        // Remove error message
                        const feedback = usernameInput.parentNode.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.remove();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking username:', error);
                });
            }, 500);
        });
    }
});
</script>

<!-- Role Info Modal -->
<div class="modal fade" id="roleInfoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title"><i class="fas fa-user-shield me-2 text-primary"></i>Info Peran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
        $role = $user['role'];
        $roleDescriptions = [
            'super_admin' => 'Akses penuh ke seluruh sistem, termasuk manajemen pengguna, proyek, dan pengaturan global.',
            'admin' => 'Mengelola proyek, pengguna, dan pengaturan tingkat aplikasi. Hampir semua hak kecuali beberapa opsi sistem.',
            'project_manager' => 'Mengelola proyek, tugas, timeline, dan koordinasi tim project.',
            'developer' => 'Mengerjakan tugas pengembangan, memperbarui status, dan berkolaborasi dengan tim.',
            'qa_tester' => 'Membuat dan menjalankan test case/suite, melaporkan bug, dan memverifikasi perbaikan.',
            'client' => 'Melihat progres proyek, mengirim feedback/bug, dan memantau status deliverable.'
        ];
        $desc = $roleDescriptions[$role] ?? 'Peran pengguna dalam sistem.';
        ?>
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <span class="badge bg-primary me-2">
                <?php if (in_array($role, ['super_admin', 'admin'])): ?>
                    <i class="fas fa-crown me-1 text-warning"></i>
                <?php else: ?>
                    <i class="fas fa-user-tag me-1"></i>
                <?php endif; ?>
                <?php echo ucfirst(str_replace('_',' ',$role)); ?>
              </span>
            </div>
            <p class="mb-0 text-muted"><?php echo htmlspecialchars($desc); ?></p>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Tutup</button>
      </div>
    </div>
  </div>
  <style>
    body.dark-mode #roleInfoModal .modal-content { background-color: #1e293b; color: #e2e8f0; }
    body.dark-mode #roleInfoModal .bg-light { background-color: #334155 !important; }
    body.dark-mode #roleInfoModal .text-muted { color: #94a3b8 !important; }
    body.dark-mode #roleInfoModal .card { background-color: #334155; border-color: #475569; }
  </style>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>