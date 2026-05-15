<?php
/**
 * SIAF AUTOPARTS - Visitor Tracking Test
 * This page demonstrates the visitor tracking functionality
 */

require_once 'includes/functions.php';
require_once 'includes/header.php';

$stats = getVisitorStats();

// Check if visitors table exists
$db = getDB();
$tableExists = $db->query("SHOW TABLES LIKE 'visitors'")->num_rows > 0;
?>

<div class="container" style="padding: 50px 20px;">
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header" style="text-align: center;">
            <h1><i class="fas fa-chart-line"></i> Visitor Tracking System</h1>
            <p>Track website visitors without requiring login</p>
        </div>
        <div class="card-body">
            <?php if (!$tableExists): ?>
            <div class="alert alert-warning" style="background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Setup Required:</strong>
                <p>The visitor tracking table hasn't been created yet. <a href="create_visitors_table.php" target="_blank" style="color: #856404; text-decoration: underline;">Click here to create the visitors table</a> and start tracking visitors.</p>
            </div>
            <?php endif; ?>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h4><?php echo number_format($stats['today']); ?></h4>
                        <p>Visitors Today</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h4><?php echo number_format($stats['month']); ?></h4>
                        <p>This Month</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="stat-content">
                        <h4><?php echo number_format($stats['total']); ?></h4>
                        <p>Total Visitors</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                        <h4><?php echo number_format($stats['unique_today']); ?></h4>
                        <p>Unique IPs Today</p>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3>How It Works:</h3>
                <ul style="line-height: 1.8;">
                    <li><strong>Automatic Tracking:</strong> Every page visit is automatically recorded</li>
                    <li><strong>Session-Based:</strong> Same user visiting multiple pages in one session counts as one visitor</li>
                    <li><strong>Daily Reset:</strong> Session tracking resets daily for accurate daily counts</li>
                    <li><strong>IP Tracking:</strong> Also tracks unique IP addresses for additional metrics</li>
                    <li><strong>No Login Required:</strong> Works for all visitors without authentication</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="admin/visitor_stats.php" class="btn" style="background: var(--primary); color: white; padding: 12px 24px; border-radius: 6px; display: inline-block;">
                    <i class="fas fa-chart-bar"></i> View Detailed Stats (Admin)
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: transform 0.2s;
    text-align: center;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    margin: 0 auto;
}

.stat-content h4 {
    font-size: 28px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 5px;
}

.stat-content p {
    color: var(--gray);
    font-size: 14px;
    margin: 0;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: var(--primary);
    color: white;
    padding: 20px;
}

.card-body {
    padding: 30px;
}

.btn {
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
</style>

<?php require_once 'includes/footer.php'; ?>