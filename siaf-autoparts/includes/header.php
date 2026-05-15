<?php
require_once __DIR__ . '/functions.php';
trackVisitor();
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getPageTitle(); ?></title>
    <meta name="description" content="SIAF GENUINE PARTS - Manufacturer & Supplier of Quality Two Wheeler Spare Parts. Control Cables, Bearings, Plugs, Chain Sprockets, Disc Calipers & More.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary: #e33510;
            --primary-dark: #b52a0d;
            --secondary: #0d0d0d;
            --dark: #000000;
            --light: #f7f7f7;
            --white: #ffffff;
            --gray: #606060;
            --border: #dadada;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; color: var(--dark); line-height: 1.6; background: var(--light); }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* Top Bar */
        .top-bar {
            background: var(--dark);
            color: rgba(255,255,255,0.8);
            padding: 8px 0;
            font-size: 13px;
        }
        .top-bar .container { display: flex; justify-content: space-between; align-items: center; }
        .top-bar a { color: var(--primary); }
        .top-bar i { margin-right: 5px; color: var(--primary); }

        /* Navbar */
        .navbar {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; height: 70px; }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo-icon {
            width: 42px; height: 42px; background: var(--primary); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--white); font-size: 18px;
        }
        .logo-text { line-height: 1; }
        .logo-main { font-size: 22px; font-weight: 800; color: var(--dark); letter-spacing: 1px; }
        .logo-sub { font-size: 11px; font-weight: 500; color: var(--primary); letter-spacing: 3px; }
        .nav-menu { display: flex; gap: 5px; }
        .nav-link {
            padding: 8px 18px; color: var(--dark); font-weight: 500; font-size: 14px;
            border-radius: 6px; transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active { background: var(--primary); color: var(--white); }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
        .hamburger span { width: 26px; height: 3px; background: var(--dark); border-radius: 3px; transition: all 0.3s; }

        /* Page Banner */
        .page-banner {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            color: var(--white); padding: 50px 0; text-align: center;
        }
        .page-banner h1 { font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .page-banner p { color: rgba(255,255,255,0.7); font-size: 15px; }

        /* Footer */
        .footer { background: var(--dark); color: rgba(255,255,255,0.7); padding: 60px 0 0; }
        .footer-grid { display: grid; grid-template-columns: 1.8fr 1fr 1fr 1.2fr; gap: 40px; }
        .footer-brand .logo-main { color: var(--white); font-size: 20px; }
        .footer-brand p { font-size: 14px; line-height: 1.8; margin-top: 15px; }
        .footer h4 { color: var(--white); font-size: 16px; margin-bottom: 20px; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { font-size: 14px; color: rgba(255,255,255,0.6); transition: all 0.3s; }
        .footer-links a:hover { color: var(--primary); padding-left: 5px; }
        .footer-contact p { font-size: 14px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .footer-contact i { color: var(--primary); width: 16px; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1); padding: 20px 0;
            text-align: center; margin-top: 40px;
        }
        .footer-bottom p { font-size: 13px; color: rgba(255,255,255,0.5); }

        @media (max-width: 768px) {
            .hamburger { display: flex; }
            .nav-menu {
                position: fixed; top: 0; right: -100%; width: 260px; height: 100vh;
                background: var(--white); flex-direction: column; padding: 80px 20px 20px;
                box-shadow: -5px 0 20px rgba(0,0,0,0.1); transition: all 0.3s; gap: 0;
            }
            .nav-menu.active { right: 0; }
            .nav-link { padding: 12px; border-bottom: 1px solid var(--border); border-radius: 0; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; }
            .top-bar .container { flex-direction: column; gap: 5px; text-align: center; }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div><i class="fas fa-phone-alt"></i> <a href="tel:9999999999">9999999999</a> | <i class="fas fa-envelope"></i> aafiya@genuineparts.com</div>
            <div><i class="fas fa-map-marker-alt"></i> Godhra, Gujarat, India</div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <span class="logo-icon"><img src="images/logo.png" alt="Logo"></span>
                <div class="logo-text">
                    <span class="logo-main">AAFIYA</span>
                    <span class="logo-sub">GENUINE PARTS</span>
                </div>
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="products.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">Products</a></li>
                <li><a href="company-profile.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'company-profile.php' ? 'active' : ''; ?>">Company Profile</a></li>
                <li><a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
            </ul>
            <div class="hamburger" id="hamburger">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>
