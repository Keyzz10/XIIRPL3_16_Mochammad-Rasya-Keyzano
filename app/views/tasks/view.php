<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<style>
#attachments-preview .thumb {
    width: 72px; height: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);
}
#attachments-preview .file-badge { max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('comment-attachments');
    if (!input) return;
    const counter = document.getElementById('attachments-counter');
    const preview = document.getElementById('attachments-preview');
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
    
    // Handle reply form attachments
    const replyInputs = document.querySelectorAll('input[name="attachments[]"]');
    replyInputs.forEach(input => {
        if (input.id === 'comment-attachments') return; // Skip main comment input
        
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
</script>

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

<!-- Task View Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-dark"><?php echo htmlspecialchars($task['title']); ?></h1>
        <p class="text-muted mb-0">Detail Tugas</p>
    </div>
    <div class="btn-group">
        <a href="index.php?url=tasks" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Tugas
        </a>
        <?php 
        $canEdit = in_array($currentUser['role'], ['super_admin','admin','project_manager']) || 
                   ($currentUser['role'] === 'developer' && $task['assigned_to'] == $currentUser['id']);
        ?>
        <?php if ($canEdit): ?>
        <a href="index.php?url=tasks/edit/<?php echo $task['id']; ?>" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>Edit Tugas
        </a>
        <?php endif; ?>
        <?php if (in_array($currentUser['role'], ['super_admin', 'admin', 'project_manager'])): ?>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTaskModal">
            <i class="fas fa-trash me-2"></i>Hapus Tugas
        </button>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <!-- Main Task Information -->
    <div class="col-lg-8">
        <!-- Task Details Card -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Tugas
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <?php
                        $statusColors = [
                            'to_do' => 'secondary',
                            'in_progress' => 'primary',
                            'done' => 'success'
                        ];
                        $color = $statusColors[$task['status']] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?php echo $color; ?> ms-2">
                            <?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Prioritas:</strong>
                        <?php
                        $priorityColors = [
                            'low' => 'success',
                            'medium' => 'warning',
                            'high' => 'danger',
                            'critical' => 'dark'
                        ];
                        $color = $priorityColors[$task['priority']] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?php echo $color; ?> ms-2">
                            <?php echo ucfirst($task['priority']); ?>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <div class="mt-2 p-3 bg-light rounded">
                        <?php echo nl2br(htmlspecialchars($task['description'])); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Proyek:</strong>
                        <span class="ms-2"><?php echo htmlspecialchars($task['project_name'] ?? 'Tidak ada proyek'); ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Ditugaskan Ke:</strong>
                        <span class="ms-2">
                            <?php 
                            if (!empty($task['assigned_to_name'])) {
                                echo htmlspecialchars($task['assigned_to_name']);
                                if (!empty($task['assigned_to_role'])) {
                                    echo ' (' . ucfirst(str_replace('_',' ', $task['assigned_to_role'])) . ')';
                                }
                            } else {
                                echo 'Belum ditugaskan';
                            }
                            ?>
                        </span>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Dibuat Oleh:</strong>
                        <span class="ms-2"><?php echo htmlspecialchars($task['created_by_name'] ?? 'Tidak diketahui'); ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Dibuat:</strong>
                        <span class="ms-2"><?php echo date('M d, Y H:i', strtotime($task['created_at'])); ?></span>
                    </div>
                </div>

                <?php if ($task['due_date']): ?>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Batas Waktu:</strong>
                        <?php 
                        $dueDate = new DateTime($task['due_date']);
                        $now = new DateTime();
                        $isOverdue = $dueDate < $now && $task['status'] !== 'done';
                        ?>
                        <span class="ms-2 <?php echo $isOverdue ? 'text-danger' : 'text-muted'; ?>">
                            <?php echo $dueDate->format('M d, Y'); ?>
                            <?php if ($isOverdue): ?>
                                <i class="fas fa-exclamation-triangle ms-1"></i>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Perkiraan Jam:</strong>
                        <span class="ms-2"><?php echo $task['estimated_hours'] ?? 'Belum ditentukan'; ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (isset($task['progress']) && $task['progress'] > 0): ?>
                <div class="mt-3">
                    <strong>Progress:</strong>
                    <div class="progress mt-2" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: <?php echo $task['progress']; ?>%" 
                             aria-valuenow="<?php echo $task['progress']; ?>" 
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <small class="text-muted"><?php echo number_format($task['progress'], 1); ?>% Selesai</small>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card mb-4">
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
                    
                    $renderComments = function($parentId = null, $level = 0) use (&$renderComments, $byParent, $currentUser, $task, $attachments) {
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
                        $canReply = (!( $readOnly ?? false) || $currentUser['role'] !== 'developer') ? true : ($task['assigned_to'] == $currentUser['id']);
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
                                <form method="POST" action="index.php?url=tasks/comment/<?php echo $task['id']; ?>" enctype="multipart/form-data">
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
                <?php $canCommentOrUpload = !($readOnly ?? false) || $currentUser['role'] !== 'developer' ? true : ($task['assigned_to'] == $currentUser['id']); ?>
                <?php if ($canCommentOrUpload): ?>
                <form method="POST" action="index.php?url=tasks/comment/<?php echo $task['id']; ?>" enctype="multipart/form-data">
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
                            <label class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="fas fa-paperclip me-2"></i>Unggah File
                                <input type="file" name="attachments[]" class="d-none" id="comment-attachments" multiple>
                            </label>
                            <small id="attachments-counter" class="text-muted ms-2"></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Komentar
                        </button>
                    </div>
                </form>
                <div id="attachments-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                <?php else: ?>
                <div class="alert alert-warning small">You can view and comment/upload only on tasks assigned to you.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Attachments Section -->
        <?php if (!empty($attachments)): ?>
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-paperclip me-2"></i>
                    Lampiran
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    <?php foreach ($attachments as $attachment): ?>
                    <?php 
                    // Determine if attachment is an image using any available name/path, avoiding nulls
                    $nameOrPath = (string)($attachment['filename'] ?? $attachment['original_name'] ?? $attachment['file_path'] ?? '');
                    $isImage = preg_match('/\.(png|jpe?g|gif|webp)$/i', $nameOrPath) === 1;
                    ?>
                    <div class="border rounded p-2" style="width: 160px;">
                        <a href="<?php echo $attachment['file_path']; ?>" target="_blank" class="text-decoration-none">
                            <?php if ($isImage): ?>
                                <img src="<?php echo $attachment['file_path']; ?>" alt="attachment" style="width:100%;height:110px;object-fit:cover;border-radius:4px;">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-light" style="width:100%;height:110px;border-radius:4px;">
                                    <i class="fas fa-file fa-2x text-secondary"></i>
                                </div>
                            <?php endif; ?>
                            <div class="small mt-2 text-truncate" title="<?php echo htmlspecialchars((string)($attachment['original_name'] ?? $attachment['filename'] ?? 'Lampiran')); ?>">
                                <?php echo htmlspecialchars((string)($attachment['original_name'] ?? $attachment['filename'] ?? 'Lampiran')); ?>
                            </div>
                        </a>
                        <div class="text-muted small">Diunggah <?php echo date('M d, Y H:i', strtotime($attachment['uploaded_at'] ?? ($attachment['created_at'] ?? 'now'))); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?url=tasks/edit/<?php echo $task['id']; ?>" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i>Edit Tugas
                    </a>
                    <?php 
                    $pendingFromNotes = null;
                    if (!empty($task['verification_notes']) && strpos($task['verification_notes'], 'hours_pending:') === 0) {
                        $pendingFromNotes = (float)substr($task['verification_notes'], strlen('hours_pending:'));
                    }
                    if ($pendingFromNotes && in_array($currentUser['role'], ['project_manager','admin','super_admin'])): ?>
                    <form method="POST" action="index.php?url=tasks/approve-estimated/<?php echo $task['id']; ?>" class="d-inline ms-2">
                        <input type="hidden" name="decision" value="approve">
                        <input type="hidden" name="value" value="<?php echo $pendingFromNotes; ?>">
                        <button type="submit" class="btn btn-success">Setujui Jam</button>
                    </form>
                    <form method="POST" action="index.php?url=tasks/approve-estimated/<?php echo $task['id']; ?>" class="d-inline ms-1">
                        <input type="hidden" name="decision" value="reject">
                        <button type="submit" class="btn btn-outline-danger">Tolak</button>
                    </form>
                    <?php endif; ?>
                    <?php if (($task['status'] ?? 'to_do') === 'to_do'): ?>
                    <button class="btn btn-outline-success" onclick="updateStatus('in_progress')">
                        <i class="fas fa-play me-2"></i>Mulai Tugas
                    </button>
                    <?php endif; ?>
                    <?php if (($task['status'] ?? '') === 'in_progress'): ?>
                    <button class="btn btn-outline-warning" onclick="updateStatus('done')">
                        <i class="fas fa-check me-2"></i>Tandai Selesai
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Task Statistics -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Tugas
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <div class="h4 mb-0 text-primary"><?php echo count($comments ?? []); ?></div>
                            <small class="text-muted">Komentar</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h4 mb-0 text-success"><?php echo count($attachments ?? []); ?></div>
                        <small class="text-muted">Lampiran</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub Tasks -->
        <?php if (!empty($subTasks)): ?>
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">
                    <i class="fas fa-tasks me-2"></i>
                    Sub Tugas
                </h5>
            </div>
            <div class="card-body">
                <?php foreach ($subTasks as $subTask): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong><?php echo htmlspecialchars($subTask['title']); ?></strong>
                        <br>
                        <small class="text-muted"><?php echo ucfirst($subTask['status']); ?></small>
                    </div>
                    <a href="index.php?url=tasks/view/<?php echo $subTask['id']; ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateStatus(status) {
    if (confirm('Apakah Anda yakin ingin memperbarui status tugas?')) {
        // Create a form to submit the status update
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?url=tasks/update-status/<?php echo $task['id']; ?>';
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
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
        const mainFileInput = document.getElementById('comment-attachments');
        if (mainFileInput) {
            mainFileInput.value = '';
            const counter = document.getElementById('attachments-counter');
            const preview = document.getElementById('attachments-preview');
            if (counter) counter.textContent = '';
            if (preview) preview.innerHTML = '';
        }
        
        // Clear all reply form file inputs
        const replyInputs = document.querySelectorAll('input[name="attachments[]"]');
        replyInputs.forEach(input => {
            if (input.id !== 'comment-attachments') {
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
        const mainTextarea = document.getElementById('comment');
        if (mainTextarea) {
            mainTextarea.value = '';
        }
    }
});
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<!-- Modal: Konfirmasi Hapus Tugas -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="index.php?url=tasks/delete/<?php echo $task['id']; ?>" class="modal-content">
      <input type="hidden" name="confirm" value="yes">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Tugas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="display-6 text-danger mb-2"><i class="fas fa-trash"></i></div>
        <p class="mb-2">Apakah Anda yakin ingin menghapus tugas ini?</p>
        <div class="text-muted">Tugas: <strong><?php echo htmlspecialchars($task['title']); ?></strong></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-1"></i>Ya, Hapus Tugas</button>
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
    document.getElementById('editCommentForm').action = `index.php?url=tasks/edit-comment/<?php echo $task['id']; ?>/${commentId}`;
    
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
            form.action = `index.php?url=tasks/delete-comment/<?php echo $task['id']; ?>/${commentIdToDelete}`;
            
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


