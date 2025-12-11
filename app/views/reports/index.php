<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<!-- Reports Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark">Laporan & Analitik</h1>
        <p class="text-muted mb-0">
            <?php 
            $roleDescriptions = [
                'super_admin' => 'Wawasan dan analitik menyeluruh untuk seluruh sistem',
                'admin' => 'Wawasan dan analitik menyeluruh untuk proyek, tugas, dan performa tim Anda',
                'project_manager' => 'Laporan proyek yang Anda kelola dan performa tim',
                'developer' => 'Laporan tugas yang ditugaskan kepada Anda',
                'qa_tester' => 'Laporan bug dan tugas testing yang ditugaskan kepada Anda',
                'client' => 'Laporan proyek yang terkait dengan Anda'
            ];
            echo $roleDescriptions[$userRole] ?? 'Laporan dan analitik berdasarkan peran Anda';
            ?>
        </p>
    </div>
    <?php if (in_array($userRole, ['super_admin', 'admin', 'project_manager'])): ?>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-download me-2"></i>Ekspor Laporan
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="index.php?url=reports/print&print=1" target="_blank">
                    <i class="fas fa-print me-2"></i>Print Ringkasan (PDF)
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li class="dropdown-header fw-semibold text-dark">Laporan Proyek</li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/projects&format=csv"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/projects&format=excel"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/projects&print=1" target="_blank"><i class="fas fa-print me-2"></i>Print / PDF</a></li>
            <li><hr class="dropdown-divider"></li>
            <li class="dropdown-header fw-semibold text-dark">Laporan Tugas</li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/tasks&format=csv"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/tasks&format=excel"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/tasks&print=1" target="_blank"><i class="fas fa-print me-2"></i>Print / PDF</a></li>
            <li><hr class="dropdown-divider"></li>
            <li class="dropdown-header fw-semibold text-dark">Laporan Bug</li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/bugs&format=csv"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/bugs&format=excel"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/bugs&print=1" target="_blank"><i class="fas fa-print me-2"></i>Print / PDF</a></li>
            <li><hr class="dropdown-divider"></li>
            <?php if (!in_array($userRole, ['developer'])): ?>
            <li class="dropdown-header fw-semibold text-dark">Laporan QA</li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_cases&format=csv"><i class="fas fa-vial me-2"></i>Test Cases (CSV)</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_cases&format=excel"><i class="fas fa-vial me-2"></i>Test Cases (Excel)</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_suites&format=csv"><i class="fas fa-flask me-2"></i>Test Suites (CSV)</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/test_suites&format=excel"><i class="fas fa-flask me-2"></i>Test Suites (Excel)</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/qa&print=1" target="_blank"><i class="fas fa-print me-2"></i>Print / PDF</a></li>
            <li><a class="dropdown-item" href="index.php?url=reports/export/qa_all&format=excel"><i class="fas fa-file-excel me-2"></i>Export Keduanya (Excel)</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>

<style>
/* Improve dropdown header contrast in dark mode */
body.dark-mode .dropdown-menu .dropdown-header { color: #e2e8f0 !important; }
/* In light mode, ensure it's visibly darker */
.dropdown-menu .dropdown-header { color: #1f2937; }
</style>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">
                        <?php 
                        $projectLabels = [
                            'super_admin' => 'Total Proyek',
                            'admin' => 'Total Proyek',
                            'project_manager' => 'Proyek Saya',
                            'developer' => 'Proyek Saya',
                            'qa_tester' => 'Proyek Saya',
                            'client' => 'Proyek Saya'
                        ];
                        echo $projectLabels[$userRole] ?? 'Total Proyek';
                        ?>
                    </h6>
                    <div class="stat-number"><?php echo $projectStats ?? 0; ?></div>
                </div>
                <div style="color: #0ea5e9;">
                    <i class="fas fa-project-diagram fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">
                        <?php 
                        $taskLabels = [
                            'super_admin' => 'Total Tugas',
                            'admin' => 'Total Tugas',
                            'project_manager' => 'Tugas Tim',
                            'developer' => 'Tugas Saya',
                            'qa_tester' => 'Tugas Saya',
                            'client' => 'Tugas Proyek'
                        ];
                        echo $taskLabels[$userRole] ?? 'Total Tugas';
                        ?>
                    </h6>
                    <div class="stat-number"><?php echo $taskStats['total_tasks'] ?? 0; ?></div>
                </div>
                <div style="color: #0ea5e9;">
                    <i class="fas fa-tasks fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">
                        <?php 
                        $bugLabels = [
                            'super_admin' => 'Bug Terbuka',
                            'admin' => 'Bug Terbuka',
                            'project_manager' => 'Bug Proyek',
                            'developer' => 'Bug Saya',
                            'qa_tester' => 'Bug Saya',
                            'client' => 'Bug Proyek'
                        ];
                        echo $bugLabels[$userRole] ?? 'Bug Terbuka';
                        ?>
                    </h6>
                    <div class="stat-number"><?php echo ($bugStats['new_bugs'] ?? 0) + ($bugStats['assigned_bugs'] ?? 0); ?></div>
                </div>
                <div style="color: #0ea5e9;">
                    <i class="fas fa-bug fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="text-muted mb-2">
                        <?php 
                        $userLabels = [
                            'super_admin' => 'Pengguna Aktif',
                            'admin' => 'Pengguna Aktif',
                            'project_manager' => 'Anggota Tim',
                            'developer' => 'Status Saya',
                            'qa_tester' => 'Status Saya',
                            'client' => 'Status Saya'
                        ];
                        echo $userLabels[$userRole] ?? 'Pengguna Aktif';
                        ?>
                    </h6>
                    <div class="stat-number"><?php echo $userStats['active_users'] ?? 0; ?></div>
                </div>
                <div style="color: #0ea5e9;">
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <?php 
                    $taskDistributionLabels = [
                        'super_admin' => 'Distribusi Status Tugas',
                        'admin' => 'Distribusi Status Tugas',
                        'project_manager' => 'Distribusi Tugas Tim',
                        'developer' => 'Status Tugas Saya',
                        'qa_tester' => 'Status Tugas Saya',
                        'client' => 'Status Tugas Proyek'
                    ];
                    echo $taskDistributionLabels[$userRole] ?? 'Distribusi Status Tugas';
                    ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="h3 text-secondary"><?php echo $taskStats['todo_tasks'] ?? 0; ?></div>
                        <div class="text-muted">Akan Dikerjakan</div>
                    </div>
                    <div class="col-4">
                        <div class="h3 text-warning"><?php echo $taskStats['progress_tasks'] ?? 0; ?></div>
                        <div class="text-muted">Sedang Dikerjakan</div>
                    </div>
                    <div class="col-4">
                        <div class="h3 text-success"><?php echo $taskStats['done_tasks'] ?? 0; ?></div>
                        <div class="text-muted">Selesai</div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="index.php?url=reports/tasks" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chart-bar me-2"></i>
                        <?php 
                        $taskReportLabels = [
                            'super_admin' => 'Lihat Laporan Tugas Lengkap',
                            'admin' => 'Lihat Laporan Tugas Lengkap',
                            'project_manager' => 'Lihat Laporan Tugas Tim',
                            'developer' => 'Lihat Tugas Saya',
                            'qa_tester' => 'Lihat Tugas Saya',
                            'client' => 'Lihat Tugas Proyek'
                        ];
                        echo $taskReportLabels[$userRole] ?? 'Lihat Laporan Tugas Lengkap';
                        ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <?php 
                    $bugSeverityLabels = [
                        'super_admin' => 'Rincian Keparahan Bug',
                        'admin' => 'Rincian Keparahan Bug',
                        'project_manager' => 'Keparahan Bug Proyek',
                        'developer' => 'Bug yang Ditugaskan',
                        'qa_tester' => 'Bug yang Ditugaskan',
                        'client' => 'Bug Proyek'
                    ];
                    echo $bugSeverityLabels[$userRole] ?? 'Rincian Keparahan Bug';
                    ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-3">
                        <div class="h3 text-danger"><?php echo $bugStats['critical_bugs'] ?? 0; ?></div>
                        <div class="text-muted">Kritis</div>
                    </div>
                    <div class="col-3">
                        <div class="h3 text-warning"><?php echo $bugStats['major_bugs'] ?? 0; ?></div>
                        <div class="text-muted">Mayor</div>
                    </div>
                    <div class="col-3">
                        <div class="h3 text-info"><?php echo $bugStats['minor_bugs'] ?? 0; ?></div>
                        <div class="text-muted">Minor</div>
                    </div>
                    <div class="col-3">
                        <div class="h3 text-success"><?php echo $bugStats['low_bugs'] ?? 0; ?></div>
                        <div class="text-muted">Rendah</div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="index.php?url=reports/bugs" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-bug me-2"></i>
                        <?php 
                        $bugReportLabels = [
                            'super_admin' => 'Lihat Laporan Bug Lengkap',
                            'admin' => 'Lihat Laporan Bug Lengkap',
                            'project_manager' => 'Lihat Bug Proyek',
                            'developer' => 'Lihat Bug Saya',
                            'qa_tester' => 'Lihat Bug Saya',
                            'client' => 'Lihat Bug Proyek'
                        ];
                        echo $bugReportLabels[$userRole] ?? 'Lihat Laporan Bug Lengkap';
                        ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <?php 
                    $quickReportLabels = [
                        'super_admin' => 'Laporan Cepat',
                        'admin' => 'Laporan Cepat',
                        'project_manager' => 'Laporan Proyek & Tim',
                        'developer' => 'Laporan Tugas & Bug Saya',
                        'qa_tester' => 'Laporan Testing & Bug Saya',
                        'client' => 'Laporan Proyek Saya'
                    ];
                    echo $quickReportLabels[$userRole] ?? 'Laporan Cepat';
                    ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-grid">
                            <a href="index.php?url=reports/projects" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-project-diagram fa-2x d-block mb-2"></i>
                                <strong>
                                    <?php 
                                    $projectReportLabels = [
                                        'super_admin' => 'Laporan Proyek',
                                        'admin' => 'Laporan Proyek',
                                        'project_manager' => 'Proyek Saya',
                                        'developer' => 'Proyek Saya',
                                        'qa_tester' => 'Proyek Saya',
                                        'client' => 'Proyek Saya'
                                    ];
                                    echo $projectReportLabels[$userRole] ?? 'Laporan Proyek';
                                    ?>
                                </strong>
                                <small class="d-block text-muted">
                                    <?php 
                                    $projectDescLabels = [
                                        'super_admin' => 'Lihat progres dan statistik proyek',
                                        'admin' => 'Lihat progres dan statistik proyek',
                                        'project_manager' => 'Lihat progres proyek yang Anda kelola',
                                        'developer' => 'Lihat progres proyek yang Anda ikuti',
                                        'qa_tester' => 'Lihat progres proyek yang Anda ikuti',
                                        'client' => 'Lihat progres proyek Anda'
                                    ];
                                    echo $projectDescLabels[$userRole] ?? 'Lihat progres dan statistik proyek';
                                    ?>
                                </small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <a href="index.php?url=reports/tasks" class="btn btn-outline-info btn-lg">
                                <i class="fas fa-tasks fa-2x d-block mb-2"></i>
                                <strong>
                                    <?php 
                                    $taskReportLabels = [
                                        'super_admin' => 'Laporan Tugas',
                                        'admin' => 'Laporan Tugas',
                                        'project_manager' => 'Tugas Tim',
                                        'developer' => 'Tugas Saya',
                                        'qa_tester' => 'Tugas Saya',
                                        'client' => 'Tugas Proyek'
                                    ];
                                    echo $taskReportLabels[$userRole] ?? 'Laporan Tugas';
                                    ?>
                                </strong>
                                <small class="d-block text-muted">
                                    <?php 
                                    $taskDescLabels = [
                                        'super_admin' => 'Analisis penyelesaian tugas dan keterlambatan',
                                        'admin' => 'Analisis penyelesaian tugas dan keterlambatan',
                                        'project_manager' => 'Analisis tugas tim dan keterlambatan',
                                        'developer' => 'Analisis tugas yang ditugaskan kepada Anda',
                                        'qa_tester' => 'Analisis tugas testing yang ditugaskan kepada Anda',
                                        'client' => 'Analisis tugas dalam proyek Anda'
                                    ];
                                    echo $taskDescLabels[$userRole] ?? 'Analisis penyelesaian tugas dan keterlambatan';
                                    ?>
                                </small>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <a href="index.php?url=reports/bugs" class="btn btn-outline-danger btn-lg">
                                <i class="fas fa-bug fa-2x d-block mb-2"></i>
                                <strong>
                                    <?php 
                                    $bugReportLabels = [
                                        'super_admin' => 'Laporan Bug',
                                        'admin' => 'Laporan Bug',
                                        'project_manager' => 'Bug Proyek',
                                        'developer' => 'Bug Saya',
                                        'qa_tester' => 'Bug Saya',
                                        'client' => 'Bug Proyek'
                                    ];
                                    echo $bugReportLabels[$userRole] ?? 'Laporan Bug';
                                    ?>
                                </strong>
                                <small class="d-block text-muted">
                                    <?php 
                                    $bugDescLabels = [
                                        'super_admin' => 'Lacak penyelesaian bug dan tren',
                                        'admin' => 'Lacak penyelesaian bug dan tren',
                                        'project_manager' => 'Lacak bug dalam proyek Anda',
                                        'developer' => 'Lacak bug yang ditugaskan kepada Anda',
                                        'qa_tester' => 'Lacak bug yang ditugaskan kepada Anda',
                                        'client' => 'Lacak bug dalam proyek Anda'
                                    ];
                                    echo $bugDescLabels[$userRole] ?? 'Lacak penyelesaian bug dan tren';
                                    ?>
                                </small>
                            </a>
                        </div>
                    </div>
                    <?php if (!in_array($userRole, ['developer'])): ?>
                    <div class="col-md-4 mt-3">
                        <div class="d-grid">
                            <a href="index.php?url=reports/qa" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-vials fa-2x d-block mb-2"></i>
                                <strong>Laporan QA</strong>
                                <small class="d-block text-muted">Test Cases, Test Suites, dan hasil eksekusi</small>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>