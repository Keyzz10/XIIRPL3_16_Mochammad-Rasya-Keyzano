-- Add comment_id column to task_attachments table
-- This allows direct association between attachments and comments
ALTER TABLE task_attachments 
ADD COLUMN comment_id INT NULL AFTER task_id,
ADD KEY idx_comment_id (comment_id);

-- Add comment_id column to bug_attachments table if it exists
ALTER TABLE bug_attachments 
ADD COLUMN comment_id INT NULL AFTER bug_id,
ADD KEY idx_comment_id (comment_id);
