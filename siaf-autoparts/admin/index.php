<?php
require_once 'header.php';

$db = getDB();

// Stats
$totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetch_row()[0];
$totalCategories = $db->query("SELECT COUNT(*) FROM categories")->fetch_row()[0];
$featuredProducts = $db->query("SELECT COUNT(*) FROM products WHERE featured = 1 AND status = 1")->fetch_row()[0];
$activeProducts = $db->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetch_row()[0];

// Recent products
$recentProducts = $db->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 5");

// Most viewed
$mostViewed = $db->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.views DESC LIMIT 5");
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-box"></i></div>
        <div class="stat-info">
            <h4><?php echo $totalProducts; ?></h4>
            <p>Total Products</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-tags"></i></div>
        <div class="stat-info">
            <h4><?php echo $totalCategories; ?></h4>
            <p>Categories</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-star"></i></div>
        <div class="stat-info">
            <h4><?php echo $featuredProducts; ?></h4>
            <p>Featured Products</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <h4><?php echo $activeProducts; ?></h4>
            <p>Active Products</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-clock"></i> Recently Added Products</h3>
        <a href="products.php" class="btn btn-primary btn-sm">View All</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $recentProducts->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td>
                    <?php if($row['image']): ?>
                        <img src="../uploads/<?php echo $row['image']; ?>" alt="">
                    <?php else: ?>
                        <div style="width:50px;height:50px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:#ccc;"></i></div>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['category_name'] ?? 'Uncategorized'; ?></td>
                <td><i class="fas fa-rupee-sign" style="font-size:12px;"></i> <?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <span class="badge <?php echo $row['status'] ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $row['status'] ? 'Active' : 'Inactive'; ?>
                    </span>
                </td>
                <td>
                    <a href="product_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    <a href="product_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-eye"></i> Most Viewed Products</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $mostViewed->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['category_name'] ?? 'Uncategorized'; ?></td>
                <td><i class="fas fa-eye" style="color:var(--primary);"></i> <?php echo $row['views']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once 'footer.php'; ?>
