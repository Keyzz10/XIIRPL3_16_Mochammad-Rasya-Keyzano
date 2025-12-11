-- Add columns for comment editing and soft delete functionality
ALTER TABLE task_comments 
ADD COLUMN is_deleted TINYINT(1) DEFAULT 0,
ADD COLUMN deleted_at TIMESTAMP NULL,
ADD COLUMN is_edited TINYINT(1) DEFAULT 0,
ADD COLUMN edited_at TIMESTAMP NULL;