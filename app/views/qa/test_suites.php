<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Test Suites Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Test Suite</h1>
        <p class="text-muted mb-0">Kelola koleksi test case</p>
    </div>
    <div class="d-flex gap-2">
        <a href="index.php?url=qa/create-test-suite" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Test Suite Baru
        </a>
        <a href="index.php?url=qa" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke QA
        </a>
    </div>
</div>

<!-- Test Suites Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-layer-group fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Total Suite</h6>
                <div class="h4 mb-0 text-primary"><?php echo count($testSuites ?? []); ?></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-clipboard-list fa-2x text-info mb-2"></i>
                <h6 class="text-muted mb-1">Total Test Case</h6>
                <div class="h4 mb-0 text-info">
                    <?php 
                    $totalTestCases = 0;
                    if (!empty($testSuites)) {
                        foreach ($testSuites as $suite) {
                            $totalTestCases += ($suite['test_case_count'] ?? 0);
                        }
                    }
                    echo $totalTestCases;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Suites List -->
<div class="card">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-list me-2 text-muted"></i>
            Test Suite
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($testSuites)): ?>
            <div class="text-center py-4">
                <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                <h5>Tidak Ada Test Suite</h5>
                <p class="text-muted">Buat test suite untuk mengelompokkan test case Anda.</p>
                <a href="index.php?url=qa/create-test-suite" class="btn btn-primary">Buat Test Suite</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Test Suite</th>
                            <th>Proyek</th>
                            <th>Test Case</th>
                            
                            <th>Kelengkapan</th>
                            <th>Dibuat Oleh</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testSuites as $suite): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-layer-group me-2 text-primary"></i>
                                    <div>
                                        <strong><?php echo htmlspecialchars($suite['name']); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo substr(htmlspecialchars($suite['description']), 0, 60) . '...'; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                    <span class="badge bg-light text-dark">
                                        <?php echo htmlspecialchars($suite['project_name'] ?? 'Tidak ada proyek'); ?>
                                    </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-white">
                                    <?php echo $suite['test_case_count'] ?? 0; ?> kasus
                                </span>
                            </td>
                            
                            <td>
                                <?php 
                                $passed = $suite['passed_tests'] ?? 0;
                                $total = $suite['test_case_count'] ?? 0;
                                $percentage = $total > 0 ? round(($passed / $total) * 100) : 0;
                                $done = $total > 0 && $percentage === 100;
                                $label = $done ? 'Selesai' : 'Belum Selesai';
                                $badge = $done ? 'bg-success' : 'bg-secondary';
                                ?>
                                <span class="badge <?php echo $badge; ?>"><?php echo $label; ?></span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo htmlspecialchars($suite['created_by_name'] ?? 'Unknown'); ?>
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo date('M j, Y', strtotime($suite['created_at'])); ?>
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?url=qa/test-suite/<?php echo $suite['id']; ?>" 
                                       class="btn btn-outline-primary" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?url=qa/run-suite/<?php echo $suite['id']; ?>" 
                                       class="btn btn-outline-success" title="Jalankan Suite">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
                                    <a href="index.php?url=qa/edit-test-suite/<?php echo $suite['id']; ?>" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteTestSuiteModal<?php echo $suite['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($testSuites) && $currentUser && in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
    <?php foreach ($testSuites as $suite): ?>
    <!-- Modal Hapus Test Suite (dipindah keluar dari tabel) -->
    <div class="modal fade" id="deleteTestSuiteModal<?php echo $suite['id']; ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="index.php?url=qa/delete-test-suite/<?php echo $suite['id']; ?>" class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Test Suite</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <div class="display-6 text-danger mb-2"><i class="fas fa-trash"></i></div>
            <p class="mb-2">Hapus test suite ini?</p>
            <div class="text-muted">Test Suite: <strong><?php echo htmlspecialchars($suite['name']); ?></strong></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
          </div>
        </form>
      </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<style>
/* Dark mode fixes for Test Suites page */
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .card-title, body.dark-mode .text-dark { color: #e2e8f0 !important; }
body.dark-mode .text-muted { color: #94a3b8 !important; }
body.dark-mode .table { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table thead { background-color: #0f172a; color: #e2e8f0; }
body.dark-mode .table thead th { color: #e2e8f0 !important; }
body.dark-mode .table tbody tr:nth-child(even) { background-color: #253041; }
body.dark-mode .table tbody tr:nth-child(odd) { background-color: #1f2a3a; }
body.dark-mode .table > :not(caption) > * > * { background-color: transparent !important; color: #e2e8f0; }
/* Badges that look too bright in dark mode */
body.dark-mode .badge.bg-light { background-color: #334155 !important; color: #e2e8f0 !important; border: 1px solid #475569; }
</style>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>