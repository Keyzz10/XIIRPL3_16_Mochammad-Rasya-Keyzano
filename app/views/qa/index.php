<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark"><?php _e('qa.title'); ?></h1>
        <p class="text-muted mb-0"><?php _e('qa.subtitle'); ?></p>
    </div>
    <div class="btn-group">
        <a href="index.php?url=qa/create-test-case" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i><?php _e('qa.new_test_case'); ?>
        </a>
        <a href="index.php?url=qa/create-test-suite" class="btn btn-outline-primary">
            <i class="fas fa-folder-plus me-2"></i><?php _e('qa.new_test_suite'); ?>
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-clipboard-check fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1"><?php _e('qa.test_cases'); ?></h6>
                <div class="h4 mb-0 text-primary"><?php echo count($testCases ?? []); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-folder fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1"><?php _e('qa.test_suites'); ?></h6>
                <div class="h4 mb-0 text-primary"><?php echo count($testSuites ?? []); ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Test Lulus</h6>
                <div class="h4 mb-0 text-primary"><?php echo $stats['passed_tests'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Test Gagal</h6>
                <div class="h4 mb-0 text-primary"><?php echo $stats['failed_tests'] ?? 0; ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-clipboard-check me-2 text-muted"></i>
                    Test Case Terbaru
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($testCases)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                        <h5>Tidak Ada Test Case</h5>
                        <p class="text-muted">Mulai dengan membuat test case pertama Anda.</p>
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
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($testCases, 0, 10) as $testCase): ?>
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
                                                <small class="text-muted"><?php echo substr(htmlspecialchars($desc), 0, 50) . '...'; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($testCase['project_name'] ?? 'Tidak ada proyek'); ?></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo ucfirst($testCase['type']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $priorityColors = [
                                            'low' => 'success',
                                            'medium' => 'warning',
                                            'high' => 'danger',
                                            'critical' => 'dark'
                                        ];
                                        $color = $priorityColors[$testCase['priority']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $color; ?>">
                                            <?php echo ucfirst($testCase['priority']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (isset($testCase['execution_status'])): ?>
                                            <?php
                                            $statusColors = [
                                                'pass' => 'success',
                                                'fail' => 'danger',
                                                'blocked' => 'warning',
                                                'not_executed' => 'secondary'
                                            ];
                                            $color = $statusColors[$testCase['execution_status']] ?? 'secondary';
                                            $statusText = ucfirst(str_replace('_', ' ', $testCase['execution_status']));
                                            ?>
                                            <span class="badge bg-<?php echo $color; ?>">
                                                <?php echo $statusText; ?>
                                            </span>
                                            <?php else: ?>
                                            <span class="badge bg-secondary">Belum Dieksekusi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="index.php?url=qa/test-case/<?php echo $testCase['id']; ?>" 
                                               class="btn btn-outline-primary" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="index.php?url=qa/run-test/<?php echo $testCase['id']; ?>" 
                                               class="btn btn-outline-success" title="Jalankan Test">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="index.php?url=qa/test-cases" class="btn btn-outline-primary">Lihat Semua Test Case</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-folder me-2 text-muted"></i>
                    Test Suite
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($testSuites)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-folder fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada test suite.</p>
                        <a href="index.php?url=qa/create-test-suite" class="btn btn-sm btn-outline-primary">Buat Suite</a>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach (array_slice($testSuites, 0, 5) as $suite): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($suite['name']); ?></h6>
                                <small class="text-muted"><?php echo $suite['test_count'] ?? 0; ?> test</small>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <a href="index.php?url=qa/test-suite/<?php echo $suite['id']; ?>" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?url=qa/run-suite/<?php echo $suite['id']; ?>" 
                                   class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center mt-3">
                        <a href="index.php?url=qa/test-suites" class="btn btn-outline-primary btn-sm">Lihat Semua Suite</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-tasks me-2 text-muted"></i>
                    Tugas Siap untuk QA (Selesai)
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($doneTasks)): ?>
                    <div class="text-muted">Tidak ada tugas berstatus Selesai.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tugas</th>
                                    <th>Proyek</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($doneTasks, 0, 10) as $task): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                                        <td><?php echo htmlspecialchars($task['project_name'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($task['assigned_to_name'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($task['updated_at'] ?? $task['created_at']); ?></td>
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
/* Dark mode fixes for QA tables and cards */
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
/* Dark mode table compatibility */
.table-darkmode-compatible { background-color: transparent; }
body.dark-mode .table-darkmode-compatible { background-color: transparent; }
</style>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>