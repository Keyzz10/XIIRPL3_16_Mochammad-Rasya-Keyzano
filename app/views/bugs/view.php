<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark"><?php echo htmlspecialchars($bug['title']); ?></h1>
        <p class="text-muted mb-0"><?php echo htmlspecialchars($bug['project_id'] ?? ''); ?></p>
    </div>
    <div class="btn-group">
        <?php if (in_array(($currentUser['role'] ?? ''), ['super_admin','admin','project_manager','qa_tester'])): ?>
        <a href="index.php?url=bugs/edit/<?php echo $bug['id']; ?>" class="btn btn-outline-secondary">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <?php endif; ?>
        <a href="index.php?url=bugs" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <?php if (in_array(($currentUser['role'] ?? ''), ['super_admin','admin','project_manager'])): ?>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBugModal">
            <i class="fas fa-trash me-2"></i>Hapus Bug
        </button>
        <?php endif; ?>
    </div>
    </div>

<div class="card">
    <div class="card-body">
        <h6 class="text-muted">Deskripsi</h6>
        <div class="mb-4">
            <p class="mb-2"><i class="fas fa-align-left me-2 text-primary"></i><?php echo nl2br(htmlspecialchars($bug['description'])); ?></p>
            <?php 
            // Konversi label severity enum ke label user-friendly:
            $sevLabel = '-';
            switch($bug['severity'] ?? '') {
              case 'critical': $sevLabel = 'Kritis'; break;
              case 'major': $sevLabel = 'Mayor'; break;
              case 'minor': $sevLabel = 'Minor'; break;
              case 'trivial': $sevLabel = 'Trivial'; break;
            }
            ?>
            <p class="mb-2"><span class="fw-bold text-warning"><i class="fas fa-exclamation-circle me-1"></i>Tingkat Keparahan:</span> <?php echo $sevLabel; ?></p>
            <?php if (!empty($attachments)): ?>
            <div class="mt-3">
                <strong>Lampiran:</strong>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <?php foreach ($attachments as $att): ?>
                        <?php if (empty($att['comment_id'])): // hanya lampiran utama ?>
                            <?php $isImg = preg_match('/\.(png|jpe?g|gif|webp)$/i', (string)($att['file_name'] ?? $att['file_path'] ?? '')) === 1; ?>
                            <a href="<?php echo $att['file_path']; ?>" target="_blank" class="text-decoration-none">
                                <?php if ($isImg): ?>
                                    <img src="<?php echo $att['file_path']; ?>" alt="attachment" style="width:80px;height:80px;object-fit:cover;border-radius:4px;border:1px solid #ccc;">
                                <?php else: ?>
                                    <span class="badge bg-secondary">Download: <?php echo htmlspecialchars($att['file_name'] ?? 'File'); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card bg-light mb-2 border-0 shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="mb-1 text-primary"><i class="fas fa-list-ol me-2"></i>Langkah Reproduksi</h6>
                        <div class="ps-3 small text-dark" style="white-space:pre-line;"><?php echo isset($bug['steps_to_reproduce']) && trim($bug['steps_to_reproduce']) !== '' ? nl2br(htmlspecialchars($bug['steps_to_reproduce'])) : '<span class="text-muted">(Belum diisi)</span>'; ?></div>
                    </div>
                </div>
                <div class="card bg-light mb-2 border-0 shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="mb-1 text-success"><i class="fas fa-check-circle me-2"></i>Hasil yang Diharapkan</h6>
                        <div class="ps-3 small text-dark" style="white-space:pre-line;"><?php echo isset($bug['expected_result']) && trim($bug['expected_result']) !== '' ? nl2br(htmlspecialchars($bug['expected_result'])) : '<span class="text-muted">(Belum diisi)</span>'; ?></div>
                    </div>
                </div>
                <div class="card bg-light mb-2 border-0 shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="mb-1 text-danger"><i class="fas fa-times-circle me-2"></i>Hasil Aktual</h6>
                        <div class="ps-3 small text-dark" style="white-space:pre-line;"><?php echo isset($bug['actual_result']) && trim($bug['actual_result']) !== '' ? nl2br(htmlspecialchars($bug['actual_result'])) : '<span class="text-muted">(Belum diisi)</span>'; ?></div>
                    </div>
                </div>
                <div class="card bg-light mb-4 border-0 shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="mb-1 text-info"><i class="fas fa-info-circle me-2"></i>Informasi Lingkungan Bug</h6>
                        <dl class="row mb-0">
                            <dt class="col-sm-3"><i class="fas fa-desktop me-1"></i>Sistem Operasi</dt>
                            <dd class="col-sm-9 mb-2"><?php echo isset($bug['os']) && trim($bug['os']) !== '' ? htmlspecialchars($bug['os']) : '<span class="text-muted">(Belum diisi)</span>'; ?></dd>
                            <dt class="col-sm-3"><i class="fas fa-browser me-1"></i>Browser</dt>
                            <dd class="col-sm-9 mb-2"><?php echo isset($bug['browser']) && trim($bug['browser']) !== '' ? htmlspecialchars($bug['browser']) : '<span class="text-muted">(Belum diisi)</span>'; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($bug['tags'])): ?>
        <div class="row g-3 mt-2">
            <div class="col-12">
                <strong>Tag:</strong>
                <?php 
                $tags = explode(',', $bug['tags']);
                foreach ($tags as $tag): 
                    $tag = trim($tag);
                    if ($tag): ?>
                        <span class="badge bg-info me-1"><?php echo htmlspecialchars($tag); ?></span>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($bug['due_date'])): ?>
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <strong>Batas Waktu:</strong>
                <?php 
                $dueDate = new DateTime($bug['due_date']);
                $now = new DateTime();
                $isOverdue = $dueDate < $now && !in_array($bug['status'], ['resolved', 'closed']);
                ?>
                <span class="<?php echo $isOverdue ? 'text-danger fw-bold' : 'text-muted'; ?>">
                    <?php echo $dueDate->format('M d, Y'); ?>
                    <?php if ($isOverdue): ?>
                        <i class="fas fa-exclamation-triangle ms-1" title="Terlambat"></i>
                    <?php endif; ?>
                </span>
        </div>
        <?php endif; ?>
        
        <div class="row g-3 mt-2">
            <div class="col-md-3">
                <strong>Status:</strong>
                <?php 
                $canUpdateStatus = false; $allowedStatuses = [];
                $curUser = $currentUser ?? null;
                if ($curUser && $curUser['role'] === 'developer' && $bug['assigned_to'] == $curUser['id']) {
                    $canUpdateStatus = true;
                    $allowedStatuses = ['in_progress', 'resolved'];
                } elseif ($curUser && $curUser['role'] === 'qa_tester') {
                    $canUpdateStatus = true; $allowedStatuses = ['closed'];
                } elseif ($curUser && in_array($curUser['role'], ['project_manager', 'admin', 'super_admin'])) {
                    $canUpdateStatus = true;
                    $allowedStatuses = ['new', 'assigned', 'in_progress', 'resolved', 'closed'];
                }
                $curStatus = $bug['status'];
                ?>
                <?php if($canUpdateStatus): ?>
                    <?php if($curStatus === 'assigned'): ?>
                        <form id="startFixForm" method="POST" action="index.php?url=bugs/update-status/<?php echo $bug['id']; ?>" class="d-inline">
                            <input type="hidden" name="status" value="in_progress">
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#confirmStartFixModal">Mulai Betulkan Bug</button>
                        </form>
                    <?php elseif($curStatus === 'in_progress'): ?>
                        <form id="finishFixForm" method="POST" action="index.php?url=bugs/update-status/<?php echo $bug['id']; ?>" class="d-inline">
                            <input type="hidden" name="status" value="resolved">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#confirmFinishFixModal">Selesaikan Perbaikan</button>
                        </form>
                    <?php else: ?>
                        <span class="badge bg-secondary"><?php echo htmlspecialchars($curStatus); ?></span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="badge bg-secondary"><?php echo htmlspecialchars($curStatus); ?></span>
                <?php endif; ?>
                <?php if($curStatus === 'resolved' && !empty($bug['resolved_by_name'])): ?>
                  <div class="mt-1"><span class="text-muted small">Diselesaikan oleh: <b><?php echo htmlspecialchars($bug['resolved_by_name']); ?></b></span></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Comments Section -->
<div class="card mt-3">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-muted">
            <i class="fas fa-comments me-2"></i>
            Komentar
        </h5>
        <span class="badge bg-primary"><?php echo count($comments ?? []); ?></span>
    </div>
    <div class="card-body">
        <?php if (empty($comments)): ?>
            <div class="text-center py-3">
                <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0">Belum ada komentar</p>
            </div>
        <?php else: ?>
            <?php
            // Build a nested comment tree by parent_comment_id
            $byParent = [];
            foreach (($comments ?? []) as $c) {
                $parent = $c['parent_comment_id'] ?? null;
                $byParent[$parent][] = $c;
            }
            
            $renderComments = function($parentId = null, $level = 0) use (&$renderComments, $byParent, $currentUser, $bug, $attachments) {
                if (empty($byParent[$parentId])) return;
                foreach ($byParent[$parentId] as $comment) {
                    // Limit visual nesting to 1 level only so deep threads don't keep shifting right
                    $indent = max(0, min($level, 1)) * 16;
            ?>
            <div class="border-bottom pb-3 mb-3" style="margin-left: <?php echo $indent; ?>px; <?php echo ($level > 0 ? 'border-left: 3px solid rgba(255,255,255,0.1); padding-left: 10px;' : ''); ?>">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center">
                        <?php 
                        // Build profile image path (support profiles/xxx and filename only)
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
                                <img src="<?php echo $imgPath; ?>" alt="avatar" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                            <?php else: ?>
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width:36px;height:36px;">
                                    <?php echo strtoupper(substr($comment['full_name'] ?? $comment['username'] ?? 'U', 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <strong>
                                <?php 
                                $displayName = $comment['full_name'] ?: ($comment['username'] ?? 'Unknown');
                                echo htmlspecialchars($displayName);
                                ?>
                            </strong>
                            <small class="text-muted ms-2"><?php echo date('M d, Y H:i', strtotime($comment['created_at'])); ?></small>
                        </div>
                    </div>
                </div>
                <?php if (!empty($comment['parent_comment_id'])): ?>
                <div class="mt-2 small text-muted" style="border-left:3px solid rgba(255,255,255,0.2); padding-left:8px;">
                    Membalas <strong><?php echo htmlspecialchars($comment['parent_user_name'] ?? ''); ?></strong>:
                    <em><?php echo htmlspecialchars(mb_strimwidth(strip_tags($comment['parent_comment'] ?? ''), 0, 80, '...')); ?></em>
                </div>
                <?php endif; ?>
                <div class="mt-2" id="comment-content-<?php echo (int)$comment['id']; ?>">
                    <?php if ($comment['is_deleted'] == 1): ?>
                        <div class="deleted-comment text-muted fst-italic">
                            <i class="fas fa-trash me-1"></i>Komentar ini telah dihapus
                            <?php if (!empty($comment['deleted_at'])): ?>
                                <small class="d-block text-muted mt-1">
                                    Dihapus pada: <?php echo date('M d, Y H:i', strtotime($comment['deleted_at'])); ?>
                                    <?php if (!empty($comment['deleted_by_name'])): ?>
                                        oleh <strong><?php echo htmlspecialchars($comment['deleted_by_name']); ?></strong>
                                    <?php endif; ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                        <?php if ($comment['is_edited'] == 1 && !empty($comment['edited_at'])): ?>
                            <small class="d-block text-muted mt-1" style="font-style: italic;">
                                <i class="fas fa-edit me-1"></i>Diedit pada <?php echo date('M d, Y H:i', strtotime($comment['edited_at'])); ?>
                            </small>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php 
                // Get attachments directly associated with this comment via comment_id
                // Fallback to time heuristic for old attachments without comment_id
                $related = [];
                $commentTime = strtotime($comment['created_at']);
                $commentUserId = $comment['user_id'] ?? null;
                
                foreach (($attachments ?? []) as $att) {
                    // Primary: Check if attachment has comment_id field and matches this comment
                    if (isset($att['comment_id']) && $att['comment_id'] == $comment['id']) {
                        $related[] = $att;
                    }
                    // Fallback: For old attachments without comment_id, use time heuristic
                    elseif (!isset($att['comment_id']) || $att['comment_id'] === null) {
                        $attTime = strtotime($att['uploaded_at'] ?? ($att['created_at'] ?? ''));
                        if ($attTime && $commentTime && isset($att['uploaded_by']) && $att['uploaded_by'] == $commentUserId) {
                            if (abs($attTime - $commentTime) <= 1) { // within 1 second
                                $related[] = $att;
                            }
                        }
                    }
                }
                if (!empty($related)):
                ?>
                <div class="mt-2">
                    <div class="small text-muted mb-1"><i class="fas fa-image me-1"></i>Attachment(s) in this comment</div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($related as $att): ?>
                            <?php 
                            $nameOrPath = (string)($att['filename'] ?? $att['original_name'] ?? $att['file_path'] ?? '');
                            $isImg = preg_match('/\.(png|jpe?g|gif|webp)$/i', $nameOrPath) === 1;
                            $path = $att['file_path'] ?? '';
                            ?>
                            <a href="<?php echo $path; ?>" target="_blank" class="text-decoration-none">
                                <?php if ($isImg): ?>
                                    <img src="<?php echo $path; ?>" alt="attachment" style="width:72px;height:72px;object-fit:cover;border-radius:4px;border:1px solid rgba(255,255,255,0.1);">
                                <?php else: ?>
                                    <span class="badge bg-secondary text-wrap file-badge"><?php echo htmlspecialchars((string)($att['original_name'] ?? $att['filename'] ?? 'Attachment')); ?></span>
                                <?php endif; ?>
                            </a>
            <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php 
                $canReply = in_array($currentUser['role'], ['super_admin','admin','project_manager','qa_tester']) || ($currentUser['role'] === 'developer' && $bug['assigned_to'] == $currentUser['id']);
                $canEdit = ($comment['user_id'] == $currentUser['id']) && $comment['is_deleted'] != 1; // User can edit their own comments
                $canDelete = in_array($currentUser['role'], ['super_admin', 'project_manager']) && $comment['is_deleted'] != 1;
                
                if ($canReply || $canEdit): ?>
                <div class="mt-2">
                    <?php if ($canReply): ?>
                    <a href="#" class="small text-decoration-none" onclick="toggleReplyForm(<?php echo (int)$comment['id']; ?>); return false;">
                        <i class="fas fa-reply me-1"></i>Balas
                    </a>
                    <?php endif; ?>
                    <?php if ($canEdit): ?>
                    <a href="#" class="small text-decoration-none ms-3" onclick="editComment(<?php echo (int)$comment['id']; ?>); return false;">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <?php endif; ?>
                    <?php if ($canDelete): ?>
                    <a href="#" class="small text-decoration-none text-danger ms-3" onclick="deleteComment(<?php echo (int)$comment['id']; ?>); return false;">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </a>
                    <?php endif; ?>
                    <div id="reply-form-<?php echo (int)$comment['id']; ?>" class="mt-2 d-none">
                        <form method="POST" action="index.php?url=bugs/comment/<?php echo $bug['id']; ?>" enctype="multipart/form-data">
                            <input type="hidden" name="parent_comment_id" value="<?php echo (int)$comment['id']; ?>">
                            <div class="mb-2">
                                <textarea name="comment" rows="2" class="form-control form-control-sm" placeholder="Tulis balasan..."></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <label class="btn btn-outline-secondary btn-sm mb-0">
                                        <i class="fas fa-paperclip me-2"></i>Lampirkan gambar
                                        <input type="file" name="attachments[]" class="d-none" accept="image/*" multiple>
                                    </label>
                                    <small class="reply-files-counter text-muted ms-2"></small>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i>Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php $renderComments($comment['id'], $level + 1); }
            };
            $renderComments(null, 0);
            ?>
        <?php endif; ?>

        <!-- Add Comment Form -->
        <?php $canCommentOrUpload = in_array($currentUser['role'], ['super_admin','admin','project_manager','qa_tester']) || ($currentUser['role'] === 'developer' && $bug['assigned_to'] == $currentUser['id']); ?>
        <?php if ($canCommentOrUpload): ?>
        <form method="POST" action="index.php?url=bugs/comment/<?php echo $bug['id']; ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="comment" class="form-label">Kirim Komentar</label>
                <div class="d-flex align-items-start">
                    <?php 
                    $me = $currentUser ?? null;
                    $mePhoto = $me['profile_photo'] ?? '';
                    $meImg = '';
                    if (!empty($mePhoto)) { $meImg = (strpos($mePhoto, 'profiles/') === 0) ? ('uploads/' . $mePhoto) : ('uploads/profiles/' . $mePhoto); }
                    $meHas = !empty($meImg) && file_exists(ROOT_PATH . '/' . $meImg);
                    ?>
                    <div class="me-3">
                        <?php if ($meHas): ?>
                            <img src="<?php echo $meImg; ?>" alt="me" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                        <?php else: ?>
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width:36px;height:36px;">
                                <?php echo strtoupper(substr($me['full_name'] ?? $me['username'] ?? 'U', 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Tulis komentar Anda di sini..."></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-0" onclick="document.getElementById('bug-comment-attachments').click()">
                        <i class="fas fa-paperclip me-2"></i>Unggah File
                    </button>
                    <input type="file" name="attachments[]" class="d-none" id="bug-comment-attachments" multiple>
                    <small id="bug-attachments-counter" class="text-muted ms-2"></small>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-paper-plane me-2"></i>Kirim Komentar
                </button>
            </div>
        </form>
        <div id="bug-attachments-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
        <?php else: ?>
        <div class="alert alert-warning small">Anda hanya dapat melihat dan berkomentar/mengunggah pada bug yang ditugaskan kepada Anda.</div>
        <?php endif; ?>
        
        <?php if ($currentUser['role'] === 'qa_tester' && $bug['status'] === 'resolved'): ?>
        <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
            <h6 class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Validasi QA Diperlukan</h6>
            <p class="mb-2 small">Bug ini telah ditandai terselesaikan. Silakan uji dan validasi perbaikannya.</p>
            <div class="d-flex gap-2">
                <form method="POST" action="index.php?url=bugs/update-status/<?php echo $bug['id']; ?>" class="d-inline">
                    <input type="hidden" name="status" value="closed">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check me-1"></i>Konfirmasi Perbaikan
                    </button>
                </form>
                <button class="btn btn-outline-danger btn-sm" onclick="showReopenModal()">
                    <i class="fas fa-undo me-1"></i>Buka Kembali Bug
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <h6 class="text-muted mb-3">Lampiran</h6>
        <div class="d-flex flex-wrap gap-3">
            <?php foreach (($attachments ?? []) as $att): ?>
                <?php $isImg = preg_match('/\.(png|jpe?g|gif|webp)$/i', (string)($att['file_name'] ?? $att['file_path'] ?? '')) === 1; ?>
                <a href="<?php echo $att['file_path']; ?>" target="_blank" class="text-decoration-none">
                    <?php if ($isImg): ?>
                        <img src="<?php echo $att['file_path']; ?>" style="width:120px;height:90px;object-fit:cover;border-radius:4px;border:1px solid rgba(255,255,255,0.1);">
                    <?php else: ?>
                        <span class="badge bg-secondary"><?php echo htmlspecialchars((string)($att['file_name'] ?? 'Lampiran')); ?></span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Reopen Bug Modal -->
<div class="modal fade" id="reopenBugModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buka Kembali Bug</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?url=bugs/reopen/<?php echo $bug['id']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan membuka kembali</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Jelaskan kenapa bug ini perlu dibuka kembali..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Buka Kembali Bug</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php /* ------ MODAL KONFIRMASI PERUBAHAN STATUS BUG ------ */ ?>
<div class="modal fade" id="confirmStartFixModal" tabindex="-1" aria-labelledby="confirmStartFixModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmStartFixModalLabel"><i class="fas fa-tools text-warning me-2"></i>Mulai Betulkan Bug</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin akan memulai perbaikan pada bug ini?
        <br><small class="text-muted">Status bug akan berubah menjadi <b>Sedang Dikerjakan</b>.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-warning" id="confirmStartFixBtn">Ya, Mulai</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="confirmFinishFixModal" tabindex="-1" aria-labelledby="confirmFinishFixModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmFinishFixModalLabel"><i class="fas fa-check-circle text-success me-2"></i>Selesaikan Perbaikan Bug</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin sudah selesai memperbaiki bug ini?
        <br><small class="text-muted">Status bug akan berubah menjadi <b>Terselesaikan</b>.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="confirmFinishFixBtn">Ya, Selesai</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var startBtn = document.getElementById('confirmStartFixBtn');
  if (startBtn) {
    startBtn.onclick = function() {
      document.getElementById('startFixForm').submit();
    };
  }
  var finishBtn = document.getElementById('confirmFinishFixBtn');
  if (finishBtn) {
    finishBtn.onclick = function() {
      document.getElementById('finishFixForm').submit();
    };
  }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('bug-comment-attachments');
    if (!input) return;
    const counter = document.getElementById('bug-attachments-counter');
    const preview = document.getElementById('bug-attachments-preview');
    
    // Ensure the input is properly set up
    input.style.display = 'none';
    input.style.visibility = 'hidden';
    
    input.addEventListener('change', function() {
        const files = Array.from(input.files || []);
        if (counter) counter.textContent = files.length ? `${files.length} file selected` : '';
        if (!preview) return;
        preview.innerHTML = '';
        files.forEach(file => {
            if (file.type && file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.className = 'thumb me-2 mb-2';
                img.alt = file.name;
                img.src = URL.createObjectURL(file);
                preview.appendChild(img);
            } else {
                const badge = document.createElement('span');
                badge.className = 'badge bg-secondary text-wrap file-badge me-2 mb-2';
                badge.textContent = file.name;
                preview.appendChild(badge);
            }
        });
    });
    
    // Add click event to label to trigger file input
    const label = input.closest('label');
    if (label) {
        label.addEventListener('click', function(e) {
            e.preventDefault();
            input.click();
        });
    }
    
    // Handle reply form attachments
    const replyInputs = document.querySelectorAll('input[name="attachments[]"]');
    replyInputs.forEach(input => {
        if (input.id === 'bug-comment-attachments') return; // Skip main comment input
        
        input.addEventListener('change', function() {
            const files = Array.from(input.files || []);
            const form = input.closest('form');
            if (!form) return;
            
            // Update file counter
            const counter = form.querySelector('.reply-files-counter');
            if (counter) {
                if (files.length > 0) {
                    counter.textContent = `${files.length} file(s) selected`;
                    counter.style.color = '#28a745'; // Green color to indicate files selected
                } else {
                    counter.textContent = '';
                }
            }
            
            // Create or update preview container for this reply form
            let previewContainer = form.querySelector('.reply-attachments-preview');
            if (!previewContainer) {
                previewContainer = document.createElement('div');
                previewContainer.className = 'reply-attachments-preview mt-2 d-flex flex-wrap gap-2';
                form.appendChild(previewContainer);
            }
            
            previewContainer.innerHTML = '';
            if (files.length > 0) {
                // Add a header to show what's attached with clear all button
                const header = document.createElement('div');
                header.className = 'w-100 mb-2 d-flex justify-content-between align-items-center';
                header.innerHTML = `
                    <small class="text-success"><i class="fas fa-check-circle me-1"></i>Attached files:</small>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAttachments(this)" title="Remove all files">
                        <i class="fas fa-times me-1"></i>Clear All
                    </button>
                `;
                previewContainer.appendChild(header);
                
                files.forEach((file, index) => {
                    const fileContainer = document.createElement('div');
                    fileContainer.className = 'position-relative d-inline-block me-2 mb-2';
                    
                    if (file.type && file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.className = 'thumb';
                        img.alt = file.name;
                        img.src = URL.createObjectURL(file);
                        img.title = file.name;
                        fileContainer.appendChild(img);
                    } else {
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-secondary text-wrap file-badge';
                        badge.textContent = file.name;
                        fileContainer.appendChild(badge);
                    }
                    
                    // Add remove button for individual file
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle';
                    removeBtn.style.width = '20px';
                    removeBtn.style.height = '20px';
                    removeBtn.style.fontSize = '10px';
                    removeBtn.style.padding = '0';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.title = 'Remove this file';
                    removeBtn.onclick = function() {
                        removeFile(input, index);
                    };
                    fileContainer.appendChild(removeBtn);
                    
                    previewContainer.appendChild(fileContainer);
                });
            }
        });
    });
});

function showReopenModal() {
    new bootstrap.Modal(document.getElementById('reopenBugModal')).show();
}

function toggleReplyForm(id) {
    var el = document.getElementById('reply-form-' + id);
    if (!el) return;
    if (el.classList.contains('d-none')) {
        el.classList.remove('d-none');
    } else {
        el.classList.add('d-none');
    }
}

function removeFile(input, index) {
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    // Remove the file at the specified index
    files.splice(index, 1);
    
    // Add remaining files to DataTransfer
    files.forEach(file => dt.items.add(file));
    
    // Update the input files
    input.files = dt.files;
    
    // Trigger change event to update UI
    input.dispatchEvent(new Event('change'));
}

function clearAttachments(button) {
    const form = button.closest('form');
    const input = form.querySelector('input[type="file"]');
    const counter = form.querySelector('.reply-files-counter');
    const previewContainer = form.querySelector('.reply-attachments-preview');
    
    // Clear the file input
    input.value = '';
    
    // Update counter
    if (counter) {
        counter.textContent = '';
    }
    
    // Clear preview
    if (previewContainer) {
        previewContainer.innerHTML = '';
    }
}

// Client-side profanity filter
const badWords = [
    'anjing', 'babi', 'bangsat', 'bajingan', 'kontol', 'memek', 'ngentot', 'bego', 'goblok', 'tolol',
    'fuck', 'shit', 'damn', 'bitch', 'asshole', 'bastard', 'piss', 'crap', 'hell', 'bloody',
    'idiot', 'moron', 'stupid', 'dumb', 'retard', 'retarded', 'gay', 'lesbian', 'homo', 'fag', 'faggot',
    'whore', 'slut', 'prostitute', 'hooker', 'bimbo', 'tramp', 'ho', 'hoe'
];

function containsProfanity(text) {
    const lowerText = text.toLowerCase();
    return badWords.some(word => lowerText.includes(word.toLowerCase()));
}

function validateComment(form) {
    const textarea = form.querySelector('textarea[name="comment"]');
    const submitButton = form.querySelector('button[type="submit"]');
    if (!textarea) return true;
    
    const commentText = textarea.value.trim();
    if (commentText === '') return true;
    // Do not block submission on client-side; rely on server-side validation/flash message
    return true;
}

// Add validation to all comment forms
document.addEventListener('DOMContentLoaded', function() {
    const commentForms = document.querySelectorAll('form[action*="comment"]');
    commentForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateComment(this)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            
            // Add loading state to submit button
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>' + originalText.replace(/<i class="fas[^"]*"><\/i>\s*/, '');
            }
        });
    });
    
    // Reset loading state if there's an error message (from server-side validation)
    const errorMessage = document.querySelector('.alert-danger');
    if (errorMessage) {
        const commentForms = document.querySelectorAll('form[action*="comment"]');
        commentForms.forEach(form => {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = submitButton.innerHTML.replace(/<i class="fas fa-spinner fa-spin[^"]*"><\/i>\s*/, '');
            }
        });
    }
    
    // Clear all file inputs and previews on page load (after successful comment submission)
    // This fixes the bug where attachments from previous comments persist in the form
    const successMessage = document.querySelector('.alert-success');
    if (successMessage) {
        // Clear main comment form file input
        const mainFileInput = document.getElementById('bug-comment-attachments');
        if (mainFileInput) {
            mainFileInput.value = '';
            const counter = document.getElementById('bug-attachments-counter');
            const preview = document.getElementById('bug-attachments-preview');
            if (counter) counter.textContent = '';
            if (preview) preview.innerHTML = '';
        }
        
        // Clear all reply form file inputs
        const replyInputs = document.querySelectorAll('input[name="attachments[]"]');
        replyInputs.forEach(input => {
            if (input.id !== 'bug-comment-attachments') {
                input.value = '';
                const form = input.closest('form');
                if (form) {
                    const counter = form.querySelector('.reply-files-counter');
                    const previewContainer = form.querySelector('.reply-attachments-preview');
                    if (counter) counter.textContent = '';
                    if (previewContainer) previewContainer.innerHTML = '';
                }
            }
        });
        
        // Clear main comment textarea
        const mainTextarea = document.getElementById('bug-comment');
        if (mainTextarea) {
            mainTextarea.value = '';
        }
    }
});
</script>

<style>
#bug-attachments-preview .thumb {
    width: 72px; height: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);
}
#bug-attachments-preview .file-badge { max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.reply-attachments-preview .thumb {
    width: 72px; height: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);
}
.reply-attachments-preview .file-badge { max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.deleted-comment {
    background-color: rgba(220, 53, 69, 0.1);
    border-left: 3px solid #dc3545;
    padding: 8px 12px;
    border-radius: 4px;
    margin: 8px 0;
}
/* Ensure upload button is clickable */
label.btn {
    cursor: pointer !important;
    pointer-events: auto !important;
}
label.btn input[type="file"] {
    position: absolute;
    left: -9999px;
    opacity: 0;
}
</style>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<!-- Modal: Konfirmasi Hapus Bug -->
<div class="modal fade" id="deleteBugModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="index.php?url=bugs/delete/<?php echo $bug['id']; ?>" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Bug</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="display-6 text-danger mb-2"><i class="fas fa-trash"></i></div>
        <p class="mb-2">Apakah Anda yakin ingin menghapus bug ini?</p>
        <div class="text-muted">Bug: <strong><?php echo htmlspecialchars($bug['title']); ?></strong></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-1"></i>Ya, Hapus Bug</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Edit Comment -->
<div class="modal fade" id="editCommentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editCommentForm" method="POST" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Komentar</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="edit-comment-text" class="form-label">Komentar</label>
          <textarea class="form-control" id="edit-comment-text" name="comment" rows="4" required></textarea>
        </div>
        <?php 
        // Show original comment to admin and project manager
        $canViewHistory = in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager']);
        if ($canViewHistory):
        ?>
        <div class="alert alert-info" id="edit-history-alert" style="display: none;">
          <h6 class="alert-heading"><i class="fas fa-history me-2"></i>Riwayat Edit:</h6>
          <hr>
          <div class="mb-2">
            <strong>Komentar Asli:</strong>
            <div id="edit-original-comment" class="p-2 bg-light rounded"></div>
          </div>
          <div class="mb-0">
            <strong>Diedit pada:</strong>
            <span id="edit-timestamp"></span>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Konfirmasi Hapus Komentar -->
<div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteCommentModalLabel">
          <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Komentar
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3 p-md-4">
        <div class="text-center mb-3">
          <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
          <h6>Apakah Anda yakin ingin menghapus komentar ini?</h6>
          <p class="text-muted mb-3">Komentar: <strong id="commentToDelete"></strong></p>
        </div>
      </div>
      <div class="modal-footer p-3 p-md-4">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Batal
          </button>
          <button type="button" class="btn btn-danger" id="confirmDeleteCommentBtn">
            <i class="fas fa-trash me-1"></i>Ya, Hapus Komentar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Get current user and admin status
const currentUser = <?php echo json_encode($currentUser); ?>;
const currentComments = <?php echo json_encode($comments ?? []); ?>;
const canViewHistory = <?php echo json_encode(in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])); ?>;

// Store comment data
let editingCommentId = null;
let commentData = {};

function editComment(commentId) {
    editingCommentId = commentId;
    
    // Find the comment data
    const comment = currentComments.find(c => c.id == commentId);
    if (!comment) {
        alert('Komentar tidak ditemukan');
        return;
    }
    
    commentData = comment;
    
    // Populate the modal
    document.getElementById('edit-comment-text').value = comment.comment;
    
    // Show edit history if user is admin/project_manager
    if (canViewHistory && comment.is_edited == 1 && comment.original_comment) {
        document.getElementById('edit-original-comment').textContent = comment.original_comment;
        document.getElementById('edit-timestamp').textContent = new Date(comment.edited_at).toLocaleString('id-ID');
        document.getElementById('edit-history-alert').style.display = 'block';
    } else {
        document.getElementById('edit-history-alert').style.display = 'none';
    }
    
    // Set form action
    document.getElementById('editCommentForm').action = `index.php?url=bugs/edit-comment/<?php echo $bug['id']; ?>/${commentId}`;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editCommentModal'));
    modal.show();
}

let commentIdToDelete = null;

function deleteComment(commentId) {
    commentIdToDelete = commentId;
    
    // Find the comment to display in modal
    const comment = currentComments.find(c => c.id == commentId);
    if (comment) {
        // Truncate long comments for display
        const commentText = comment.comment.length > 100 
            ? comment.comment.substring(0, 100) + '...' 
            : comment.comment;
        document.getElementById('commentToDelete').textContent = commentText;
    } else {
        document.getElementById('commentToDelete').textContent = '';
    }
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('deleteCommentModal'));
    modal.show();
}

// Handle confirm delete button click
document.addEventListener('DOMContentLoaded', function() {
    const confirmDeleteBtn = document.getElementById('confirmDeleteCommentBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            if (commentIdToDelete === null) return;
            
            // Create a form to submit the delete request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `index.php?url=bugs/delete-comment/<?php echo $bug['id']; ?>/${commentIdToDelete}`;
            
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


