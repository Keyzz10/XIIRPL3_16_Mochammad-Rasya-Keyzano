<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Test Cases Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Test Cases</h1>
        <p class="text-muted mb-0">Kelola dan jalankan test case quality assurance</p>
    </div>
    <div class="d-flex gap-2">
        <a href="index.php?url=qa/create-test-case" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Test Case Baru
        </a>
        <a href="index.php?url=qa" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke QA
        </a>
    </div>
</div>

<!-- Test Cases Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-clipboard-list fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Total Test Cases</h6>
                <div class="h4 mb-0 text-primary"><?php echo count($testCases ?? []); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h6 class="text-muted mb-1">Lulus</h6>
                <div class="h4 mb-0 text-success">
                    <?php 
                    $passed = 0;
                    if (!empty($testCases)) {
                        foreach ($testCases as $testCase) {
                            if (($testCase['last_result'] ?? '') === 'pass') $passed++;
                        }
                    }
                    echo $passed;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                <h6 class="text-muted mb-1">Gagal</h6>
                <div class="h4 mb-0 text-danger">
                    <?php 
                    $failed = 0;
                    if (!empty($testCases)) {
                        foreach ($testCases as $testCase) {
                            if (($testCase['last_result'] ?? '') === 'fail') $failed++;
                        }
                    }
                    echo $failed;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h6 class="text-muted mb-1">Menunggu</h6>
                <div class="h4 mb-0 text-warning">
                    <?php 
                    $pending = 0;
                    if (!empty($testCases)) {
                        foreach ($testCases as $testCase) {
                            if (empty($testCase['last_result']) || $testCase['last_result'] === 'pending') $pending++;
                        }
                    }
                    echo $pending;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Cases List -->
<div class="card">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-list me-2 text-muted"></i>
            Test Cases
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($testCases)): ?>
            <div class="text-center py-4">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <h5>Tidak Ada Test Case</h5>
                <p class="text-muted">Mulai dengan membuat test case pertama untuk quality assurance.</p>
                <a href="index.php?url=qa/create-test-case" class="btn btn-primary">Buat Test Case</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-darkmode-compatible">
                    <thead>
                        <tr>
                            <th>Test Case</th>
                            <th>Proyek</th>
                            <th>Jenis</th>
                            <th>Prioritas</th>
                            <th>Hasil Terakhir</th>
                            <th>Dibuat Oleh</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testCases as $testCase): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clipboard-check me-2 text-primary"></i>
                                    <div>
                                        <?php
                                        $desc = $testCase['description'] ?? '';
                                        $customType = '';
                                        if (preg_match('/\[Jenis Test Kustom:\s*(.*?)\]/u', $desc, $m)) {
                                            $customType = trim($m[1]);
                                            $desc = trim(str_replace($m[0], '', $desc));
                                        }
                                        ?>
                                        <strong><?php echo htmlspecialchars($testCase['title']); ?></strong>
                                        <?php if ($customType): ?>
                                            <span class="badge bg-info ms-2">Jenis: <?php echo htmlspecialchars($customType); ?></span>
                                        <?php endif; ?>
                                        <br>
                                        <small class="text-muted"><?php echo substr(htmlspecialchars($desc), 0, 60) . '...'; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    <?php echo htmlspecialchars($testCase['project_name'] ?? 'Tidak Ada Proyek'); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-white">
                                    <?php echo ucfirst(htmlspecialchars($testCase['type'])); ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $priority = $testCase['priority'];
                                $priorityClass = '';
                                switch($priority) {
                                    case 'critical': $priorityClass = 'bg-danger'; break;
                                    case 'high': $priorityClass = 'bg-warning'; break;
                                    case 'medium': $priorityClass = 'bg-primary'; break;
                                    case 'low': $priorityClass = 'bg-secondary'; break;
                                    default: $priorityClass = 'bg-light text-dark';
                                }
                                ?>
                                <span class="badge <?php echo $priorityClass; ?>">
                                    <?php echo ucfirst(htmlspecialchars($priority)); ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $result = $testCase['last_result'] ?? 'pending';
                                $resultClass = '';
                                $resultIcon = '';
                                switch($result) {
                                    case 'pass': 
                                        $resultClass = 'bg-success'; 
                                        $resultIcon = 'fa-check';
                                        break;
                                    case 'fail': 
                                        $resultClass = 'bg-danger'; 
                                        $resultIcon = 'fa-times';
                                        break;
                                    default: 
                                        $resultClass = 'bg-warning'; 
                                        $resultIcon = 'fa-clock';
                                        $result = 'pending';
                                }
                                ?>
                                <span class="badge <?php echo $resultClass; ?>">
                                    <i class="fas <?php echo $resultIcon; ?> me-1"></i>
                                    <?php 
                                    $resultText = '';
                                    switch($result) {
                                        case 'pass': $resultText = 'Lulus'; break;
                                        case 'fail': $resultText = 'Gagal'; break;
                                        case 'blocked': $resultText = 'Terhalang'; break;
                                        default: $resultText = 'Menunggu';
                                    }
                                    echo $resultText;
                                    ?>
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo htmlspecialchars($testCase['created_by_name'] ?? 'Tidak Diketahui'); ?>
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo date('M j, Y', strtotime($testCase['created_at'])); ?>
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?url=qa/test-case/<?php echo $testCase['id']; ?>" 
                                       class="btn btn-outline-primary" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?url=qa/run-test/<?php echo $testCase['id']; ?>" 
                                       class="btn btn-outline-success" title="Jalankan">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
                                    <a href="index.php?url=qa/edit-test-case/<?php echo $testCase['id']; ?>" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
                                    <button type="button" class="btn btn-outline-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteTestCaseModal<?php echo $testCase['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
                        <!-- Modal Hapus Test Case -->
                        <div class="modal fade" id="deleteTestCaseModal<?php echo $testCase['id']; ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                              <div class="modal-header bg-gradient-danger text-white" style="padding: 2rem 2rem 1.5rem 2rem;">
                                <div class="d-flex align-items-center">
                                  <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-trash fa-lg text-danger"></i>
                                  </div>
                                  <div>
                                    <h5 class="modal-title mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Test Case</h5>
                                    <small class="text-white-50">Aksi ini tidak dapat dibatalkan</small>
                                  </div>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body p-4">
                                <div class="text-center">
                                  <div class="mb-4">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                      <i class="fas fa-trash fa-2x text-danger"></i>
                                    </div>
                                  </div>
                                  <h6 class="fw-bold text-dark mb-3">Hapus test case ini?</h6>
                                  <div class="text-muted mb-2">Test Case: <strong><?php echo htmlspecialchars($testCase['title']); ?></strong></div>
                                </div>
                              </div>
                              <div class="modal-footer border-0 p-4 pt-0">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100">
                                  <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Batal
                                  </button>
                                  <button type="submit" class="btn btn-danger btn-lg px-4">
                                    <i class="fas fa-trash me-2"></i>Ya, Hapus
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<style>
/* Dark mode fixes for QA Test Cases table and cards */
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .card-title, body.dark-mode .text-dark { color: #e2e8f0 !important; }
body.dark-mode .text-muted { color: #94a3b8 !important; }

/* Make bootstrap table cells non-white in dark mode */
body.dark-mode .table-darkmode-compatible { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table-darkmode-compatible thead { background-color: #0f172a; color: #e2e8f0; }
body.dark-mode .table-darkmode-compatible thead th { color: #e2e8f0 !important; }
body.dark-mode .table-darkmode-compatible tbody tr:nth-child(even) { background-color: #253041; }
body.dark-mode .table-darkmode-compatible tbody tr:nth-child(odd) { background-color: #1f2a3a; }
body.dark-mode .table-darkmode-compatible > :not(caption) > * > * { background-color: transparent !important; color: #e2e8f0; }

/* Hover state */
body.dark-mode .table-darkmode-compatible tbody tr:hover { background-color: rgba(14, 165, 233, 0.08) !important; }
</style>