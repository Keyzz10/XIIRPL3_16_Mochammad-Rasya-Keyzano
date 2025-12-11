<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Jalankan Test Suite</h1>
        <p class="text-muted mb-0"><?php echo htmlspecialchars($suite['name'] ?? ''); ?> • <?php echo htmlspecialchars($suite['project_name'] ?? ''); ?></p>
    </div>
    <a href="index.php?url=qa/test-suites" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    
</div>

<div class="card">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-play me-2 text-muted"></i>
            Batch Run • <?php echo count($testCases ?? []); ?> Test Case
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($testCases)): ?>
            <div class="text-muted">Tidak ada test case dalam suite ini.</div>
        <?php else: ?>
        <form method="POST" action="">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Test Case</th>
                            <th>Hasil</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testCases as $tc): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($tc['title'] ?? ''); ?></strong><br>
                                <small class="text-muted"><?php echo htmlspecialchars($tc['description'] ?? ''); ?></small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="status[<?php echo $tc['id']; ?>]" id="pass_<?php echo $tc['id']; ?>" value="pass">
                                    <label class="btn btn-outline-success" for="pass_<?php echo $tc['id']; ?>"><i class="fas fa-check me-1"></i>Pass</label>

                                    <input type="radio" class="btn-check" name="status[<?php echo $tc['id']; ?>]" id="fail_<?php echo $tc['id']; ?>" value="fail">
                                    <label class="btn btn-outline-danger" for="fail_<?php echo $tc['id']; ?>"><i class="fas fa-times me-1"></i>Fail</label>

                                    <input type="radio" class="btn-check" name="status[<?php echo $tc['id']; ?>]" id="blocked_<?php echo $tc['id']; ?>" value="blocked">
                                    <label class="btn btn-outline-warning" for="blocked_<?php echo $tc['id']; ?>"><i class="fas fa-ban me-1"></i>Blocked</label>
                                </div>
                            </td>
                            <td style="min-width: 220px;">
                                <input type="text" class="form-control" name="notes[<?php echo $tc['id']; ?>]" placeholder="Catatan (opsional)">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?url=qa/test-suites" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Simpan Hasil
                </button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<style>
body.dark-mode .btn-check + .btn.btn-outline-success { border-color: #10b981; color: #10b981; }
body.dark-mode .btn-check + .btn.btn-outline-danger { border-color: #ef4444; color: #ef4444; }
body.dark-mode .btn-check + .btn.btn-outline-warning { border-color: #f59e0b; color: #f59e0b; }
</style>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>


