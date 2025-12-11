<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Edit Test Case Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Edit Test Case</h1>
        <p class="text-muted mb-0">Perbarui informasi test case quality assurance</p>
    </div>
    <div class="d-flex gap-2">
        <a href="index.php?url=qa/test-cases" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Test Cases
        </a>
    </div>
</div>

<!-- Edit Test Case Form -->
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

                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="project_id" class="form-label">Proyek <span class="text-danger">*</span></label>
                            <select class="form-select" id="project_id" name="project_id" required>
                                <option value="">Pilih Proyek</option>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?php echo $project['id']; ?>" 
                                            <?php echo ($testCase['project_id'] ?? '') == $project['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($project['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Test Case <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($testCase['title'] ?? ''); ?>" 
                               placeholder="Judul singkat yang menjelaskan apa yang divalidasi test case ini" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <?php 
                        // Clean description from legacy custom type markers for display
                        $cleanDescription = $testCase['description'] ?? '';
                        $cleanDescription = preg_replace('/\n\n\[Jenis Test Kustom:.*?\]/u', '', $cleanDescription);
                        $cleanDescription = trim($cleanDescription);
                        ?>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  placeholder="Deskripsi detail tentang apa yang ingin diverifikasi oleh test case ini" required><?php echo htmlspecialchars($cleanDescription); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="preconditions" class="form-label">Prasyarat</label>
                        <textarea class="form-control" id="preconditions" name="preconditions" rows="3" 
                                  placeholder="Persiapan atau kondisi yang harus dipenuhi sebelum menjalankan test ini..."><?php echo htmlspecialchars($testCase['preconditions'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="test_steps" class="form-label">Langkah Pengujian <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="test_steps" name="test_steps" rows="5" 
                                  placeholder="1. Pergi ke...&#10;2. Klik...&#10;3. Masukkan data...&#10;4. Verifikasi bahwa..." required><?php echo htmlspecialchars($testCase['test_steps'] ?? ''); ?></textarea>
                        <div class="form-text">Tuliskan setiap langkah dengan jelas dan urutannya.</div>
                    </div>

                    <div class="mb-3">
                        <label for="expected_result" class="form-label">Hasil yang Diharapkan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="expected_result" name="expected_result" rows="3" 
                                  placeholder="Jelaskan apa yang seharusnya terjadi ketika langkah-langkah test dijalankan dengan benar..." required><?php echo htmlspecialchars($testCase['expected_result'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="">Pilih Prioritas</option>
                                <option value="low" <?php echo ($testCase['priority'] ?? '') == 'low' ? 'selected' : ''; ?>>Rendah</option>
                                <option value="medium" <?php echo ($testCase['priority'] ?? '') == 'medium' ? 'selected' : ''; ?>>Sedang</option>
                                <option value="high" <?php echo ($testCase['priority'] ?? '') == 'high' ? 'selected' : ''; ?>>Tinggi</option>
                                <option value="critical" <?php echo ($testCase['priority'] ?? '') == 'critical' ? 'selected' : ''; ?>>Kritis</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Jenis Test <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Pilih Jenis</option>
                                <option value="functional" <?php echo ($testCase['type'] ?? '') == 'functional' ? 'selected' : ''; ?>>Fungsional</option>
                                <option value="integration" <?php echo ($testCase['type'] ?? '') == 'integration' ? 'selected' : ''; ?>>Integrasi</option>
                                <option value="system" <?php echo ($testCase['type'] ?? '') == 'system' ? 'selected' : ''; ?>>Sistem</option>
                                <option value="acceptance" <?php echo ($testCase['type'] ?? '') == 'acceptance' ? 'selected' : ''; ?>>User Acceptance</option>
                                <option value="regression" <?php echo ($testCase['type'] ?? '') == 'regression' ? 'selected' : ''; ?>>Regresi</option>
                                <option value="performance" <?php echo ($testCase['type'] ?? '') == 'performance' ? 'selected' : ''; ?>>Performa</option>
                                <option value="security" <?php echo ($testCase['type'] ?? '') == 'security' ? 'selected' : ''; ?>>Keamanan</option>
                                <option value="usability" <?php echo ($testCase['type'] ?? '') == 'usability' ? 'selected' : ''; ?>>Kegunaan</option>
                                <?php 
                                $currentType = $testCase['type'] ?? '';
                                $allowedTypes = ['functional','integration','system','acceptance','regression','performance','security','usability','ui','compatibility'];
                                
                                // Check if there's a custom type marker in description (legacy data)
                                $customTypeFromDesc = '';
                                if (preg_match('/\[Jenis Test Kustom:\s*(.*?)\]/u', $testCase['description'] ?? '', $matches)) {
                                    $customTypeFromDesc = trim($matches[1]);
                                }
                                
                                // Determine if this is a custom type
                                $isCustomType = (!in_array($currentType, $allowedTypes) && !empty($currentType)) || !empty($customTypeFromDesc);
                                $displayCustomType = !empty($customTypeFromDesc) ? $customTypeFromDesc : $currentType;
                                ?>
                                <option value="other" <?php echo $isCustomType ? 'selected' : ''; ?>>Lainnya (ketik sendiri)</option>
                            </select>
                            <input type="text" class="form-control mt-2 <?php echo $isCustomType ? '' : 'd-none'; ?>" id="type_other" name="type_other" 
                                   value="<?php echo $isCustomType ? htmlspecialchars($displayCustomType) : ''; ?>" placeholder="Tulis jenis test lainnya...">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="index.php?url=qa/test-cases" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
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
