<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Tambah Pengguna Baru</h1>
        <p class="text-muted">Buat akun pengguna baru untuk sistem FlowTask</p>
    </div>
    <a href="index.php?url=users" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Pengguna
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
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-plus me-2"></i>Informasi Pengguna
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?url=users/create">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                                <div class="form-text">Harus unik dan minimal 3 karakter</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Peran <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Pilih Peran</option>
                                    <?php if (($currentUserRole ?? '') === 'super_admin'): ?>
                                        <option value="admin" <?php echo ($_POST['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>
                                            Administrator
                                        </option>
                                    <?php endif; ?>
                                    <option value="project_manager" <?php echo ($_POST['role'] ?? '') === 'project_manager' ? 'selected' : ''; ?>>
                                        Manajer Proyek
                                    </option>
                                    <option value="developer" <?php echo ($_POST['role'] ?? '') === 'developer' ? 'selected' : ''; ?>>
                                        Developer
                                    </option>
                                    <option value="qa_tester" <?php echo ($_POST['role'] ?? '') === 'qa_tester' ? 'selected' : ''; ?>>
                                        QA Tester
                                    </option>
                                </select>
                                <?php if (($currentUserRole ?? '') !== 'super_admin'): ?>
                                    <div class="form-text text-warning">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Catatan: Hanya Super Administrator yang dapat membuat pengguna Admin
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                <div class="form-text">Minimal 8 karakter</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?url=users" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Buat Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 6rem;">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Izin Peran</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <?php if (($currentUserRole ?? '') === 'super_admin'): ?>
                        <li><strong>Super Administrator:</strong> Level privilese tertinggi, dapat membuat pengguna Admin</li>
                    <?php endif; ?>
                    <li><strong>Administrator:</strong> Akses penuh sistem, manajemen pengguna, semua fitur <?php if (($currentUserRole ?? '') !== 'super_admin'): ?><em>(Hanya Super Admin)</em><?php endif; ?></li>
                    <li><strong>Manajer Proyek:</strong> Manajemen proyek, penugasan tim, laporan</li>
                    <li><strong>Developer:</strong> Manajemen tugas, perbaikan bug, pengembangan kode</li>
                    <li><strong>QA Tester:</strong> Pembuatan test case, pelaporan bug, quality assurance</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const passwordIcon = document.getElementById(fieldId + '-icon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}

// Username validation
Document.getElementById && document.getElementById('username') && document.getElementById('username').addEventListener('input', function() {
    const username = this.value;
    const regex = /^[a-zA-Z0-9_]{3,}$/;
    if (username.length > 0 && !regex.test(username)) {
        this.classList.add('is-invalid');
        if (!document.getElementById('username-feedback')) {
            const feedback = document.createElement('div');
            feedback.id = 'username-feedback';
            feedback.className = 'invalid-feedback';
            feedback.textContent = 'Username minimal 3 karakter dan hanya huruf, angka, dan underscore';
            this.parentNode.appendChild(feedback);
        }
    } else {
        this.classList.remove('is-invalid');
        const feedback = document.getElementById('username-feedback');
        if (feedback) { feedback.remove(); }
    }
});

// Password strength indicator
Document.getElementById && document.getElementById('password') && document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = calculatePasswordStrength(password);
    const groupContainer = this.closest('.mb-3') || this.parentNode;
    const existingIndicator = groupContainer.querySelector('#password-strength');
    if (existingIndicator) { existingIndicator.remove(); }
    if (password.length > 0) {
        const indicator = document.createElement('div');
        indicator.id = 'password-strength';
        indicator.className = 'mt-2';
        let strengthText = '';
        let strengthClass = '';
        switch (strength) {
            case 1: strengthText = 'Lemah'; strengthClass = 'text-danger'; break;
            case 2: strengthText = 'Cukup'; strengthClass = 'text-warning'; break;
            case 3: strengthText = 'Baik'; strengthClass = 'text-info'; break;
            case 4: strengthText = 'Sangat Baik'; strengthClass = 'text-success'; break;
        }
        indicator.innerHTML = `<small class="${strengthClass}">Kekuatan password: ${strengthText}</small>`;
        groupContainer.appendChild(indicator);
    }
});

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return Math.min(strength, 4);
}
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>