<?php
require_once 'header.php';

$db = getDB();

$categories = $db->query("SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id ORDER BY c.sort_order");

$message = '';
if (isset($_GET['msg'])) {
    $message = 'Operation completed successfully!';
}
?>

<?php if ($message): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $message; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tags"></i> Categories</h3>
    </div>
    <div style="overflow-x:auto;">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $categories->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                <td><?php echo $row['slug']; ?></td>
                <td><?php echo $row['product_count']; ?></td>
                <td>
                    <span class="badge <?php echo $row['status'] ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $row['status'] ? 'Active' : 'Inactive'; ?>
                    </span>
                </td>
                <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once 'footer.php'; ?>
