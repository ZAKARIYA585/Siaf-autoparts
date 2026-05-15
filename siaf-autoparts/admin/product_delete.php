<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);

if ($id) {
    $db = getDB();
    $product = $db->query("SELECT image FROM products WHERE id = $id")->fetch_assoc();
    
    if ($product && $product['image'] && file_exists('../uploads/' . $product['image'])) {
        unlink('../uploads/' . $product['image']);
    }
    
    $db->query("DELETE FROM products WHERE id = $id");
}

header('Location: products.php?msg=deleted');
exit;
