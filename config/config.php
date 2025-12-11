<?php
/**
 * FlowTask Application Configuration
 */

// Application Settings
define('APP_NAME', 'FlowTask');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development'); // development, production

// Base paths
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOADS_PATH', ROOT_PATH . '/uploads');

// URL Configuration
// For file-based navigation (remove http://)
define('BASE_URL', '');
define('ASSETS_URL', BASE_URL . '/assets');
define('UPLOADS_URL', './uploads');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'flowtask');
define('DB_USER', 'root');
define('DB_PASS', '');

// Security
define('JWT_SECRET', 'your-secret-key-here-change-in-production');
define('SESSION_LIFETIME', 86400); // 24 hours
define('PASSWORD_MIN_LENGTH', 8);

// File Upload Settings
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt']);

// Email Configuration (optional)
define('SMTP_HOST', 'localhost');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_FROM_EMAIL', 'noreply@flowtask.com');
define('SMTP_FROM_NAME', 'FlowTask System');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error Reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>