<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Jalankan Test</h1>
        <p class="text-muted mb-0">Eksekusi dan catat hasil untuk test case ini.</p>
    </div>
    <a href="index.php?url=qa" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    </div>

<div class="card mb-4">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark"><i class="fas fa-clipboard-check me-2 text-muted"></i><?php echo htmlspecialchars($testCase['title']); ?></h5>
    </div>
    <div class="card-body">
        <div class="mb-2"><strong>Proyek:</strong> <?php echo htmlspecialchars($testCase['project_name'] ?? ''); ?></div>
        <div class="mb-2"><strong>Prasyarat:</strong><br><?php echo nl2br(htmlspecialchars($testCase['preconditions'] ?? '')); ?></div>
        <div class="mb-2"><strong>Langkah-langkah:</strong><br><?php echo nl2br(htmlspecialchars($testCase['test_steps'] ?? '')); ?></div>
        <div class="mb-2"><strong>Hasil yang Diharapkan:</strong><br><?php echo nl2br(htmlspecialchars($testCase['expected_result'] ?? '')); ?></div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">Catat Hasil</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="">Pilih hasil</option>
                        <option value="pass">Lulus</option>
                        <option value="fail">Gagal</option>
                        <option value="blocked">Terhalang</option>
                    </select>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-control" name="notes" rows="3" placeholder="Catatan opsional"></textarea>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tautkan ke Tugas terkait (opsional)</label>
                    <select name="task_id" class="form-select">
                        <option value="">Tidak ada tugas terkait</option>
                        <?php foreach ($tasks as $task): ?>
                            <option value="<?php echo $task['id']; ?>"><?php echo htmlspecialchars($task['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="report_bug" name="report_bug" value="1">
                        <label class="form-check-label" for="report_bug">
                            Buat laporan bug jika hasil Gagal
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="index.php?url=qa" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Hasil</button>
            </div>
        </form>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>


