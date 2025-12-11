-- Add username change tracking to users table
-- Execute this SQL in your MySQL database to add username change tracking

USE flowtask;

-- Add username_last_changed column to users table
ALTER TABLE users ADD COLUMN username_last_changed TIMESTAMP NULL AFTER last_login;

-- Add comment for reference
ALTER TABLE users MODIFY COLUMN username_last_changed TIMESTAMP NULL COMMENT 'Last time username was changed - used for 90-day restriction';