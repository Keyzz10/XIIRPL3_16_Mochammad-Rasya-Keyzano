-- Update tasks table to add new fields
ALTER TABLE tasks 
ADD COLUMN IF NOT EXISTS reporter_id INT NULL AFTER created_by,
ADD COLUMN IF NOT EXISTS task_type ENUM('feature', 'bug', 'improvement') DEFAULT 'feature' AFTER priority,
ADD COLUMN IF NOT EXISTS tags VARCHAR(500) NULL AFTER task_type,
ADD COLUMN IF NOT EXISTS visibility ENUM('project', 'assigned_only') DEFAULT 'project' AFTER parent_task_id,
ADD COLUMN IF NOT EXISTS verification_notes TEXT NULL AFTER estimated_hours,
ADD COLUMN IF NOT EXISTS verified_by INT NULL AFTER verification_notes,
ADD COLUMN IF NOT EXISTS verified_at DATETIME NULL AFTER verified_by;

-- Create task_attachments table
CREATE TABLE IF NOT EXISTS task_attachments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    task_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT NOT NULL,
    file_type VARCHAR(100) NOT NULL,
    uploaded_by INT NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Create task_comments table
CREATE TABLE IF NOT EXISTS task_comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    task_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Add foreign key constraints after columns are created
ALTER TABLE tasks 
ADD CONSTRAINT IF NOT EXISTS fk_tasks_reporter_id FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE SET NULL,
ADD CONSTRAINT IF NOT EXISTS fk_tasks_parent_task_id FOREIGN KEY (parent_task_id) REFERENCES tasks(id) ON DELETE CASCADE,
ADD CONSTRAINT IF NOT EXISTS fk_tasks_verified_by FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL;

-- Update existing tasks to set reporter_id = created_by
UPDATE tasks SET reporter_id = created_by WHERE reporter_id IS NULL;
