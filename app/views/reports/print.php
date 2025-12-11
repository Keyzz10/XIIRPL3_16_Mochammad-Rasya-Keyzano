<?php /* Printable Reports Summary - use browser Print > Save as PDF */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Analitik - Print</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <style>
        body { padding: 24px; }
        h1 { font-size: 1.5rem; margin-bottom: 8px; }
        .meta { color: #6b7280; font-size: .9rem; margin-bottom: 16px; }
        .stat-card { border-radius: .75rem; border: 1px solid #e5e7eb; padding: 16px; margin-bottom: 12px; }
        .stat-number { font-size: 1.75rem; font-weight: 600; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-between align-items-center no-print mb-3">
        <div>
            <h1 class="mb-0">Ringkasan Laporan & Analitik</h1>
            <div class="meta">Digenerate pada <?php echo date('Y-m-d H:i'); ?>
                &middot;
                Peran: <?php echo htmlspecialchars($userRole); ?>
            </div>
        </div>
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print me-2"></i>Print / Save as PDF
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted mb-1">Total Proyek</div>
                        <div class="stat-number"><?php echo $projectStats ?? 0; ?></div>
                    </div>
                    <div style="color:#0ea5e9;">
                        <i class="fas fa-project-diagram fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted mb-1">Total Tugas</div>
                        <div class="stat-number"><?php echo $taskStats['total_tasks'] ?? 0; ?></div>
                    </div>
                    <div style="color:#0ea5e9;">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted mb-1">Bug Terbuka</div>
                        <div class="stat-number"><?php echo ($bugStats['new_bugs'] ?? 0) + ($bugStats['assigned_bugs'] ?? 0); ?></div>
                    </div>
                    <div style="color:#0ea5e9;">
                        <i class="fas fa-bug fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted mb-1">Pengguna Aktif</div>
                        <div class="stat-number"><?php echo $userStats['active_users'] ?? 0; ?></div>
                    </div>
                    <div style="color:#0ea5e9;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <h5 class="mb-2">Distribusi Status Tugas</h5>
            <table class="table table-bordered table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Status</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Akan Dikerjakan</td>
                        <td class="text-end"><?php echo $taskStats['todo_tasks'] ?? 0; ?></td>
                    </tr>
                    <tr>
                        <td>Sedang Dikerjakan</td>
                        <td class="text-end"><?php echo $taskStats['progress_tasks'] ?? 0; ?></td>
                    </tr>
                    <tr>
                        <td>Selesai</td>
                        <td class="text-end"><?php echo $taskStats['done_tasks'] ?? 0; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6 mb-3">
            <h5 class="mb-2">Rincian Keparahan Bug</h5>
            <table class="table table-bordered table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Level</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kritis</td>
                        <td class="text-end"><?php echo $bugStats['critical_bugs'] ?? 0; ?></td>
                    </tr>
                    <tr>
                        <td>Mayor</td>
                        <td class="text-end"><?php echo $bugStats['major_bugs'] ?? 0; ?></td>
                    </tr>
                    <tr>
                        <td>Minor</td>
                        <td class="text-end"><?php echo $bugStats['minor_bugs'] ?? 0; ?></td>
                    </tr>
                    <tr>
                        <td>Rendah</td>
                        <td class="text-end"><?php echo $bugStats['low_bugs'] ?? 0; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
</body>
</html>
