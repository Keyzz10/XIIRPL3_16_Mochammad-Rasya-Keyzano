<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
.deleted-comment-card {
    background-color: rgba(220, 53, 69, 0.05);
    border-left: 4px solid #dc3545;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Dark mode support for deleted comment cards */
body.dark-mode .deleted-comment-card {
    background-color: rgba(220, 53, 69, 0.1);
    border-left-color: #ef4444;
}

.comment-meta {
    font-size: 0.9em;
    color: #6c757d;
}

/* Dark mode support for comment meta */
body.dark-mode .comment-meta {
    color: #94a3b8 !important;
}

.comment-content {
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 6px;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid rgba(220, 53, 69, 0.2);
}

/* Dark mode support for comment content */
body.dark-mode .comment-content {
    background-color: rgba(51, 65, 85, 0.8);
    border-color: rgba(239, 68, 68, 0.3);
    color: #e2e8f0;
}

.restore-btn {
    background-color: #28a745;
    border-color: #28a745;
}
.restore-btn:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

/* Dark mode support for page title */
body.dark-mode .page-title {
    color: #e2e8f0 !important;
}

/* Dark mode support for subtitle */
body.dark-mode .page-subtitle {
    color: #94a3b8 !important;
}

/* Dark mode support for card headers */
body.dark-mode .card-header {
    background-color: #475569 !important;
    color: #e2e8f0 !important;
}

/* Dark mode support for comment text in bg-light areas */
body.dark-mode .bg-light {
    background-color: #475569 !important;
    color: #e2e8f0 !important;
}

/* Dark mode support for links */
body.dark-mode .comment-content a {
    color: #60a5fa !important;
}

body.dark-mode .comment-content a:hover {
    color: #93c5fd !important;
}

/* Dark mode support for badges */
body.dark-mode .badge.bg-info {
    background-color: #0ea5e9 !important;
    color: white !important;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 page-title">
            <i class="fas fa-trash-alt me-2 text-danger"></i>
            History Komentar Bug Dihapus
        </h1>
        <p class="page-subtitle mb-0">Daftar komentar bug yang telah dihapus</p>
    </div>
    <div class="btn-group">
        <a href="index.php?url=bugs" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Bug
        </a>
        <a href="index.php?url=tasks/deleted-comments" class="btn btn-outline-primary">
            <i class="fas fa-tasks me-2"></i>Komentar Tugas Dihapus
        </a>
    </div>
</div>

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

<?php if (empty($deletedComments)): ?>
    <div class="text-center py-5">
        <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
        <h4 class="page-subtitle">Tidak Ada Komentar yang Dihapus</h4>
        <p class="page-subtitle">Belum ada komentar bug yang dihapus.</p>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Komentar Bug Dihapus (<?php echo count($deletedComments); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php foreach ($deletedComments as $comment): ?>
                    <div class="deleted-comment-card p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center">
                                <?php 
                                $pp = $comment['profile_photo'] ?? '';
                                $imgPath = '';
                                if (!empty($pp)) {
                                    $imgPath = (strpos($pp, 'profiles/') === 0) ? ('uploads/' . $pp) : ('uploads/profiles/' . $pp);
                                }
                                $imgFull = ROOT_PATH . '/' . $imgPath;
                                $hasImg = !empty($imgPath) && file_exists($imgFull);
                                ?>
                                <div class="me-3">
                                    <?php if ($hasImg): ?>
                                        <img src="<?php echo $imgPath; ?>" alt="avatar" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width:40px;height:40px;">
                                            <?php echo strtoupper(substr($comment['full_name'] ?? $comment['username'] ?? 'U', 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <strong><?php echo htmlspecialchars($comment['full_name'] ?: ($comment['username'] ?? 'Unknown')); ?></strong>
                                    <div class="comment-meta">
                                        <i class="fas fa-calendar me-1"></i>
                                        Dibuat: <?php echo date('M d, Y H:i', strtotime($comment['created_at'])); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="comment-meta mb-2">
                                    <i class="fas fa-trash me-1 text-danger"></i>
                                    Dihapus: <?php echo date('M d, Y H:i', strtotime($comment['deleted_at'])); ?>
                                    <?php if (!empty($comment['deleted_by_name'])): ?>
                                        <br><small>oleh <strong><?php echo htmlspecialchars($comment['deleted_by_name']); ?></strong></small>
                                    <?php endif; ?>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?url=bugs/view/<?php echo $comment['bug_id']; ?>" class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Lihat Bug
                                    </a>
                                    <button type="button" class="btn restore-btn text-white" onclick="restoreComment(<?php echo $comment['bug_id']; ?>, <?php echo $comment['id']; ?>)">
                                        <i class="fas fa-undo me-1"></i>Kembalikan
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="comment-content">
                            <div class="mb-2">
                                <strong>Bug:</strong> 
                                <a href="index.php?url=bugs/view/<?php echo $comment['bug_id']; ?>" class="text-decoration-none">
                                    <?php echo htmlspecialchars($comment['bug_title']); ?>
                                </a>
                                <?php if (!empty($comment['project_name'])): ?>
                                    <span class="badge bg-info ms-2"><?php echo htmlspecialchars($comment['project_name']); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-2">
                                <strong>Komentar:</strong>
                            </div>
                            <div class="bg-light p-3 rounded">
                                <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Modal: Konfirmasi Kembalikan Komentar -->
<div class="modal fade" id="restoreCommentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="restoreCommentModalLabel">
          <i class="fas fa-undo me-2"></i>Konfirmasi Kembalikan Komentar
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3 p-md-4">
        <div class="text-center mb-3">
          <i class="fas fa-undo fa-3x text-success mb-3"></i>
          <h6>Apakah Anda yakin ingin mengembalikan komentar ini?</h6>
          <p class="text-muted mb-3">Komentar akan dikembalikan ke bug asalnya.</p>
          <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Komentar yang dikembalikan akan tersedia kembali di bug terkait.
          </div>
        </div>
      </div>
      <div class="modal-footer p-3 p-md-4">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Batal
          </button>
          <button type="button" class="btn btn-success" id="confirmRestoreCommentBtn">
            <i class="fas fa-undo me-1"></i>Ya, Kembalikan Komentar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let restoreBugId = null;
let restoreCommentId = null;

function restoreComment(bugId, commentId) {
    restoreBugId = bugId;
    restoreCommentId = commentId;
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('restoreCommentModal'));
    modal.show();
}

// Handle confirm restore button click
document.addEventListener('DOMContentLoaded', function() {
    const confirmRestoreBtn = document.getElementById('confirmRestoreCommentBtn');
    if (confirmRestoreBtn) {
        confirmRestoreBtn.addEventListener('click', function() {
            if (restoreBugId === null || restoreCommentId === null) return;
            
            // Create a form to submit the restore request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?url=bugs/restore-comment/' + restoreBugId + '/' + restoreCommentId;
            
            const confirmInput = document.createElement('input');
            confirmInput.type = 'hidden';
            confirmInput.name = 'confirm';
            confirmInput.value = 'yes';
            
            form.appendChild(confirmInput);
            document.body.appendChild(form);
            form.submit();
        });
    }
});
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>
