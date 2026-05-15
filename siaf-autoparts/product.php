<?php
require_once 'includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) { header('Location: products.php'); exit; }

$product = getProductBySlug($slug);
if (!$product) { header('Location: products.php'); exit; }

incrementViews($product['id']);
$related = getRelatedProducts($product['category_id'], $product['id'], 4);
?>
<?php require_once 'includes/header.php'; ?>

<style>
.product-detail { padding: 60px 0; }
.product-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; }
.product-image-box { background: #fff; border-radius: 16px; padding: 30px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid var(--border); }
.product-image-box img { max-width: 100%; border-radius: 8px; }
.product-image-box i { font-size: 150px; color: #ddd; }
.product-meta { background: #fff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid var(--border); }
.product-meta .cat { display: inline-block; padding: 4px 14px; background: rgba(230,126,34,0.1); color: var(--primary); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border-radius: 50px; margin-bottom: 12px; }
.product-meta h1 { font-size: 28px; font-weight: 700; color: var(--dark); margin-bottom: 15px; }
.product-meta .price { font-size: 32px; font-weight: 800; color: var(--primary); margin-bottom: 20px; }
.product-meta .desc { font-size: 15px; color: var(--gray); line-height: 1.8; margin-bottom: 25px; }
.specs { background: var(--light); border-radius: 10px; padding: 20px; margin-bottom: 25px; }
.specs h4 { font-size: 16px; font-weight: 600; margin-bottom: 12px; }
.specs p { font-size: 14px; color: var(--gray); line-height: 1.8; }
.btn-inquiry {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 32px; background: var(--primary); color: #fff;
    border-radius: 8px; font-weight: 600; font-size: 15px; transition: all 0.3s;
}
.btn-inquiry:hover { background: var(--primary-dark); transform: translateY(-2px); }
.btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: var(--light); color: var(--dark); border-radius: 8px; font-size: 14px; font-weight: 500; margin-top: 15px; transition: all 0.3s; }
.btn-back:hover { background: var(--border); }

.related { padding: 60px 0; background: #fff; }
.related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.related-card { background: var(--light); border-radius: 12px; overflow: hidden; transition: all 0.3s; }
.related-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
.related-card .img { height: 160px; background: linear-gradient(135deg, #e0e0e0 0%, #d0d0d0 100%); display: flex; align-items: center; justify-content: center; }
.related-card .img i { font-size: 40px; color: #bbb; }
.related-card .info { padding: 15px; }
.related-card h4 { font-size: 14px; font-weight: 600; margin-bottom: 5px; }
.related-card .price { font-size: 15px; font-weight: 700; color: var(--primary); }

@media (max-width: 1024px) {
    .product-detail-grid { grid-template-columns: 1fr; }
    .related-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .related-grid { grid-template-columns: 1fr; }
    .product-meta h1 { font-size: 22px; }
}
</style>

<!-- Banner -->
<div class="page-banner">
    <div class="container">
        <h1><i class="fas fa-info-circle"></i> Product Details</h1>
        <p>Complete information about this product</p>
    </div>
</div>

<!-- Product Detail -->
<section class="product-detail">
    <div class="container">
        <div class="product-detail-grid">
            <div class="product-image-box">
                <?php if($product['image']): ?>
                    <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php else: ?>
                    <i class="fas fa-cog"></i>
                <?php endif; ?>
            </div>
            <div class="product-meta">
                <span class="cat"><?php echo $product['category_name'] ?? 'General'; ?></span>
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <div class="price"><i class="fas fa-rupee-sign" style="font-size:20px;"></i> <?php echo number_format($product['price'], 2); ?></div>
                <div class="desc"><?php echo nl2br(htmlspecialchars($product['description'])); ?></div>
                <?php if($product['specifications']): ?>
                <div class="specs">
                    <h4><i class="fas fa-wrench"></i> Specifications</h4>
                    <p><?php echo nl2br(htmlspecialchars($product['specifications'])); ?></p>
                </div>
                <?php endif; ?>
                <a href="contact.php?product=<?php echo urlencode($product['name']); ?>" class="btn-inquiry"><i class="fas fa-envelope"></i> Send Inquiry</a>
                <a href="products.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Products</a>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if ($related->num_rows > 0): ?>
<section class="related">
    <div class="container">
        <div class="section-header">
            <span class="section-tag" style="display:inline-block;padding:5px 18px;background:rgba(230,126,34,0.1);color:var(--primary);font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:1px;border-radius:50px;margin-bottom:12px;">You May Also Like</span>
            <h2 class="section-title" style="font-size:28px;font-weight:700;">Related <span style="color:var(--primary);">Products</span></h2>
        </div>
        <div class="related-grid">
            <?php while($rel = $related->fetch_assoc()): ?>
            <a href="product.php?slug=<?php echo $rel['slug']; ?>" class="related-card">
                <div class="img">
                    <?php if($rel['image']): ?>
                        <img src="uploads/<?php echo $rel['image']; ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <i class="fas fa-cog"></i>
                    <?php endif; ?>
                </div>
                <div class="info">
                    <h4><?php echo htmlspecialchars($rel['name']); ?></h4>
                    <div class="price"><i class="fas fa-rupee-sign" style="font-size:11px;"></i> <?php echo number_format($rel['price'], 2); ?></div>
                </div>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
