-- Add language preference to users table
-- Execute this SQL in your MySQL database to add language support

USE flowtask;

-- Add language column to users table
ALTER TABLE users ADD COLUMN language ENUM('en', 'id') NOT NULL DEFAULT 'en' AFTER phone;

-- Update existing users to have default English language
UPDATE users SET language = 'en' WHERE language IS NULL;

-- Add comment for reference
ALTER TABLE users MODIFY COLUMN language ENUM('en', 'id') NOT NULL DEFAULT 'en' COMMENT 'User language preference: en=English, id=Indonesian';