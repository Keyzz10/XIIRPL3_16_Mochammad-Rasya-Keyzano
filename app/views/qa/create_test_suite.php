<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Create Test Suite Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Buat Test Suite</h1>
        <p class="text-muted mb-0">Kelompokkan test case menjadi koleksi logis untuk pengujian yang efisien</p>
    </div>
    <a href="index.php?url=qa/test-suites" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Test Suite
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
                    <i class="fas fa-layer-group me-2"></i>
                    Informasi Test Suite
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
                        <label for="name" class="form-label">Nama Test Suite <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" 
                               placeholder="Nama untuk kumpulan test case ini" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" 
                                  placeholder="Jelaskan tujuan dan cakupan dari test suite ini..." required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Jenis Suite <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Pilih Jenis</option>
                                <option value="smoke" <?php echo ($_POST['type'] ?? '') == 'smoke' ? 'selected' : ''; ?>>Smoke</option>
                                <option value="regression" <?php echo ($_POST['type'] ?? '') == 'regression' ? 'selected' : ''; ?>>Regresi</option>
                                <option value="functional" <?php echo ($_POST['type'] ?? '') == 'functional' ? 'selected' : ''; ?>>Fungsional</option>
                                <option value="integration" <?php echo ($_POST['type'] ?? '') == 'integration' ? 'selected' : ''; ?>>Integrasi</option>
                                <option value="system" <?php echo ($_POST['type'] ?? '') == 'system' ? 'selected' : ''; ?>>Sistem</option>
                                <option value="acceptance" <?php echo ($_POST['type'] ?? '') == 'acceptance' ? 'selected' : ''; ?>>User Acceptance</option>
                                <option value="performance" <?php echo ($_POST['type'] ?? '') == 'performance' ? 'selected' : ''; ?>>Performa</option>
                                <option value="security" <?php echo ($_POST['type'] ?? '') == 'security' ? 'selected' : ''; ?>>Keamanan</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="">Pilih Prioritas</option>
                                <option value="low" <?php echo ($_POST['priority'] ?? '') == 'low' ? 'selected' : ''; ?>>Rendah</option>
                                <option value="medium" <?php echo ($_POST['priority'] ?? '') == 'medium' ? 'selected' : ''; ?>>Sedang</option>
                                <option value="high" <?php echo ($_POST['priority'] ?? '') == 'high' ? 'selected' : ''; ?>>Tinggi</option>
                                <option value="critical" <?php echo ($_POST['priority'] ?? '') == 'critical' ? 'selected' : ''; ?>>Kritis</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="test_cases" class="form-label">Pilih Test Case</label>
                        <div class="card">
                            <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                <?php if (!empty($testCases)): ?>
                                    <?php foreach ($testCases as $testCase): ?>
                                        <?php 
                                        $desc = $testCase['description'] ?? ''; 
                                        $customType = '';
                                        if (preg_match('/\[Jenis Test Kustom:\s*(.*?)\]/u', $desc, $m)) {
                                            $customType = trim($m[1]);
                                            $desc = trim(str_replace($m[0], '', $desc));
                                        }
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="test_cases[]" value="<?php echo $testCase['id']; ?>" 
                                                   id="test_case_<?php echo $testCase['id']; ?>">
                                            <label class="form-check-label" for="test_case_<?php echo $testCase['id']; ?>">
                                                <strong><?php echo htmlspecialchars($testCase['title']); ?></strong>
                                                <?php if ($customType): ?>
                                                    <span class="badge bg-info ms-2">Jenis: <?php echo htmlspecialchars($customType); ?></span>
                                                <?php endif; ?>
                                                <br>
                                                <small class="text-muted"><?php echo htmlspecialchars($desc); ?></small>
                                            </label>
                                        </div>
                                        <hr class="my-2">
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted mb-0">Belum ada test case. Buat test case terlebih dahulu.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-text">Anda dapat menambahkan test case nanti jika belum dipilih sekarang.</div>
                    </div>

                    <div class="mb-3">
                        <label for="schedule" class="form-label">Jadwal Eksekusi</label>
                        <select class="form-select" id="schedule" name="schedule">
                            <option value="manual" <?php echo ($_POST['schedule'] ?? 'manual') == 'manual' ? 'selected' : ''; ?>>Manual</option>
                            <option value="daily" <?php echo ($_POST['schedule'] ?? '') == 'daily' ? 'selected' : ''; ?>>Harian</option>
                            <option value="weekly" <?php echo ($_POST['schedule'] ?? '') == 'weekly' ? 'selected' : ''; ?>>Mingguan</option>
                            <option value="release" <?php echo ($_POST['schedule'] ?? '') == 'release' ? 'selected' : ''; ?>>Sebelum Rilis</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="index.php?url=qa/test-suites" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Test Suite
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
                    Panduan Test Suite
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-lightbulb me-2"></i>Praktik Terbaik
                    </h6>
                    <ul class="small text-muted mb-0">
                        <li>Kelompokkan test case terkait secara logis</li>
                        <li>Jaga ukuran suite tetap mudah dikelola</li>
                        <li>Gunakan nama suite yang deskriptif</li>
                        <li>Organisasi berdasarkan fitur atau fungsionalitas</li>
                        <li>Sertakan test positif dan negatif</li>
                        <li>Kelola dependensi test case</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">
                        <i class="fas fa-layer-group me-2"></i>Jenis Suite
                    </h6>
                    <small class="text-muted">
                        <strong>Smoke:</strong> Fungsi dasar<br>
                        <strong>Regresi:</strong> Fitur yang ada<br>
                        <strong>Fungsional:</strong> Pengujian fitur<br>
                        <strong>Integrasi:</strong> Interaksi komponen<br>
                        <strong>Sistem:</strong> Pengujian end-to-end<br>
                        <strong>Acceptance:</strong> Kebutuhan pengguna<br>
                        <strong>Performa:</strong> Kecepatan dan beban<br>
                        <strong>Keamanan:</strong> Validasi keamanan
                    </small>
                </div>

                <div>
                    <h6 class="text-primary">
                        <i class="fas fa-clock me-2"></i>Strategi Eksekusi
                    </h6>
                    <small class="text-muted">
                        Rencanakan eksekusi test berdasarkan milestone proyek,
                        siklus rilis, dan perubahan fungsi kritis.
                        Eksekusi rutin membantu menjaga standar kualitas.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<style>
/* Dark mode fixes for Create Test Suite page */
body.dark-mode .form-check-label { color: #e2e8f0; }
body.dark-mode .form-check-input { border-color: #94a3b8; background-color: transparent; }
body.dark-mode .form-check-input:checked { background-color: var(--primary-color); border-color: var(--primary-color); }
body.dark-mode .card .card-body { color: #e2e8f0; }
body.dark-mode .card .card-body .text-muted { color: #94a3b8 !important; }
body.dark-mode .form-text { color: #94a3b8 !important; }
body.dark-mode hr { border-color: #475569; opacity: 1; }
</style>