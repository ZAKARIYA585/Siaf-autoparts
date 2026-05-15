<?php
// 1. LOGIC FIRST - No HTML or Whitespace before this!
require_once '../config/database.php'; // Ensure your DB connection is available
session_start();
$db = getDB();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    // Generate Slug
    $slug = sanitize(strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $_POST['name']), '-')));
    
    // Fix for Foreign Key Error: If "0" is selected, set to NULL
    $category_id = (isset($_POST['category_id']) && $_POST['category_id'] > 0) ? intval($_POST['category_id']) : NULL;
    
    $description = sanitize($_POST['description']);
    $specifications = sanitize($_POST['specifications']);
    $price = floatval($_POST['price']);
    $status = isset($_POST['status']) ? 1 : 0;
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    // Check if slug exists
    $check = $db->query("SELECT id FROM products WHERE slug = '$slug'");
    if ($check->num_rows > 0) {
        $slug .= '-' . time();
    }
    
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = $slug . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
    }
    
    // Prepare and bind
    $stmt = $db->prepare("INSERT INTO products (name, slug, category_id, description, specifications, image, price, status, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Note: 'i' for category_id handles NULL correctly in most modern PHP/MySQLi setups 
    // if the column is nullable in the DB.
    $stmt->bind_param("ssisssdii", $name, $slug, $category_id, $description, $specifications, $image, $price, $status, $featured);
    
    if ($stmt->execute()) {
        // This will now work without the "Headers already sent" error
        header('Location: products.php?msg=added');
        exit;
    } else {
        $error = 'Database Error: ' . $stmt->error;
    }
    $stmt->close();
}

// Fetch categories for the dropdown
$categories = $db->query("SELECT * FROM categories WHERE status = 1 ORDER BY sort_order");

// 2. NOW START THE UI
require_once 'header.php'; 
?>

<?php if ($error): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus-circle"></i> Add New Product</h3>
        <a href="products.php" class="btn btn-sm" style="background:var(--border);"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" required placeholder="Enter product name">
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="0">None / Select Category</option>
                    <?php while($cat = $categories->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Price (<i class="fas fa-rupee-sign"></i>)</label>
                <input type="number" name="price" step="0.01" min="0" placeholder="0.00" value="0">
            </div>
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" accept="image/*">
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" placeholder="Enter product description..."></textarea>
        </div>
        <div class="form-group">
            <label>Specifications</label>
            <textarea name="specifications" placeholder="Enter technical specifications..."></textarea>
        </div>
        <div style="display:flex;gap:30px;margin-bottom:20px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="featured" value="1" style="width:auto;"> Featured Product
            </label>
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="status" value="1" checked style="width:auto;"> Active
            </label>
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Product</button>
    </form>
</div>

<?php require_once 'footer.php'; ?>