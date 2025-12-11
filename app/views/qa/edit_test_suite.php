<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Edit Test Suite Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Edit Test Suite</h1>
        <p class="text-muted mb-0">Perbarui informasi test suite quality assurance</p>
    </div>
    <div class="d-flex gap-2">
        <a href="index.php?url=qa/test-suites" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Test Suites
        </a>
    </div>
</div>

<!-- Edit Test Suite Form -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-edit me-2 text-primary"></i>
                    Edit Test Suite
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo htmlspecialchars($errors['general']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?url=qa/edit-test-suite/<?php echo $testSuite['id']; ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Test Suite <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo !empty($errors['name']) ? 'is-invalid' : ''; ?>" 
                                       id="name" name="name" value="<?php echo htmlspecialchars($testSuite['name'] ?? ''); ?>" required>
                                <?php if (!empty($errors['name'])): ?>
                                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['name']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Proyek <span class="text-danger">*</span></label>
                                <select class="form-select <?php echo !empty($errors['project_id']) ? 'is-invalid' : ''; ?>" 
                                        id="project_id" name="project_id" required>
                                    <option value="">Pilih Proyek</option>
                                    <?php foreach ($projects as $project): ?>
                                        <option value="<?php echo $project['id']; ?>" 
                                                <?php echo ($testSuite['project_id'] ?? '') == $project['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($project['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (!empty($errors['project_id'])): ?>
                                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['project_id']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Test Suite <span class="text-danger">*</span></label>
                        <textarea class="form-control <?php echo !empty($errors['description']) ? 'is-invalid' : ''; ?>" 
                                  id="description" name="description" rows="4" required><?php echo htmlspecialchars($testSuite['description'] ?? ''); ?></textarea>
                        <?php if (!empty($errors['description'])): ?>
                            <div class="invalid-feedback"><?php echo htmlspecialchars($errors['description']); ?></div>
                        <?php endif; ?>
                        <div class="form-text">Jelaskan tujuan dan cakupan test suite ini</div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Kelola Test Case di Suite</label>
                                <div class="card">
                                    <div class="card-body p-0" style="max-height: 260px; overflow-y: auto; overflow-x: hidden;">
                                        <?php if (!empty($currentCases)): ?>
                                            <?php foreach ($currentCases as $tc): ?>
                                            <div class="px-3 py-2 d-flex align-items-start justify-content-between border-bottom suite-item-row">
                                                <div class="pe-3 flex-grow-1" style="min-width:0;">
                                                    <div class="fw-semibold text-truncate tc-title" title="<?php echo htmlspecialchars($tc['title'] ?? ''); ?>"><?php echo htmlspecialchars($tc['title'] ?? ''); ?></div>
                                                    <?php if (!empty($tc['description'])): ?>
                                                    <div class="small text-muted tc-desc"><?php echo htmlspecialchars($tc['description']); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ps-2 d-flex align-items-center">
                                                    <div class="form-check m-0">
                                                        <input class="form-check-input" type="checkbox" name="remove_cases[]" value="<?php echo $tc['id']; ?>" id="rm_<?php echo $tc['id']; ?>">
                                                        <label class="form-check-label small text-muted ms-1" for="rm_<?php echo $tc['id']; ?>">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="p-3 text-muted">Belum ada test case di suite ini.</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-footer bg-light">
                                        <small class="text-muted">Centang "Hapus" untuk mengeluarkan test case dari suite.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tambah Test Case ke Suite</label>
                        <div class="card">
                            <div class="card-body p-0" style="max-height: 260px; overflow-y: auto; overflow-x: hidden;">
                                <?php if (!empty($availableCases)): ?>
                                    <?php foreach ($availableCases as $tc): ?>
                                    <label class="px-3 py-2 d-flex align-items-start justify-content-between border-bottom suite-item-row" for="add_<?php echo $tc['id']; ?>">
                                        <div class="form-check m-0">
                                            <input class="form-check-input" type="checkbox" name="new_test_cases[]" value="<?php echo $tc['id']; ?>" id="add_<?php echo $tc['id']; ?>">
                                        </div>
                                        <div class="ps-2 flex-grow-1 pe-3" style="min-width:0;">
                                            <div class="fw-semibold text-truncate tc-title" title="<?php echo htmlspecialchars($tc['title'] ?? ''); ?>"><?php echo htmlspecialchars($tc['title'] ?? ''); ?></div>
                                            <?php if (!empty($tc['description'])): ?>
                                            <div class="small text-muted tc-desc"><?php echo htmlspecialchars($tc['description']); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </label>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="p-3 text-muted">Tidak ada test case lain untuk ditambahkan (proyek sama).</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php?url=qa/test-suites" class="btn btn-outline-secondary">
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
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0 text-dark">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    Informasi Test Suite
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">ID Test Suite</small>
                    <div class="fw-bold">#<?php echo $testSuite['id']; ?></div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Dibuat Oleh</small>
                    <div><?php echo htmlspecialchars($testSuite['created_by_name'] ?? 'Tidak Diketahui'); ?></div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Tanggal Dibuat</small>
                    <div><?php echo date('d M Y, H:i', strtotime($testSuite['created_at'])); ?></div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Terakhir Diperbarui</small>
                    <div><?php echo date('d M Y, H:i', strtotime($testSuite['updated_at'] ?? $testSuite['created_at'])); ?></div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<style>
/* Tidy suite lists */
.suite-item-row { background-color: transparent; }
.tc-desc { max-height: 2.6em; overflow: hidden; line-height: 1.3em; word-break: break-word; }
.tc-title { word-break: break-word; }
/* Dark mode subtle separators */
body.dark-mode .suite-item-row { border-color: #475569 !important; }
</style>
