<?php
// Function to display comment
function displayComment($comment) {
    $content = htmlspecialchars($comment['content']);
    return $content;
}

// Function to get comment actions - returns empty string (edit/delete feature removed)
function getCommentActions($comment, $currentUser) {
    return '';
}
?>
