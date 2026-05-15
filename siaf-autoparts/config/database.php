<?php
/**
 * SIAF AUTOPARTS - Database Configuration
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'siaf_autoparts');

function getDB() {
    static $db = null;
    if ($db === null) {
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        $db->set_charset("utf8mb4");
    }
    return $db;
}

function sanitize($data) {
    $db = getDB();
    return $db->real_escape_string(trim($data));
}
