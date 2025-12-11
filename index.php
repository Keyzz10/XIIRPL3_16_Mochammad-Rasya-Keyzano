<?php
/**
 * FlowTask Application Entry Point
 */

// Define root path
define('ROOT_PATH', __DIR__);

// Include autoloader
require_once ROOT_PATH . '/app/autoload.php';

// Create uploads directory if it doesn't exist
$uploadsDir = ROOT_PATH . '/uploads';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
    
    // Create subdirectories
    $subDirs = ['profiles', 'tasks', 'bugs', 'documents'];
    foreach ($subDirs as $dir) {
        $dirPath = $uploadsDir . '/' . $dir;
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }
    }
}

// Start the router
new Router();
?>