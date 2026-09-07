<?php
// Load the canonical root config
require_once __DIR__ . '/../../includes/config.php';

// Ensure the connection is available locally
if (isset($GLOBALS['con']) && $GLOBALS['con']) {
    $con = $GLOBALS['con'];
} else {
    // Fallback: create connection directly if root config didn't
    define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
    define('DB_USER', getenv('DB_USER') ?: 'root');
    define('DB_PASS', getenv('DB_PASS') ?: '');
    define('DB_NAME', getenv('DB_NAME') ?: 'shopping');
    
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (!$con) {
        die("Database connection error: " . mysqli_connect_error());
    }
    $GLOBALS['con'] = $con;
}
?>