<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Create Test Case Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Buat Test Case</h1>
        <p class="text-muted mb-0">Rancang test case yang komprehensif untuk quality assurance</p>
    </div>
    <a href="index.php?url=qa" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke QA
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
                    <i class="fas fa-clipboard-check me-2"></i>
                    Informasi Test Case
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-12 mb-3">
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
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Test Case <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" 
                               placeholder="Judul singkat yang menjelaskan apa yang divalidasi test case ini" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  placeholder="Deskripsi detail tentang apa yang ingin diverifikasi oleh test case ini" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="preconditions" class="form-label">Prasyarat</label>
                        <textarea class="form-control" id="preconditions" name="preconditions" rows="3" 
                                  placeholder="Persiapan atau kondisi yang harus dipenuhi sebelum menjalankan test ini..."><?php echo htmlspecialchars($_POST['preconditions'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="test_steps" class="form-label">Langkah Pengujian <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="test_steps" name="test_steps" rows="5" 
                                  placeholder="1. Pergi ke...&#10;2. Klik...&#10;3. Masukkan data...&#10;4. Verifikasi bahwa..." required><?php echo htmlspecialchars($_POST['test_steps'] ?? ''); ?></textarea>
                        <div class="form-text">Tuliskan setiap langkah dengan jelas dan urutannya.</div>
                    </div>

                    <div class="mb-3">
                        <label for="expected_result" class="form-label">Hasil yang Diharapkan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="expected_result" name="expected_result" rows="3" 
                                  placeholder="Jelaskan apa yang seharusnya terjadi ketika langkah-langkah test dijalankan dengan benar..." required><?php echo htmlspecialchars($_POST['expected_result'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
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
                            <label for="type" class="form-label">Jenis Test <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Pilih Jenis</option>
                                <option value="functional" <?php echo ($_POST['type'] ?? '') == 'functional' ? 'selected' : ''; ?>>Fungsional</option>
                                <option value="integration" <?php echo ($_POST['type'] ?? '') == 'integration' ? 'selected' : ''; ?>>Integrasi</option>
                                <option value="system" <?php echo ($_POST['type'] ?? '') == 'system' ? 'selected' : ''; ?>>Sistem</option>
                                <option value="acceptance" <?php echo ($_POST['type'] ?? '') == 'acceptance' ? 'selected' : ''; ?>>User Acceptance</option>
                                <option value="regression" <?php echo ($_POST['type'] ?? '') == 'regression' ? 'selected' : ''; ?>>Regresi</option>
                                <option value="performance" <?php echo ($_POST['type'] ?? '') == 'performance' ? 'selected' : ''; ?>>Performa</option>
                                <option value="security" <?php echo ($_POST['type'] ?? '') == 'security' ? 'selected' : ''; ?>>Keamanan</option>
                                <option value="usability" <?php echo ($_POST['type'] ?? '') == 'usability' ? 'selected' : ''; ?>>Kegunaan</option>
                                <option value="other" <?php echo ($_POST['type'] ?? '') == 'other' ? 'selected' : ''; ?>>Lainnya (ketik sendiri)</option>
                            </select>
                            <input type="text" class="form-control mt-2 d-none" id="type_other" name="type_other" 
                                   value="<?php echo htmlspecialchars($_POST['type_other'] ?? ''); ?>" 
                                   placeholder="Tulis jenis test lainnya...">
                        </div>
                        
                        
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="index.php?url=qa" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Test Case
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
                    Panduan Test Case
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-lightbulb me-2"></i>Praktik Terbaik
                    </h6>
                    <ul class="small text-muted mb-0">
                        <li>Tulis langkah test yang jelas dan spesifik</li>
                        <li> Sertakan semua prasyarat yang diperlukan</li>
                        <li>Definisikan hasil yang diharapkan secara terukur</li>
                        <li>Buat test case atomic dan fokus</li>
                        <li>Gunakan judul deskriptif</li>
                        <li>Pertimbangkan edge case dan skenario error</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-list-ol me-2"></i>Jenis Test
                    </h6>
                    <small class="text-muted">
                        <strong>Fungsional:</strong> Fungsi fitur<br>
                        <strong>Integrasi:</strong> Interaksi komponen<br>
                        <strong>Sistem:</strong> Alur end-to-end<br>
                        <strong>Acceptance:</strong> Kebutuhan pengguna<br>
                        <strong>Regresi:</strong> Fungsi yang sudah ada<br>
                        <strong>Performa:</strong> Kecepatan dan beban<br>
                        <strong>Keamanan:</strong> Kerentanan keamanan<br>
                        <strong>Kegunaan:</strong> Pengalaman pengguna
                    </small>
                </div>

                <div>
                    <h6 class="text-primary">
                        <i class="fas fa-flag me-2"></i>Level Prioritas
                    </h6>
                    <small class="text-muted">
                        <strong>Kritis:</strong> Fungsi inti<br>
                        <strong>Tinggi:</strong> Fitur penting<br>
                        <strong>Sedang:</strong> Fitur standar<br>
                        <strong>Rendah:</strong> Fitur tambahan
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var typeSelect = document.getElementById('type');
    var typeOther = document.getElementById('type_other');
    if (!typeSelect || !typeOther) return;
    function syncOtherVisibility() {
        if (typeSelect.value === 'other') {
            typeOther.classList.remove('d-none');
            typeOther.required = true;
        } else {
            typeOther.classList.add('d-none');
            typeOther.required = false;
        }
    }
    typeSelect.addEventListener('change', syncOtherVisibility);
    syncOtherVisibility();
});
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>