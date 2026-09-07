<?php
// Improved config.php with .env support (fallback)
if (!defined('DB_SERVER')) {
    define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
    define('DB_USER', getenv('DB_USER') ?: 'root');
    define('DB_PASS', getenv('DB_PASS') ?: '');
    define('DB_NAME', getenv('DB_NAME') ?: 'shopping');
}

// Create connection and store in globals if not already present
if (!isset($GLOBALS['con']) || !$GLOBALS['con']) {
    $GLOBALS['con'] = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    
    if (!$GLOBALS['con']) {
        error_log("Database connection failed: " . mysqli_connect_error());
        die("Database connection error. Please try again later.");
    }
    
    mysqli_set_charset($GLOBALS['con'], "utf8mb4");
}

// Create local reference for convenience
$con = $GLOBALS['con'];

// Password hashing and verification functions
if (!function_exists('hashPassword')) {
    function hashPassword($password) {
        if ($password === null || $password === '') {
            return '';
        }

        return password_hash((string) $password, PASSWORD_DEFAULT);
    }
}

if (!function_exists('passwordMatches')) {
    function passwordMatches($storedHash, $inputPassword) {
        if (empty($storedHash) || empty($inputPassword)) {
            return false;
        }

        $storedHash = (string) $storedHash;
        $inputPassword = (string) $inputPassword;

        if (is_string($storedHash) && strpos($storedHash, '$2') === 0) {
            return password_verify($inputPassword, $storedHash);
        }

        if (function_exists('hash_equals')) {
            return hash_equals(md5($inputPassword), $storedHash);
        }

        return md5($inputPassword) === $storedHash;
    }
}

// Development settings (comment out in production)
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if (!function_exists('ensureOrdersTableColumns')) {
    function ensureOrdersTableColumns($conn) {
        if (!$conn) {
            return;
        }

        $result = mysqli_query($conn, 'SHOW COLUMNS FROM orders');
        if (!$result) {
            return;
        }

        $columns = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }
        mysqli_free_result($result);

        $requiredColumns = [
            'orderNumber' => 'VARCHAR(50) NULL DEFAULT NULL',
            'addressId' => 'INT(11) NULL DEFAULT NULL',
            'totalAmount' => 'DECIMAL(10,2) NULL DEFAULT NULL',
            'txnType' => 'VARCHAR(50) NULL DEFAULT NULL',
            'txnNumber' => 'VARCHAR(100) NULL DEFAULT NULL',
        ];

        foreach ($requiredColumns as $column => $definition) {
            if (!in_array($column, $columns, true)) {
                mysqli_query($conn, 'ALTER TABLE orders ADD COLUMN `' . $column . '` ' . $definition);
            }
        }
    }
}

ensureOrdersTableColumns($con);
?>