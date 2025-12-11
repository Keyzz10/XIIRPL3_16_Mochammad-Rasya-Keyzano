<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['success_message']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <?php echo htmlspecialchars($_SESSION['error_message']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Delete Confirmation Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-danger">Konfirmasi Hapus Task</h1>
        <p class="text-muted mb-0">Pastikan Anda benar-benar ingin menghapus task ini</p>
    </div>
    <a href="index.php?url=tasks/view/<?php echo $task['id']; ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Task
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Warning Alert -->
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading mb-1">Peringatan!</h5>
                    <p class="mb-0">Tindakan ini tidak dapat dibatalkan. Task dan semua data terkait akan dihapus secara permanen.</p>
                </div>
            </div>
        </div>

        <!-- Task Information Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Task yang Akan Dihapus
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <h4 class="text-dark mb-2"><?php echo htmlspecialchars($task['title']); ?></h4>
                        <p class="text-muted mb-3"><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                    </div>
                    <div class="col-md-4">
                        <div class="text-end">
                            <?php
                            $statusColors = [
                                'to_do' => 'secondary',
                                'in_progress' => 'primary',
                                'done' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $color = $statusColors[$task['status']] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?php echo $color; ?> fs-6 mb-2">
                                <?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?>
                            </span>
                            <br>
                            <?php
                            $priorityColors = [
                                'low' => 'success',
                                'medium' => 'warning',
                                'high' => 'danger',
                                'critical' => 'dark'
                            ];
                            $color = $priorityColors[$task['priority']] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?php echo $color; ?> fs-6">
                                <?php echo ucfirst($task['priority']); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Project:</strong>
                        <span class="ms-2"><?php echo htmlspecialchars($task['project_name'] ?? 'No Project'); ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Assigned To:</strong>
                        <span class="ms-2"><?php echo htmlspecialchars($task['assigned_to_name'] ?? 'Unassigned'); ?></span>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong>Created By:</strong>
                        <span class="ms-2"><?php echo htmlspecialchars($task['created_by_name'] ?? 'Unknown'); ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Created Date:</strong>
                        <span class="ms-2"><?php echo date('M d, Y H:i', strtotime($task['created_at'])); ?></span>
                    </div>
                </div>

                <?php if ($task['due_date']): ?>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong>Due Date:</strong>
                        <span class="ms-2"><?php echo date('M d, Y', strtotime($task['due_date'])); ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Estimated Hours:</strong>
                        <span class="ms-2"><?php echo $task['estimated_hours'] ?? 'Not specified'; ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- What Will Be Deleted -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-trash me-2"></i>
                    Data yang Akan Dihapus
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-danger me-2"></i>
                        <strong>Task utama</strong> - <?php echo htmlspecialchars($task['title']); ?>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-danger me-2"></i>
                        <strong>Semua komentar</strong> yang terkait dengan task ini
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-danger me-2"></i>
                        <strong>Semua attachment/file</strong> yang diupload ke task ini
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-danger me-2"></i>
                        <strong>Semua sub-tasks</strong> yang merupakan bagian dari task ini
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-danger me-2"></i>
                        <strong>Semua log aktivitas</strong> yang terkait dengan task ini
                    </li>
                </ul>
            </div>
        </div>

        <!-- Confirmation Form -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="text-center mb-4">
                        <h5 class="text-dark mb-3">Apakah Anda yakin ingin menghapus task ini?</h5>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait secara permanen.</p>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="index.php?url=tasks/view/<?php echo $task['id']; ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" name="confirm" value="yes" class="btn btn-danger btn-lg"
                                onclick="return confirm('Apakah Anda benar-benar yakin ingin menghapus task ini? Tindakan ini tidak dapat dibatalkan!')">
                            <i class="fas fa-trash me-2"></i>Ya, Hapus Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>
