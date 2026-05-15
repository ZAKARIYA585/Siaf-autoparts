<?php
require_once 'header.php';

$stats = getVisitorStats();

// Check if visitors table exists
$db = getDB();
$tableExists = $db->query("SHOW TABLES LIKE 'visitors'")->num_rows > 0;
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-line"></i> Visitor Statistics</h3>
    </div>
    <div class="card-body">
        <?php if (!$tableExists): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Visitors table not found!</strong>
            <p>The visitor tracking table hasn't been created yet. <a href="../create_visitors_table.php" target="_blank">Click here to create it</a>.</p>
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
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list"></i> Recent Visitors</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>Page</th>
                        <th>Visit Date</th>
                        <th>User Agent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $recent = $db->query("SELECT ip_address, page_url, visit_date, user_agent FROM visitors ORDER BY visit_date DESC LIMIT 50");
                    while ($visitor = $recent->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($visitor['ip_address']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['page_url']); ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($visitor['visit_date'])); ?></td>
                        <td><?php echo htmlspecialchars(substr($visitor['user_agent'], 0, 50)) . (strlen($visitor['user_agent']) > 50 ? '...' : ''); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid var(--border);
}

.table th {
    background: var(--light);
    font-weight: 600;
    color: var(--dark);
}

.table tr:hover {
    background: rgba(230, 126, 34, 0.05);
}
</style>

<?php require_once 'footer.php'; ?>