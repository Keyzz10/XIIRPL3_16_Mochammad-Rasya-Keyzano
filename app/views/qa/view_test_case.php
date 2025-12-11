<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Detail Test Case</h1>
        <p class="text-muted mb-0">Lihat langkah-langkah dan riwayat eksekusi.</p>
    </div>
    <div class="btn-group">
        <a href="index.php?url=qa" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        <?php if (in_array($currentUser['role'] ?? '', ['super_admin','admin','qa_tester'])): ?>
            <a href="index.php?url=qa/run-test/<?php echo $testCase['id']; ?>" class="btn btn-primary"><i class="fas fa-play me-2"></i>Jalankan Test</a>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark"><i class="fas fa-clipboard-check me-2 text-muted"></i><?php echo htmlspecialchars($testCase['title']); ?></h5>
            </div>
            <div class="card-body">
                <div class="mb-2"><strong>Proyek:</strong> <?php echo htmlspecialchars($testCase['project_name'] ?? ''); ?></div>
                <div class="mb-2"><strong>Jenis:</strong> <?php echo htmlspecialchars(ucfirst($testCase['type'] ?? '')); ?></div>
                <div class="mb-2"><strong>Prioritas:</strong> <?php echo htmlspecialchars(ucfirst($testCase['priority'] ?? '')); ?></div>
                <div class="mb-3"><strong>Deskripsi:</strong><br><?php echo nl2br(htmlspecialchars($testCase['description'] ?? '')); ?></div>
                <div class="mb-3"><strong>Prasyarat:</strong><br><?php echo nl2br(htmlspecialchars($testCase['preconditions'] ?? '')); ?></div>
                <div class="mb-3"><strong>Langkah-langkah:</strong><br><?php echo nl2br(htmlspecialchars($testCase['test_steps'] ?? '')); ?></div>
                <div class="mb-0"><strong>Hasil yang Diharapkan:</strong><br><?php echo nl2br(htmlspecialchars($testCase['expected_result'] ?? '')); ?></div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark"><i class="fas fa-history me-2 text-muted"></i>Riwayat Eksekusi</h5>
            </div>
            <div class="card-body">
                <?php if (empty($executions)): ?>
                    <div class="text-muted">Belum ada eksekusi.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-darkmode-compatible mb-0">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($executions as $ex): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($ex['executed_at']); ?></td>
                                        <td>
                                            <?php 
                                            $statusMap = [
                                                'pass' => ['class' => 'success', 'text' => 'Lulus'],
                                                'fail' => ['class' => 'danger', 'text' => 'Gagal'],
                                                'blocked' => ['class' => 'warning', 'text' => 'Terhalang']
                                            ];
                                            $status = $statusMap[$ex['status']] ?? ['class' => 'secondary', 'text' => ucfirst($ex['status'])];
                                            ?>
                                            <span class="badge bg-<?php echo $status['class']; ?>"><?php echo $status['text']; ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($ex['executed_by_name'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Dark mode compatibility for Test Case Detail */
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .card-title, body.dark-mode .text-dark { color: #e2e8f0 !important; }
body.dark-mode .text-muted { color: #94a3b8 !important; }
/* Table dark mode */
body.dark-mode .table-darkmode-compatible { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table-darkmode-compatible thead { background-color: #0f172a; color: #e2e8f0; }
body.dark-mode .table-darkmode-compatible thead th { color: #e2e8f0 !important; }
body.dark-mode .table-darkmode-compatible tbody tr:nth-child(even) { background-color: #253041; }
body.dark-mode .table-darkmode-compatible tbody tr:nth-child(odd) { background-color: #1f2a3a; }
body.dark-mode .table-darkmode-compatible > :not(caption) > * > * { background-color: transparent !important; color: #e2e8f0; }
</style>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>


