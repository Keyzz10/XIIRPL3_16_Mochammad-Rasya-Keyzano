-- Add super_admin role to FlowTask Database
-- Execute this SQL script to update the user roles enum to include super_admin

USE flowtask;

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Update the users table to add super_admin to the role enum
-- This will modify the existing ENUM to include super_admin as the highest privilege level
ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'project_manager', 'developer', 'qa_tester', 'client') NOT NULL DEFAULT 'developer';

-- Create the first super_admin user (converting existing admin to super_admin)
-- Find the first admin user and promote them to super_admin
UPDATE users 
SET role = 'super_admin' 
WHERE role = 'admin' 
AND email = 'admin@flowtask.com' 
LIMIT 1;

-- If no admin@flowtask.com exists, create a super_admin user
INSERT INTO users (username, email, password, full_name, role, status, email_verified, created_at)
SELECT 'superadmin', 'superadmin@flowtask.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyJjbYCS2EVElPhKczu6/M/YQ0EQm', 'Super Administrator', 'super_admin', 'active', 1, NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE role = 'super_admin' OR email = 'superadmin@flowtask.com'
);

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Display role hierarchy information
SELECT 'Role Hierarchy Updated Successfully' as message;
SELECT 'super_admin > admin > project_manager > developer > qa_tester > client' as hierarchy;

-- Show current super_admin users
SELECT id, username, email, full_name, role, status, created_at 
FROM users 
WHERE role = 'super_admin';

-- Super Admin Login Credentials:
-- If admin@flowtask.com was promoted: email: admin@flowtask.com, password: admin123
-- If new account created: email: superadmin@flowtask.com, password: admin123