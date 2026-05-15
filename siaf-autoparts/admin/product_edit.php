<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$db = getDB();
$id = intval($_GET['id'] ?? 0);

if (!$id) {
    header('Location: products.php');
    exit;
}

$product = $db->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
if (!$product) {
    header('Location: products.php');
    exit;
}

$categories = $db->query("SELECT * FROM categories WHERE status = 1 ORDER BY sort_order");

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $slug = sanitize(strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $_POST['name']), '-')));
    $category_id = intval($_POST['category_id']);
    $description = sanitize($_POST['description']);
    $specifications = sanitize($_POST['specifications']);
    $price = floatval($_POST['price']);
    $status = isset($_POST['status']) ? 1 : 0;
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    $check = $db->query("SELECT id FROM products WHERE slug = '$slug' AND id != $id");
    if ($check->num_rows > 0) {
        $slug .= '-' . time();
    }
    
    $image = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        
        // Delete old image
        if ($image && file_exists($uploadDir . $image)) {
            unlink($uploadDir . $image);
        }
        
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = $slug . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
    }
    
    $stmt = $db->prepare("UPDATE products SET name = ?, slug = ?, category_id = ?, description = ?, specifications = ?, image = ?, price = ?, status = ?, featured = ? WHERE id = ?");
    $stmt->bind_param("ssisssdiii", $name, $slug, $category_id, $description, $specifications, $image, $price, $status, $featured, $id);
    
    if ($stmt->execute()) {
        header('Location: products.php?msg=updated');
        exit;
    } else {
        $error = 'Error: ' . $stmt->error;
    }
    $stmt->close();
}

require_once 'header.php';
$page = 'product_edit';
?>
<?php $page = basename($_SERVER['PHP_SELF'], '.php'); ?>

<?php if ($error): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit"></i> Edit Product</h3>
        <a href="products.php" class="btn btn-sm" style="background:var(--border);"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" required value="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="0">Select Category</option>
                    <?php $categories->data_seek(0); while($cat = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $product['category_id'] == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Price (<i class="fas fa-rupee-sign"></i>)</label>
                <input type="number" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>">
            </div>
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" accept="image/*">
                <?php if($product['image']): ?>
                    <div style="margin-top:8px;"><img src="../uploads/<?php echo $product['image']; ?>" style="width:80px;height:80px;object-fit:cover;border-radius:6px;"></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Specifications</label>
            <textarea name="specifications"><?php echo htmlspecialchars($product['specifications']); ?></textarea>
        </div>
        <div style="display:flex;gap:30px;margin-bottom:20px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="featured" value="1" <?php echo $product['featured'] ? 'checked' : ''; ?> style="width:auto;"> Featured Product
            </label>
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="status" value="1" <?php echo $product['status'] ? 'checked' : ''; ?> style="width:auto;"> Active
            </label>
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Product</button>
    </form>
</div>

<?php require_once 'footer.php'; ?>
