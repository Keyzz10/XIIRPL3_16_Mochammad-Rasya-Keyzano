-- Force Indonesian Language for All Users
-- Execute this SQL script to set all users to use Indonesian language

USE flowtask;

-- Update all existing users to use Indonesian language
UPDATE users SET language = 'id' WHERE language = 'en' OR language IS NULL;

-- Update the default value for new users
ALTER TABLE users MODIFY COLUMN language ENUM('en', 'id') NOT NULL DEFAULT 'id' COMMENT 'User language preference: en=English, id=Indonesian';

-- Display confirmation
SELECT 'All users have been set to Indonesian language' as message;
SELECT COUNT(*) as total_users_updated FROM users WHERE language = 'id';
