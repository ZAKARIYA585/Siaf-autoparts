<?php
/**
 * SIAF AUTOPARTS - Create Contact Messages Table Script
 * Run this once to create the contact_messages table
 */

require_once 'config/database.php';

$db = getDB();

// Create contact messages table
$sql = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    product VARCHAR(200),
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";

if ($db->query($sql) === TRUE) {
    echo "<h2 style='color:green;'>Contact Messages Table Created Successfully!</h2>";
    echo "<p>The contact_messages table has been created in the database.</p>";
    echo "<p>You can now receive and manage contact form submissions.</p>";
    echo "<hr><a href='admin/contact_messages.php'>View Contact Messages</a> | <a href='index.php'>Go to Website</a>";
} else {
    echo "<h2 style='color:red;'>Error Creating Table</h2>";
    echo "<p>Error: " . $db->error . "</p>";
}
?>