<?php
/**
 * SIAF AUTOPARTS - Create Visitors Table Script
 * Run this once to create the visitors table for tracking
 */

require_once 'config/database.php';

$db = getDB();

// Create visitor tracking table
$sql = "CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    session_id VARCHAR(255),
    page_url VARCHAR(500),
    visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip_date (ip_address, visit_date),
    INDEX idx_session (session_id)
) ENGINE=InnoDB";

if ($db->query($sql) === TRUE) {
    echo "<h2 style='color:green;'>Visitors Table Created Successfully!</h2>";
    echo "<p>The visitors table has been created in the database.</p>";
    echo "<p>You can now track visitor statistics on your website.</p>";
    echo "<hr><a href='admin/visitor_stats.php'>View Visitor Statistics</a> | <a href='index.php'>Go to Website</a>";
} else {
    echo "<h2 style='color:red;'>Error Creating Table</h2>";
    echo "<p>Error: " . $db->error . "</p>";
}
?>