    <?php
    // Example of how to display comments with new features
    require_once 'comment.php';

    // Get current user (you should get this from your session)
    $currentUser = $_SESSION['user'] ?? null;

    // Get comments from database (example query)
    $db = Database::getInstance();
    $comments = $db->query("SELECT * FROM bug_comments WHERE bug_id = ? ORDER BY created_at ASC", [$bugId])->fetchAll();
    ?>

    <div class="comments-section">
        <h4>Komentar</h4>
        
        <?php if (empty($comments)): ?>
            <p class="text-muted">Belum ada komentar.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item" id="comment-<?= $comment['id'] ?>">
                    <div class="comment-meta">
                        <span class="author"><?= htmlspecialchars($comment['author_name']) ?></span>
                        <span class="timestamp"><?= date('d M Y H:i', strtotime($comment['created_at'])) ?></span>
                    </div>
                    
                    <div class="comment-content">
                        <?= displayComment($comment) ?>
                    </div>
                    
                    <div class="comment-actions">
                        <?= getCommentActions($comment, $currentUser) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Include required scripts and styles -->
    <link rel="stylesheet" href="/app/views/layouts/comment_styles.css">
    <script src="/app/views/layouts/comment_actions.js"></script>
