-- Add columns for comment edit history tracking
-- This will store the original comment text before editing
-- Only visible to admin and project_manager

-- For bug_comments table
ALTER TABLE bug_comments 
ADD COLUMN original_comment TEXT NULL AFTER comment;

ALTER TABLE bug_comments
ADD COLUMN edited_by INT NULL AFTER user_id;

ALTER TABLE bug_comments
ADD INDEX idx_bug_comment_edited_by (edited_by);

ALTER TABLE bug_comments
ADD CONSTRAINT fk_bug_comment_edited_by 
FOREIGN KEY (edited_by) REFERENCES users(id) ON DELETE SET NULL;

-- For task_comments table  
ALTER TABLE task_comments
ADD COLUMN original_comment TEXT NULL AFTER comment;

ALTER TABLE task_comments
ADD COLUMN edited_by INT NULL AFTER user_id;

ALTER TABLE task_comments
ADD INDEX idx_task_comment_edited_by (edited_by);

ALTER TABLE task_comments
ADD CONSTRAINT fk_task_comment_edited_by 
FOREIGN KEY (edited_by) REFERENCES users(id) ON DELETE SET NULL;
