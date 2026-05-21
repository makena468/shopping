<?php
// Improved config.php with .env support (fallback)
define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'shopping');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()) {
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Database connection error. Please try again later.");
}

mysqli_set_charset($con, "utf8mb4");

// Development settings (comment out in production)
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
?>