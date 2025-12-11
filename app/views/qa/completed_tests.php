<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Hasil Test Selesai</h1>
        <p class="text-muted mb-0">Daftar eksekusi test yang telah disimpan</p>
    </div>
    <a href="index.php?url=qa" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke QA
    </a>
</div>

<div class="card">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-clipboard-check me-2 text-muted"></i>
            Riwayat Eksekusi Terbaru
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($executions)): ?>
            <div class="text-center py-4 text-muted">Belum ada hasil test.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-darkmode-compatible">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Test Case</th>
                            <th>Proyek</th>
                            <th>Hasil</th>
                            <th>Catatan</th>
                            <th>Dieksekusi Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($executions as $ex): ?>
                        <tr>
                            <td><small class="text-muted"><?php echo htmlspecialchars($ex['executed_at']); ?></small></td>
                            <td><?php echo htmlspecialchars($ex['test_case_title'] ?? ('#'.$ex['test_case_id'])); ?></td>
                            <td><span class="badge bg-light text-dark"><?php echo htmlspecialchars($ex['project_name'] ?? ''); ?></span></td>
                            <td>
                                <?php 
                                $color = 'secondary';
                                if ($ex['status'] === 'pass') $color = 'success';
                                else if ($ex['status'] === 'fail') $color = 'danger';
                                else if ($ex['status'] === 'blocked') $color = 'warning';
                                ?>
                                <span class="badge bg-<?php echo $color; ?>"><?php echo ucfirst($ex['status']); ?></span>
                            </td>
                            <td><?php echo nl2br(htmlspecialchars($ex['comments'] ?? '')); ?></td>
                            <td><small class="text-muted"><?php echo htmlspecialchars($ex['executed_by_name'] ?? ''); ?></small></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .card-title, body.dark-mode .text-dark { color: #e2e8f0 !important; }
body.dark-mode .text-muted { color: #94a3b8 !important; }
body.dark-mode .table-darkmode-compatible { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table-darkmode-compatible thead { background-color: #0f172a; color: #e2e8f0; }
body.dark-mode .table-darkmode-compatible tbody tr:nth-child(even) { background-color: #253041; }
body.dark-mode .table-darkmode-compatible tbody tr:nth-child(odd) { background-color: #1f2a3a; }
</style>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>


