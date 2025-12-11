<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
    <div>
        <h1 class="h2 mb-0 text-dark">Laporan Bug</h1>
        <p class="text-muted mb-0">Ringkasan bug beserta keparahan dan statusnya</p>
    </div>
    <a href="index.php?url=reports" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Laporan
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-bug me-2 text-muted"></i>Daftar Bug
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($bugs)): ?>
            <div class="text-center text-muted">Tidak ada data bug.</div>
        <?php else: ?>
        <!-- Screen View Table -->
        <div class="table-responsive d-print-none">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Proyek</th>
                        <th>Keparahan</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Dilaporkan Oleh</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bugs as $b): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($b['title'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($b['project_name'] ?? '-'); ?></td>
                        <td><?php echo ucfirst($b['severity'] ?? ''); ?></td>
                        <td><?php echo ucfirst($b['priority'] ?? ''); ?></td>
                        <td><?php echo ucfirst(str_replace('_',' ', $b['status'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars($b['reported_by_name'] ?? '-'); ?></td>
                        <td><?php echo !empty($b['created_at']) ? date('Y-m-d', strtotime($b['created_at'])) : '-'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

            <h3 class="text-center mb-4 fw-bold" style="color: #fff;">Laporan Bug</h3>

            <table class="table table-bordered border-dark">
                <thead>
                    <tr class="table-light border-dark">
                        <th class="border-dark text-center" style="width: 5%;">No</th>
                        <th class="border-dark">Judul Bug</th>
                        <th class="border-dark">Proyek</th>
                        <th class="border-dark text-center">Keparahan</th>
                        <th class="border-dark text-center">Prioritas</th>
                        <th class="border-dark text-center">Status</th>
                        <th class="border-dark">Dilaporkan Oleh</th>
                        <th class="border-dark text-center">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($bugs as $b): ?>
                    <tr class="border-dark">
                        <td class="border-dark text-center"><?php echo $no++; ?></td>
                        <td class="border-dark fw-bold"><?php echo htmlspecialchars($b['title'] ?? ''); ?></td>
                        <td class="border-dark"><?php echo htmlspecialchars($b['project_name'] ?? '-'); ?></td>
                        <td class="border-dark text-center"><?php echo ucfirst($b['severity'] ?? ''); ?></td>
                        <td class="border-dark text-center"><?php echo ucfirst($b['priority'] ?? ''); ?></td>
                        <td class="border-dark text-center"><?php echo ucfirst(str_replace('_',' ', $b['status'] ?? '')); ?></td>
                        <td class="border-dark"><?php echo htmlspecialchars($b['reported_by_name'] ?? '-'); ?></td>
                        <td class="border-dark text-center"><?php echo !empty($b['created_at']) ? date('d/m/Y', strtotime($b['created_at'])) : '-'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="print-signature text-end mt-5" style="color:#fff;">
                <div>Bekasi, <?php echo date('d/m/Y'); ?></div>
                <div style="height:60px;"></div>
                <div>(<?php echo htmlspecialchars($currentUser['full_name'] ?? ($currentUser['username'] ?? '')); ?>)</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($criticalBugs)): ?>
<div class="card d-print-none">
    <div class="card-header bg-light border-bottom">
        <h5 class="card-title mb-0 text-dark">
            <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Bug Kritis
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Proyek</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($criticalBugs as $b): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($b['title'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($b['project_name'] ?? '-'); ?></td>
                        <td><?php echo ucfirst(str_replace('_',' ', $b['status'] ?? '')); ?></td>
                        <td class="text-danger fw-bold"><?php echo date('Y-m-d', strtotime($b['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
body.dark-mode .card { background-color: #334155; border-color: #475569; }
body.dark-mode .card-header { background-color: #475569 !important; border-color: #64748b !important; }
body.dark-mode .text-dark { color: #e2e8f0 !important; }
body.dark-mode .table { background-color: transparent; color: #e2e8f0; }
body.dark-mode .table thead { background-color: #0f172a; color: #e2e8f0; }
body.dark-mode .table tbody tr:nth-child(even) { background-color: #253041; }
body.dark-mode .table tbody tr:nth-child(odd) { background-color: #1f2a3a; }
body.dark-mode .table > :not(caption) > * > * { background-color: transparent !important; color: #e2e8f0; }

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


