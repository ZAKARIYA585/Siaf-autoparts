<?php
require_once 'includes/functions.php';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : 0;
$products = getAllProducts(0, $categoryFilter);
$allCategories = getCategories();
$currentCategory = null;
if ($categoryFilter) {
    $db = getDB();
    $currentCategory = $db->query("SELECT name FROM categories WHERE id = $categoryFilter AND status = 1 LIMIT 1")->fetch_assoc();
}
?>
<?php require_once 'includes/header.php'; ?>

<style>
.products-page { padding: 60px 0; }
.filter-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 30px; }
.filter-bar a {
    padding: 8px 18px; background: #fff; border: 1px solid var(--border); border-radius: 50px;
    font-size: 13px; color: var(--dark); transition: all 0.3s;
}
.filter-bar a:hover, .filter-bar a.active { background: var(--primary); color: #fff; border-color: var(--primary); }
.products-list-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: all 0.3s; border: 1px solid var(--border); }
.product-card:hover { transform: translateY(-6px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
.product-image { height: 220px; background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center; position: relative; }
.product-image i { font-size: 50px; color: #ccc; }
.product-image img { width: 100%; height: 100%; object-fit: cover; }
.product-image .badge-featured { position: absolute; top: 12px; left: 12px; background: var(--primary); color: #fff; padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; }
.product-info { padding: 20px; }
.product-info .cat { font-size: 12px; color: var(--primary); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
.product-info h3 { font-size: 15px; font-weight: 600; color: var(--dark); margin: 6px 0 8px; }
.product-info p { font-size: 13px; color: var(--gray); margin-bottom: 10px; line-height: 1.5; }
.product-info .price { font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 12px; }
.btn-view { display: block; padding: 10px; text-align: center; background: var(--light); border-radius: 6px; color: var(--dark); font-size: 13px; font-weight: 600; transition: all 0.3s; }
.btn-view:hover { background: var(--primary); color: #fff; }
.no-products { text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; }
.no-products i { font-size: 60px; color: #ddd; margin-bottom: 15px; }
.no-products h3 { color: var(--gray); }
@media (max-width: 1024px) { .products-list-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .products-list-grid { grid-template-columns: 1fr; } }
</style>

<!-- Banner -->
<div class="page-banner">
    <div class="container">
        <h1><i class="fas fa-box-open"></i> Our Products</h1>
        <p><?php echo $currentCategory ? 'Category: ' . $currentCategory['name'] : 'Browse our complete range of two wheeler spare parts'; ?></p>
    </div>
</div>

<!-- Products -->
<section class="products-page">
    <div class="container">
        <div class="filter-bar">
            <a href="products.php" class="<?php echo !$categoryFilter ? 'active' : ''; ?>">All Products</a>
            <?php $allCategories->data_seek(0); while($cat = $allCategories->fetch_assoc()): ?>
            <a href="products.php?category=<?php echo $cat['id']; ?>" class="<?php echo $categoryFilter == $cat['id'] ? 'active' : ''; ?>"><?php echo $cat['name']; ?></a>
            <?php endwhile; ?>
        </div>

        <?php if ($products->num_rows > 0): ?>
        <div class="products-list-grid">
            <?php while($product = $products->fetch_assoc()): ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if($product['image']): ?>
                        <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <i class="fas fa-cog"></i>
                    <?php endif; ?>
                    <?php if($product['featured']): ?><span class="badge-featured">Featured</span><?php endif; ?>
                </div>
                <div class="product-info">
                    <span class="cat"><?php echo $product['category_name'] ?? 'General'; ?></span>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo substr(strip_tags($product['description'] ?? ''), 0, 60); ?>...</p>
                    <div class="price"><i class="fas fa-rupee-sign" style="font-size:13px;"></i> <?php echo number_format($product['price'], 2); ?></div>
                    <a href="product.php?slug=<?php echo $product['slug']; ?>" class="btn-view">View Details <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="no-products">
            <i class="fas fa-box-open"></i>
            <h3>No products found in this category.</h3>
            <p><a href="products.php" class="btn btn-primary" style="margin-top:15px;"><i class="fas fa-undo"></i> View All Products</a></p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
