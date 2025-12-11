<?php
require_once 'config/config.php';
require_once 'config/Database.php';

// Get SQL file from command line argument or use default
$sqlFile = $argv[1] ?? 'database/update_task_comments_schema.sql';

// Get database connection
$database = new Database();
$db = $database->connect();

// Read SQL file
if (!file_exists($sqlFile)) {
    echo "Error: SQL file not found: $sqlFile\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);

// Execute SQL
try {
    $db->exec($sql);
    echo "SQL executed successfully: $sqlFile\n";
} catch (Exception $e) {
    echo "Error executing SQL: " . $e->getMessage() . "\n";
}
?>