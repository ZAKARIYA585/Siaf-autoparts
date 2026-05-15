<?php
require_once 'header.php';

$db = getDB();

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : 0;

$where = "WHERE 1=1";
if ($search) $where .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
if ($category_filter) $where .= " AND p.category_id = $category_filter";

$result = $db->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id $where ORDER BY p.created_at DESC");
$categories = $db->query("SELECT * FROM categories WHERE status = 1 ORDER BY sort_order");

$message = '';
if (isset($_GET['msg'])) {
    $message = $_GET['msg'] == 'added' ? 'Product added successfully!' : ($_GET['msg'] == 'updated' ? 'Product updated successfully!' : 'Product deleted successfully!');
}
?>

<?php if ($message): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $message; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-box"></i> All Products</h3>
        <a href="product_add.php" class="btn btn-success"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    
    <form method="GET" style="margin-bottom:20px;display:flex;gap:10px;flex-wrap:wrap;">
        <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>" style="padding:8px 14px;border:2px solid var(--border);border-radius:8px;min-width:250px;font-family:'Poppins',sans-serif;">
        <select name="category" style="padding:8px 14px;border:2px solid var(--border);border-radius:8px;font-family:'Poppins',sans-serif;">
            <option value="0">All Categories</option>
            <?php $categories->data_seek(0); while($cat = $categories->fetch_assoc()): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo $category_filter == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Search</button>
        <a href="products.php" class="btn btn-sm" style="background:var(--border);"><i class="fas fa-undo"></i> Reset</a>
    </form>
    
    <div style="overflow-x:auto;">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Featured</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td>
                    <?php if($row['image']): ?>
                        <img src="../uploads/<?php echo $row['image']; ?>" alt="" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div style="width:50px;height:50px;background:#f0f0f0;border-radius:6px;display:none;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:#ccc;"></i></div>
                    <?php else: ?>
                        <div style="width:50px;height:50px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image" style="color:#ccc;"></i></div>
                    <?php endif; ?>
                </td>
                <td><strong><?php echo htmlspecialchars($row['name']); ?></strong><br><small style="color:var(--gray);"><?php echo substr(strip_tags($row['description'] ?? ''), 0, 50); ?>...</small></td>
                <td><?php echo $row['category_name'] ?? 'Uncategorized'; ?></td>
                <td><i class="fas fa-rupee-sign" style="font-size:12px;"></i> <?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <span class="badge <?php echo $row['featured'] ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $row['featured'] ? 'Yes' : 'No'; ?>
                    </span>
                </td>
                <td>
                    <span class="badge <?php echo $row['status'] ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $row['status'] ? 'Active' : 'Inactive'; ?>
                    </span>
                </td>
                <td>
                    <a href="product_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    <a href="product_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once 'footer.php'; ?>
