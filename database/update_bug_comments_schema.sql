-- Update bug_comments table to support nested comments (replies)
-- Add parent_comment_id column to enable comment threading

ALTER TABLE bug_comments 
ADD COLUMN parent_comment_id INT NULL AFTER comment,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at,
ADD FOREIGN KEY (parent_comment_id) REFERENCES bug_comments(id) ON DELETE CASCADE;
