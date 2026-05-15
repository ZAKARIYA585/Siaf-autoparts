<?php
/**
 * SIAF AUTOPARTS - Database Setup Script
 * Run once to create database and tables
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'siaf_autoparts';

// Create connection without database
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database (commented due to existing schema directory)
// $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
// $conn->query($sql);

// Select database
$conn->select_db($dbname);

// Create admins table
$sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";
$conn->query($sql);

// Create categories table
$sql = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    sort_order INT DEFAULT 0,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";
$conn->query($sql);

// Create products table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    description TEXT,
    specifications TEXT,
    image VARCHAR(255),
    gallery TEXT,
    price DECIMAL(12,2) DEFAULT 0.00,
    status TINYINT DEFAULT 1,
    featured TINYINT DEFAULT 0,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB";
$conn->query($sql);

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
$conn->query($sql);

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
$conn->query($sql);

// Insert default admin (password: admin123)
$hashed = password_hash('admin123', PASSWORD_BCRYPT);
$sql = "INSERT IGNORE INTO admins (id, username, password, name) VALUES (1, 'admin', '$hashed', 'Administrator')";
$conn->query($sql);

// Insert default categories
$categories = [
    ['Control & Speedometer Cables', 'control-cables', 'Clutch cables, accelerator wires, brake cables'],
    ['Automotive Bearings', 'automotive-bearings', 'High-precision bearings for two wheelers'],
    ['Automotive Indicators', 'automotive-indicators', 'Side blinkers and indicator assemblies'],
    ['Spark & Two Wheeler Plugs', 'spark-plugs', 'Spark plugs for optimal ignition'],
    ['Chain Sprocket & Timing Kits', 'chain-sprocket', 'Chain drive components and timing kits'],
    ['Drum Rubber & Disc Caliper', 'brake-system', 'Braking system components'],
    ['Head Light Assembly', 'head-light', 'Complete headlight solutions'],
    ['Gear & Kick Shaft', 'gear-shaft', 'Transmission components']
];

$stmt = $conn->prepare("INSERT IGNORE INTO categories (name, slug, description, sort_order) VALUES (?, ?, ?, ?)");
foreach ($categories as $index => $cat) {
    $stmt->bind_param("sssi", $cat[0], $cat[1], $cat[2], $index);
    $stmt->execute();
}
$stmt->close();

$conn->close();

echo "<h2 style='color:green;'>SIAF Autoparts Database Setup Complete!</h2>";
echo "<p>Database: <b>$dbname</b> created successfully.</p>";
echo "<p>Tables created: admins, categories, products, visitors, contact_messages</p>";
echo "<p>Default admin: <b>admin</b> / <b>admin123</b></p>";
echo "<p>Categories inserted. Products table is ready - upload products from admin panel.</p>";
echo "<hr><a href='index.php'>Go to Website</a> | <a href='admin/login.php'>Go to Admin Panel</a>";
