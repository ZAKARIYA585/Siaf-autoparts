<?php
require_once '../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$db = getDB();

// Handle status updates - BEFORE any output
if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
    $id = intval($_GET['mark_read']);
    $db->query("UPDATE contact_messages SET status = 'read' WHERE id = $id");
    header('Location: contact_messages.php');
    exit;
}

if (isset($_GET['mark_replied']) && is_numeric($_GET['mark_replied'])) {
    $id = intval($_GET['mark_replied']);
    $db->query("UPDATE contact_messages SET status = 'replied' WHERE id = $id");
    header('Location: contact_messages.php');
    exit;
}

// Get filter
$status_filter = $_GET['status'] ?? 'all';
$where = '';
if ($status_filter !== 'all') {
    $where = "WHERE status = '" . $db->real_escape_string($status_filter) . "'";
}

// Get messages
$messages = $db->query("SELECT * FROM contact_messages $where ORDER BY created_at DESC");

// Get counts
$total_messages = $db->query("SELECT COUNT(*) FROM contact_messages")->fetch_row()[0];
$unread_messages = $db->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetch_row()[0];
$read_messages = $db->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'read'")->fetch_row()[0];
$replied_messages = $db->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'replied'")->fetch_row()[0];

// Include header after all logic that needs header() function
require_once 'header.php';
$page = 'contact_messages';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-envelope"></i> Contact Messages</h3>
        <div class="card-actions">
            <a href="?status=all" class="btn btn-sm <?php echo $status_filter == 'all' ? 'btn-primary' : 'btn-outline'; ?>">All (<?php echo $total_messages; ?>)</a>
            <a href="?status=unread" class="btn btn-sm <?php echo $status_filter == 'unread' ? 'btn-primary' : 'btn-outline'; ?>">Unread (<?php echo $unread_messages; ?>)</a>
            <a href="?status=read" class="btn btn-sm <?php echo $status_filter == 'read' ? 'btn-primary' : 'btn-outline'; ?>">Read (<?php echo $read_messages; ?>)</a>
            <a href="?status=replied" class="btn btn-sm <?php echo $status_filter == 'replied' ? 'btn-primary' : 'btn-outline'; ?>">Replied (<?php echo $replied_messages; ?>)</a>
        </div>
    </div>
    <div class="card-body">
        <?php if ($messages->num_rows == 0): ?>
            <div class="empty-state">
                <i class="fas fa-envelope-open"></i>
                <h4>No messages found</h4>
                <p><?php echo $status_filter == 'all' ? 'No contact messages have been received yet.' : 'No messages with this status.'; ?></p>
            </div>
        <?php else: ?>
            <div class="messages-list">
                <?php while ($msg = $messages->fetch_assoc()): ?>
                    <div class="message-item <?php echo $msg['status']; ?>">
                        <div class="message-header">
                            <div class="message-info">
                                <h4><?php echo htmlspecialchars($msg['name']); ?></h4>
                                <div class="message-meta">
                                    <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($msg['email']); ?></span>
                                    <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($msg['phone']); ?></span>
                                    <span><i class="fas fa-calendar"></i> <?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></span>
                                </div>
                            </div>
                            <div class="message-actions">
                                <span class="status-badge status-<?php echo $msg['status']; ?>">
                                    <?php echo ucfirst($msg['status']); ?>
                                </span>
                                <?php if ($msg['status'] == 'unread'): ?>
                                    <a href="?mark_read=<?php echo $msg['id']; ?>&status=<?php echo $status_filter; ?>" class="btn-action" title="Mark as Read">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($msg['status'] != 'replied'): ?>
                                    <a href="?mark_replied=<?php echo $msg['id']; ?>&status=<?php echo $status_filter; ?>" class="btn-action" title="Mark as Replied">
                                        <i class="fas fa-reply"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($msg['product'])): ?>
                            <div class="message-product">
                                <strong>Interested Product:</strong> <?php echo htmlspecialchars($msg['product']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="message-content">
                            <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.card-actions {
    display: flex;
    gap: 10px;
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--dark);
}

.btn-outline:hover {
    background: var(--light);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--gray);
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.messages-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.message-item {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 20px;
    transition: all 0.3s;
}

.message-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.message-item.unread {
    border-left: 4px solid var(--primary);
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.message-info h4 {
    margin: 0 0 8px 0;
    font-size: 18px;
    color: var(--dark);
}

.message-meta {
    display: flex;
    gap: 15px;
    font-size: 13px;
    color: var(--gray);
}

.message-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.message-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-unread {
    background: #fff3cd;
    color: #856404;
}

.status-read {
    background: #d1ecf1;
    color: #0c5460;
}

.status-replied {
    background: #d4edda;
    color: #155724;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--light);
    color: var(--gray);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-action:hover {
    background: var(--primary);
    color: white;
}

.message-product {
    background: var(--light);
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 14px;
}

.message-content {
    line-height: 1.6;
    color: var(--dark);
}

@media (max-width: 768px) {
    .message-header {
        flex-direction: column;
        gap: 10px;
    }

    .message-meta {
        flex-wrap: wrap;
        gap: 10px;
    }
}
</style>

<?php require_once 'footer.php'; ?>