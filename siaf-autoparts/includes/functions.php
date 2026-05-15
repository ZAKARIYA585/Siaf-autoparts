<?php
/**
 * SIAF AUTOPARTS - Frontend Helper Functions
 */

require_once __DIR__ . '/../config/database.php';

function getCategories() {
    $db = getDB();
    return $db->query("SELECT * FROM categories WHERE status = 1 ORDER BY sort_order");
}

function getFeaturedProducts($limit = 8) {
    $db = getDB();
    $stmt = $db->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.featured = 1 AND p.status = 1 ORDER BY p.created_at DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result();
}

function getAllProducts($limit = 0, $category = 0) {
    $db = getDB();
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.status = 1";
    if ($category) $sql .= " AND p.category_id = " . intval($category);
    $sql .= " ORDER BY p.created_at DESC";
    if ($limit) $sql .= " LIMIT " . intval($limit);
    return $db->query($sql);
}

function getProductBySlug($slug) {
    $db = getDB();
    $slug = sanitize($slug);
    $result = $db->query("SELECT p.*, c.name as category_name, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.slug = '$slug' AND p.status = 1 LIMIT 1");
    return $result->fetch_assoc();
}

function getProductById($id) {
    $db = getDB();
    $id = intval($id);
    $result = $db->query("SELECT p.*, c.name as category_name, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = $id AND p.status = 1 LIMIT 1");
    return $result->fetch_assoc();
}

function getRelatedProducts($category_id, $exclude_id, $limit = 4) {
    $db = getDB();
    $category_id = intval($category_id);
    $exclude_id = intval($exclude_id);
    $limit = intval($limit);
    $stmt = $db->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? AND p.id != ? AND p.status = 1 ORDER BY RAND() LIMIT ?");
    $stmt->bind_param("iii", $category_id, $exclude_id, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

function incrementViews($id) {
    $db = getDB();
    $id = intval($id);
    $db->query("UPDATE products SET views = views + 1 WHERE id = $id");
}

function getPageTitle() {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    $titles = [
        'index' => 'Home',
        'products' => 'Products',
        'product' => 'Product Details',
        'company-profile' => 'Company Profile',
        'contact' => 'Contact Us'
    ];
    return ($titles[$page] ?? 'Page') . ' - SIAF Autoparts';
}

function trackVisitor() {
    $db = getDB();

    // Check if visitors table exists
    $result = $db->query("SHOW TABLES LIKE 'visitors'");
    if ($result->num_rows == 0) {
        return; // Table doesn't exist, skip tracking
    }

    // Get visitor information
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $session_id = session_id();
    $page_url = $_SERVER['REQUEST_URI'] ?? '';

    // Check if this session has already visited this page today
    $today = date('Y-m-d');
    $stmt = $db->prepare("SELECT id FROM visitors WHERE session_id = ? AND DATE(visit_date) = ? AND page_url = ? LIMIT 1");
    $stmt->bind_param("sss", $session_id, $today, $page_url);
    $stmt->execute();
    $result = $stmt->get_result();

    // Only track if this session hasn't visited this page today
    if ($result->num_rows == 0) {
        $stmt = $db->prepare("INSERT INTO visitors (ip_address, user_agent, session_id, page_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ip, $user_agent, $session_id, $page_url);
        $stmt->execute();
        $stmt->close();
    }
}

function getVisitorStats() {
    $db = getDB();

    // Check if visitors table exists
    $result = $db->query("SHOW TABLES LIKE 'visitors'");
    if ($result->num_rows == 0) {
        return [
            'today' => 0,
            'month' => 0,
            'total' => 0,
            'unique_today' => 0
        ];
    }

    $stats = [];

    // Total visitors today
    $today = date('Y-m-d');
    $result = $db->query("SELECT COUNT(DISTINCT session_id) as today_visitors FROM visitors WHERE DATE(visit_date) = '$today'");
    $stats['today'] = $result->fetch_assoc()['today_visitors'];

    // Total visitors this month
    $month = date('Y-m');
    $result = $db->query("SELECT COUNT(DISTINCT session_id) as month_visitors FROM visitors WHERE DATE_FORMAT(visit_date, '%Y-%m') = '$month'");
    $stats['month'] = $result->fetch_assoc()['month_visitors'];

    // Total visitors all time
    $result = $db->query("SELECT COUNT(DISTINCT session_id) as total_visitors FROM visitors");
    $stats['total'] = $result->fetch_assoc()['total_visitors'];

    // Unique visitors today (by IP)
    $result = $db->query("SELECT COUNT(DISTINCT ip_address) as unique_today FROM visitors WHERE DATE(visit_date) = '$today'");
    $stats['unique_today'] = $result->fetch_assoc()['unique_today'];

    return $stats;
}
