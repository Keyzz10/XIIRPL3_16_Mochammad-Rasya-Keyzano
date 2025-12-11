<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
    <div>
        <h1 class="h2 mb-0 text-dark">Laporan QA</h1>
        <p class="text-muted mb-0">Ringkasan Test Cases, Test Suites, dan hasil eksekusi berdasarkan peran Anda.</p>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-download me-2"></i>Ekspor
        </button>
        <ul class="dropdown-menu">
            <li class="dropdown-header fw-semibold text-dark">Test Cases</li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_cases&format=csv"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_cases&format=excel"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
            <li><hr class="dropdown-divider"></li>
            <li class="dropdown-header fw-semibold text-dark">Test Suites</li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_suites&format=csv"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_suites&format=excel"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/qa_all&format=excel"><i class="fas fa-file-excel me-2"></i>Export Keduanya (Excel)</a></li>
        </ul>
    </div>
    
</div>

<div class="row mb-4 d-print-none">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">Total Test Cases</h6>
                    <div class="stat-number"><?php echo $caseStats['total_test_cases'] ?? 0; ?></div>
                </div>
                <div style="color: #6b7280;">
                    <i class="fas fa-vial fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">Passed</h6>
                    <div class="stat-number text-success"><?php echo $executionStats['passed_tests'] ?? 0; ?></div>
                </div>
                <div style="color: #16a34a;">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">Failed</h6>
                    <div class="stat-number text-danger"><?php echo $executionStats['failed_tests'] ?? 0; ?></div>
                </div>
                <div style="color: #dc2626;">
                    <i class="fas fa-times-circle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">Kritis / High</h6>
                    <div class="stat-number"><?php echo ($caseStats['critical_cases'] ?? 0) + ($caseStats['high_cases'] ?? 0); ?></div>
                </div>
                <div style="color: #f59e0b;">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row d-print-none">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">Daftar Test Cases</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Proyek</th>
                                <th>Prioritas</th>
                                <th>Tipe</th>
                                <th class="text-end">Exec</th>
                                <th class="text-end">Pass</th>
                                <th class="text-end">Fail</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($testCases)): foreach ($testCases as $tc): ?>
                            <tr>
                                <td class="text-truncate" style="max-width: 260px;">
                                    <a href="index.php?url=qa/test-case/<?php echo (int)$tc['id']; ?>" class="text-decoration-none"><?php echo htmlspecialchars($tc['title'] ?? ''); ?></a>
                                </td>
                                <td><?php echo htmlspecialchars($tc['project_name'] ?? ''); ?></td>
                                <td><span class="badge bg-<?php echo ($tc['priority'] ?? '') === 'critical' ? 'danger' : (($tc['priority'] ?? '') === 'high' ? 'warning' : 'secondary'); ?>"><?php echo htmlspecialchars($tc['priority'] ?? ''); ?></span></td>
                                <td><?php echo htmlspecialchars($tc['type'] ?? ''); ?></td>
                                <td class="text-end"><?php echo (int)($tc['execution_count'] ?? 0); ?></td>
                                <td class="text-end text-success"><?php echo (int)($tc['passed_count'] ?? 0); ?></td>
                                <td class="text-end text-danger"><?php echo (int)($tc['failed_count'] ?? 0); ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada test case.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">Daftar Test Suites</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Proyek</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th class="text-end">Cases</th>
                                <th class="text-end">Exec</th>
                                <th class="text-end">Pass</th>
                                <th class="text-end">Fail</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($testSuites)): foreach ($testSuites as $ts): ?>
                            <tr>
                                <td class="text-truncate" style="max-width: 260px;">
                                    <a href="index.php?url=qa/test-suite/<?php echo (int)$ts['id']; ?>" class="text-decoration-none"><?php echo htmlspecialchars($ts['name'] ?? ''); ?></a>
                                </td>
                                <td><?php echo htmlspecialchars($ts['project_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($ts['type'] ?? ''); ?></td>
                                <td><span class="badge bg-<?php echo ($ts['priority'] ?? '') === 'critical' ? 'danger' : (($ts['priority'] ?? '') === 'high' ? 'warning' : 'secondary'); ?>"><?php echo htmlspecialchars($ts['priority'] ?? ''); ?></span></td>
                                <td class="text-end"><?php echo (int)($ts['test_case_count'] ?? 0); ?></td>
                                <td class="text-end"><?php echo (int)($ts['execution_count'] ?? 0); ?></td>
                                <td class="text-end text-success"><?php echo (int)($ts['passed_count'] ?? 0); ?></td>
                                <td class="text-end text-danger"><?php echo (int)($ts['failed_count'] ?? 0); ?></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada test suite.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print View Section -->
<div class="d-none d-print-block">
    <div class="d-flex align-items-center mb-4 pb-3" style="border-bottom: 2px solid #000; color:#fff;">
        <div class="me-4">
            <img src="uploads/images (2).png" alt="Logo" style="height: 80px; width: auto; object-fit: contain;">
        </div>
        <div class="text-center flex-grow-1">
            <h2 class="fw-bold mb-1" style="font-size: 24px; color: #fff;">PT Nawatara Nusantara Teknologi</h2>
            <p class="mb-0" style="font-size: 14px; color: #fff;">Ruko Pasar Modern Grand Wisata Blok PR 1 No 3, Lambangsari, Kec. Tambun Sel., Kabupaten Bekasi, Jawa Barat 17510</p>
        </div>
    </div>

    <h3 class="text-center mb-4 fw-bold" style="color: #fff;">Laporan QA</h3>

    <div class="mb-5">
        <h4 class="mb-3 fw-bold">Daftar Test Cases</h4>
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="table-light border-dark">
                    <th class="border-dark text-center" style="width: 5%;">No</th>
                    <th class="border-dark">Judul</th>
                    <th class="border-dark">Proyek</th>
                    <th class="border-dark text-center">Prioritas</th>
                    <th class="border-dark text-center">Tipe</th>
                    <th class="border-dark text-center">Exec</th>
                    <th class="border-dark text-center">Pass</th>
                    <th class="border-dark text-center">Fail</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; if (!empty($testCases)): foreach ($testCases as $tc): ?>
                <tr class="border-dark">
                    <td class="border-dark text-center"><?php echo $no++; ?></td>
                    <td class="border-dark fw-bold"><?php echo htmlspecialchars($tc['title'] ?? ''); ?></td>
                    <td class="border-dark"><?php echo htmlspecialchars($tc['project_name'] ?? ''); ?></td>
                    <td class="border-dark text-center"><?php echo htmlspecialchars($tc['priority'] ?? ''); ?></td>
                    <td class="border-dark text-center"><?php echo htmlspecialchars($tc['type'] ?? ''); ?></td>
                    <td class="border-dark text-center"><?php echo (int)($tc['execution_count'] ?? 0); ?></td>
                    <td class="border-dark text-center text-success fw-bold"><?php echo (int)($tc['passed_count'] ?? 0); ?></td>
                    <td class="border-dark text-center text-danger fw-bold"><?php echo (int)($tc['failed_count'] ?? 0); ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="8" class="text-center border-dark">Belum ada test case.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div>
        <h4 class="mb-3 fw-bold">Daftar Test Suites</h4>
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="table-light border-dark">
                    <th class="border-dark text-center" style="width: 5%;">No</th>
                    <th class="border-dark">Nama</th>
                    <th class="border-dark">Proyek</th>
                    <th class="border-dark text-center">Tipe</th>
                    <th class="border-dark text-center">Prioritas</th>
                    <th class="border-dark text-center">Cases</th>
                    <th class="border-dark text-center">Exec</th>
                    <th class="border-dark text-center">Pass</th>
                    <th class="border-dark text-center">Fail</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; if (!empty($testSuites)): foreach ($testSuites as $ts): ?>
                <tr class="border-dark">
                    <td class="border-dark text-center"><?php echo $no++; ?></td>
                    <td class="border-dark fw-bold"><?php echo htmlspecialchars($ts['name'] ?? ''); ?></td>
                    <td class="border-dark"><?php echo htmlspecialchars($ts['project_name'] ?? ''); ?></td>
                    <td class="border-dark text-center"><?php echo htmlspecialchars($ts['type'] ?? ''); ?></td>
                    <td class="border-dark text-center"><?php echo htmlspecialchars($ts['priority'] ?? ''); ?></td>
                    <td class="border-dark text-center"><?php echo (int)($ts['test_case_count'] ?? 0); ?></td>
                    <td class="border-dark text-center"><?php echo (int)($ts['execution_count'] ?? 0); ?></td>
                    <td class="border-dark text-center text-success fw-bold"><?php echo (int)($ts['passed_count'] ?? 0); ?></td>
                    <td class="border-dark text-center text-danger fw-bold"><?php echo (int)($ts['failed_count'] ?? 0); ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="9" class="text-center border-dark">Belum ada test suite.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="print-signature text-end mt-5" style="color:#fff;">
        <div>Bekasi, <?php echo date('d/m/Y'); ?></div>
        <div style="height:60px;"></div>
        <div>(<?php echo htmlspecialchars($currentUser['full_name'] ?? ($currentUser['username'] ?? '')); ?>)</div>
    </div>
</div>

<style>
@media print {
    @page {
        size: landscape;
        margin: 1cm;
    }
    body {
        background: white !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .sidebar, .navbar, .btn, .card-header, .d-print-none {
        display: none !important;
    }
    .main-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .card-body {
        padding: 0 !important;
    }
    .d-print-block {
        display: block !important;
    }
    /* Background halaman print putih */
    body,
    .main-content,
    .d-print-block,
    .d-print-block * {
        background-color: #ffffff !important;
        color: #000000 !important;
    }
    /* Override mobile responsive table (which hides thead) when printing */
    .table thead {
        display: table-header-group !important;
    }
    .table tbody tr {
        display: table-row !important;
        border: 1px solid #000 !important;
    }
    .table tbody td {
        display: table-cell !important;
    }
    /* Hilangkan label kolon dari mode responsif saat print */
    .table td::before,
    .table th::before {
        content: '' !important;
        display: none !important;
    }
    .print-signature {
        margin-top: 40px;
        padding-right: 1cm;
    }
    /* Paksa background tabel putih saat print */
    .table,
    .table thead tr,
    .table thead th,
    .table tbody tr,
    .table tbody td {
        background-color: #ffffff !important;
        color: #000000 !important;
    }
    /* Ensure table borders are visible and tertutup penuh in print */
    .table-bordered {
        border: 1px solid #000 !important;
        border-collapse: collapse !important;
        border-spacing: 0 !important;
        box-shadow: inset -1px 0 0 #000; /* paksa garis kanan */
        outline: 1px solid #000 !important; /* frame luar cadangan */
        border-radius: 0 !important;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #000 !important;
    }
    /* Pastikan garis atas dan kanan tabel tertutup */
    .table-bordered > thead > tr:first-child > th,
    .table-bordered > thead > tr:first-child > td {
        border-top: 1px solid #000 !important;
    }
    .table-bordered > thead > tr > th:last-child,
    .table-bordered > thead > tr > td:last-child,
    .table-bordered > tbody > tr > th:last-child,
    .table-bordered > tbody > tr > td:last-child {
        border-right: 1px solid #000 !important;
    }
}
</style>

<?php if (!empty($_GET['print'])): ?>
<script>
    window.addEventListener('load', function () {
        setTimeout(function() {
            window.print();
        }, 500);
    });
</script>
<?php endif; ?>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

