<?php
require_once 'includes/functions.php';
$featuredProducts = getFeaturedProducts(8);
$allCategories = getCategories();
?>
<?php require_once 'includes/header.php'; ?>

<style>
/* Hero */
.hero { background: linear-gradient(135deg, var(--dark) 0%, var(--secondary) 100%); color: #fff; padding: 80px 0; position: relative; overflow: hidden; }
.hero::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
.hero .container { position: relative; z-index: 1; }
.hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
.hero-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 18px; background: rgba(230,126,34,0.2); border: 1px solid rgba(230,126,34,0.3); border-radius: 50px; font-size: 13px; color: var(--primary); margin-bottom: 20px; }
.hero h1 { font-size: 42px; font-weight: 800; line-height: 1.2; margin-bottom: 20px; }
.hero h1 span { color: var(--primary); }
.hero p { font-size: 16px; color: rgba(255,255,255,0.75); margin-bottom: 30px; line-height: 1.8; }
.hero-buttons { display: flex; gap: 15px; margin-bottom: 40px; }
.btn { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; transition: all 0.3s; }
.btn-primary { background: var(--primary); color: #fff; }
.btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }
.btn-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.3); }
.btn-outline:hover { background: #fff; color: var(--dark); }
.hero-stats { display: flex; gap: 40px; }
.hero-stats .stat h3 { font-size: 32px; font-weight: 800; color: var(--primary); }
.hero-stats .stat p { font-size: 13px; color: rgba(255,255,255,0.6); margin: 0; }
.hero-image { text-align: center; }
.hero-image i { font-size: 200px; color: rgba(230,126,34,0.15); }

/* Sections */
.section { padding: 70px 0; }
.section-header { text-align: center; margin-bottom: 50px; }
.section-tag { display: inline-block; padding: 5px 18px; background: rgba(230,126,34,0.1); color: var(--primary); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border-radius: 50px; margin-bottom: 12px; }
.section-title { font-size: 32px; font-weight: 700; color: var(--dark); }
.section-title span { color: var(--primary); }

/* Products */
.products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.product-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: all 0.3s; border: 1px solid var(--border); }
.product-card:hover { transform: translateY(-6px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
.product-image { height: 200px; background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center; position: relative; }
.product-image i { font-size: 50px; color: #ccc; }
.product-image .badge-featured { position: absolute; top: 12px; left: 12px; background: var(--primary); color: #fff; padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; }
.product-info { padding: 20px; }
.product-info .cat { font-size: 12px; color: var(--primary); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
.product-info h3 { font-size: 15px; font-weight: 600; color: var(--dark); margin: 6px 0 10px; }
.product-info .price { font-size: 18px; font-weight: 700; color: var(--primary); }
.product-info .price small { font-size: 12px; color: var(--gray); font-weight: 400; text-decoration: line-through; margin-left: 5px; }

/* Categories */
.categories-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.category-card { background: #fff; border-radius: 12px; padding: 30px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: all 0.3s; border: 1px solid var(--border); }
.category-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-color: var(--primary); }
.category-card i { font-size: 40px; color: var(--primary); margin-bottom: 15px; }
.category-card h3 { font-size: 16px; font-weight: 600; color: var(--dark); }
.category-card p { font-size: 13px; color: var(--gray); margin-top: 5px; }

/* Why Choose */
.why-section { background: #fff; }
.why-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.why-card { text-align: center; padding: 30px; }
.why-card i { font-size: 40px; color: var(--primary); margin-bottom: 15px; }
.why-card h3 { font-size: 17px; font-weight: 600; margin-bottom: 8px; }
.why-card p { font-size: 14px; color: var(--gray); }

/* CTA */
.cta { background: var(--primary); padding: 60px 0; text-align: center; color: #fff; }
.cta h2 { font-size: 32px; font-weight: 700; margin-bottom: 10px; }
.cta p { font-size: 16px; opacity: 0.9; margin-bottom: 25px; }
.cta .btn { background: #fff; color: var(--primary); }

@media (max-width: 1024px) {
    .products-grid, .categories-grid, .why-grid { grid-template-columns: repeat(2, 1fr); }
    .hero-grid { grid-template-columns: 1fr; text-align: center; }
    .hero-image { display: none; }
}
@media (max-width: 640px) {
    .products-grid, .categories-grid, .why-grid { grid-template-columns: 1fr; }
    .hero h1 { font-size: 28px; }
    .section-title { font-size: 24px; }
    .hero-buttons { flex-direction: column; }
    .btn { width: 100%; justify-content: center; }
}
</style>

<!-- Hero -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div>
                <div class="hero-badge"><i class="fas fa-award"></i> Over 5 Decades of Excellence</div>
                <h1>India's Largest Range of <span>Two Wheeler Spare Parts</span></h1>
                <p>Manufacturer & Supplier of Quality-Assured Speedometer Cables, Bearings, Plugs, Chain Sprockets, Disc Calipers & More.</p>
                <div class="hero-buttons">
                    <a href="products.php" class="btn btn-primary"><i class="fas fa-box-open"></i> Explore Products</a>
                    <a href="contact.php" class="btn btn-outline"><i class="fas fa-phone"></i> Get in Touch</a>
                </div>
                <div class="hero-stats">
                    <div class="stat"><h3>50+</h3><p>Years Experience</p></div>
                    <div class="stat"><h3>1000+</h3><p>Products Range</p></div>
                    <div class="stat"><h3>5000+</h3><p>Happy Clients</p></div>
                </div>
            </div>
            <div class="hero-image"><i class="fas fa-motorcycle"></i></div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="section" style="background:#fff;">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Shop By Categories</span>
            <h2 class="section-title">Browse Our <span>Categories</span></h2>
        </div>
        <div class="categories-grid">
            <?php
            $catIcons = ['fa-tachometer-alt','fa-circle','fa-lightbulb','fa-fire','fa-cogs','fa-compact-disc','fa-lightbulb','fa-wrench'];
            $i = 0;
            while($cat = $allCategories->fetch_assoc()):
            ?>
            <a href="products.php?category=<?php echo $cat['id']; ?>" class="category-card">
                <i class="fas <?php echo $catIcons[$i] ?? 'fa-cog'; ?>"></i>
                <h3><?php echo $cat['name']; ?></h3>
                <p><?php echo $cat['description']; ?></p>
            </a>
            <?php $i++; endwhile; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Best Selling</span>
            <h2 class="section-title">Featured <span>Products</span></h2>
        </div>
        <div class="products-grid">
            <?php while($product = $featuredProducts->fetch_assoc()): ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if($product['image']): ?>
                        <img src="uploads/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <i class="fas fa-cog"></i>
                    <?php endif; ?>
                    <?php if($product['featured']): ?><span class="badge-featured">Featured</span><?php endif; ?>
                </div>
                <div class="product-info">
                    <span class="cat"><?php echo $product['category_name'] ?? 'General'; ?></span>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <div class="price"><i class="fas fa-rupee-sign" style="font-size:13px;"></i> <?php echo number_format($product['price'], 2); ?></div>
                    <a href="product.php?slug=<?php echo $product['slug']; ?>" style="display:block;margin-top:12px;padding:10px;text-align:center;background:var(--light);border-radius:6px;color:var(--dark);font-size:13px;font-weight:600;">View Details <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div style="text-align:center;margin-top:40px;">
            <a href="products.php" class="btn btn-primary"><i class="fas fa-th"></i> View All Products</a>
        </div>
    </div>
</section>

<!-- Why Choose -->
<section class="section why-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Why Choose Us</span>
            <h2 class="section-title">The SIAF <span>Advantage</span></h2>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <i class="fas fa-medal"></i>
                <h3>Quality Assured</h3>
                <p>Every product undergoes rigorous testing for reliable performance.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-tags"></i>
                <h3>Cost Effective</h3>
                <p>Best quality products at the most competitive prices.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-boxes"></i>
                <h3>Wide Range</h3>
                <p>Cables, Blinkers, Bearings, Plugs & more under one roof.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-shipping-fast"></i>
                <h3>On-Time Delivery</h3>
                <p>Fast and dependable supply chain across India.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <h2>Ready to Order Quality Spare Parts?</h2>
        <p>Get in touch with us today for bulk orders, dealership inquiries, or product information.</p>
        <a href="contact.php" class="btn"><i class="fas fa-phone"></i> Contact Us Now</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
