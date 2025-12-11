<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Detail Test Suite</h1>
        <p class="text-muted mb-0">Informasi lengkap test suite</p>
    </div>
    <div class="d-flex gap-2">
        <a href="index.php?url=qa/test-suites" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <?php if ($currentUser && in_array($currentUser['role'], ['super_admin', 'admin'])): ?>
        <a href="index.php?url=qa/edit-test-suite/<?php echo $suite['id']; ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <?php endif; ?>
    </div>
    
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-dark"><i class="fas fa-layer-group me-2 text-primary"></i><?php echo htmlspecialchars($suite['name']); ?></h5>
            </div>
            <div class="card-body">
                <p class="mb-3"><?php echo nl2br(htmlspecialchars($suite['description'] ?? '')); ?></p>
                <div class="small text-muted">Proyek: <strong><?php echo htmlspecialchars($suite['project_name'] ?? ''); ?></strong></div>
                <div class="small text-muted">Dibuat oleh: <strong><?php echo htmlspecialchars($suite['created_by_name'] ?? ''); ?></strong></div>
                <div class="small text-muted">Dibuat: <strong><?php echo date('d M Y, H:i', strtotime($suite['created_at'])); ?></strong></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0 text-dark"><i class="fas fa-list me-2 text-muted"></i>Test Case dalam Suite</h6>
            </div>
            <div class="card-body p-0">
                <?php if (empty($testCases)): ?>
                    <div class="p-3 text-muted">Belum ada test case di suite ini.</div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($testCases as $tc): ?>
                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" href="index.php?url=qa/test-case/<?php echo $tc['id']; ?>">
                                <div class="me-3" style="min-width:0;">
                                    <div class="fw-semibold text-truncate" title="<?php echo htmlspecialchars($tc['title'] ?? ''); ?>"><?php echo htmlspecialchars($tc['title'] ?? ''); ?></div>
                                    <?php if (!empty($tc['description'])): ?>
                                    <div class="small text-muted text-truncate" style="max-width: 46vw;">
                                        <?php echo htmlspecialchars($tc['description']); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-nowrap small text-muted">Ditambahkan: <?php echo date('d M Y', strtotime($tc['added_at'] ?? $suite['created_at'])); ?></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0 text-dark"><i class="fas fa-info-circle me-2 text-info"></i>Ringkasan</h6>
            </div>
            <div class="card-body">
                <div class="mb-2 small text-muted">Total Test Case</div>
                <div class="h5"><?php echo (int)($stats['total_test_cases'] ?? count($testCases)); ?></div>
                <hr>
                <a href="index.php?url=qa/run-suite/<?php echo $suite['id']; ?>" class="btn btn-success w-100">
                    <i class="fas fa-play me-2"></i>Jalankan Suite
                </a>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>


