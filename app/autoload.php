<?php
/**
 * FlowTask Autoloader
 */

spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    
    // Possible directories to look for classes
    $directories = [
        ROOT_PATH . '/app/models/',
        ROOT_PATH . '/app/controllers/',
        ROOT_PATH . '/app/middleware/',
        ROOT_PATH . '/app/helpers/',
        ROOT_PATH . '/config/',
        ROOT_PATH . '/app/'
    ];
    
    foreach ($directories as $directory) {
        $fullPath = $directory . $file;
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return;
        }
        
        // Try without subdirectory structure
        $simplePath = $directory . basename($file);
        if (file_exists($simplePath)) {
            require_once $simplePath;
            return;
        }
    }
});

// Include configuration
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/config/Database.php';
?>