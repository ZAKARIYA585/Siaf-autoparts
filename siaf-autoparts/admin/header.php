<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AAFIYA GENUINE PARTS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary: #e33510;
            --primary-dark: #b52a0d;
            --dark: #000000;
            --sidebar: #000000;
            --light: #f4f6f9;
            --white: #fff;
            --gray: #6c757d;
            --border: #e9ecef;
            --success: #27ae60;
            --danger: #e74c3c;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: #333;
            min-height: 100vh;
        }
        .admin-wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--sidebar);
            color: #fff;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            transition: all 0.3s;
        }
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .sidebar-header i { font-size: 36px; color: var(--primary); }
        .sidebar-header h3 { font-size: 18px; margin-top: 8px; }
        .sidebar-header p { font-size: 12px; color: rgba(255,255,255,0.6); }
        .sidebar-menu { padding: 15px 0; }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
        }
        .menu-item:hover, .menu-item.active {
            background: rgba(230,126,34,0.2);
            color: #fff;
            border-left: 3px solid var(--primary);
        }
        .menu-item i { width: 20px; text-align: center; }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .topbar h2 { font-size: 20px; color: var(--dark); }
        .user-menu { display: flex; align-items: center; gap: 20px; }
        .user-menu span { font-size: 14px; color: var(--gray); }
        .logout-btn {
            background: var(--danger);
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s;
        }
        .logout-btn:hover { background: #c0392b; }
        
        .content { padding: 30px; }
        
        /* Cards */
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .card-title { font-size: 18px; font-weight: 600; color: var(--dark); }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { background: #219a52; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #c0392b; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        
        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { padding: 14px 16px; text-align: left; font-size: 14px; }
        .data-table th { background: var(--light); color: var(--dark); font-weight: 600; }
        .data-table tr { border-bottom: 1px solid var(--border); }
        .data-table tr:hover { background: rgba(230,126,34,0.03); }
        .data-table img { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; }
        .badge {
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        
        /* Form */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230,126,34,0.1);
        }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        
        /* Alert */
        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .stat-icon.orange { background: rgba(230,126,34,0.1); color: var(--primary); }
        .stat-icon.blue { background: rgba(52,152,219,0.1); color: #3498db; }
        .stat-icon.green { background: rgba(39,174,96,0.1); color: var(--success); }
        .stat-icon.red { background: rgba(231,76,60,0.1); color: var(--danger); }
        .stat-info h4 { font-size: 24px; font-weight: 700; color: var(--dark); }
        .stat-info p { font-size: 13px; color: var(--gray); }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../images/logo.png" alt="logo"style="width:70px;height:70px;object-fit:contain;margin-bottom:10px;">
            <h3>AAFIYA GENUINE PARTS</h3>
            <p>Admin Panel</p>
        </div>
        <nav class="sidebar-menu">
            <a href="index.php" class="menu-item <?php echo $page == 'index' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="products.php" class="menu-item <?php echo $page == 'products' || $page == 'product_add' || $page == 'product_edit' ? 'active' : ''; ?>">
                <i class="fas fa-box"></i> Products
            </a>
            <a href="categories.php" class="menu-item <?php echo $page == 'categories' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="visitor_stats.php" class="menu-item <?php echo $page == 'visitor_stats' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Visitor Stats
            </a>
            <a href="contact_messages.php" class="menu-item <?php echo $page == 'contact_messages' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Contact Messages
            </a>
            <a href="../index.php" class="menu-item" target="_blank">
                <i class="fas fa-globe"></i> View Website
            </a>
        </nav>
    </aside>
    <div class="main-content">
        <div class="topbar">
            <h2><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h2>
            <div class="user-menu">
                <span><i class="fas fa-user-circle"></i> <?php echo $_SESSION['admin_name']; ?></span>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        <div class="content">
