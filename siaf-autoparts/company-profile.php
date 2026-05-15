<?php require_once 'includes/header.php'; ?>

<style>
.company-section { padding: 60px 0; }
.company-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; }
.company-image { background: linear-gradient(135deg, var(--dark) 0%, var(--secondary) 100%); border-radius: 16px; padding: 50px; text-align: center; position: relative; }
.company-image i { font-size: 150px; color: rgba(230,126,34,0.3); }
.company-badge { position: absolute; bottom: 30px; right: -20px; background: var(--primary); color: #fff; padding: 20px 30px; border-radius: 12px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
.company-badge span { display: block; font-size: 36px; font-weight: 800; line-height: 1; }
.company-badge small { font-size: 13px; }
.company-content h2 { font-size: 32px; font-weight: 700; margin-bottom: 20px; color: var(--dark); }
.company-content h2 span { color: var(--primary); }
.company-content p { font-size: 15px; color: var(--gray); line-height: 1.9; margin-bottom: 18px; }

.features-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 30px; }
.feature-item { display: flex; gap: 14px; align-items: flex-start; padding: 15px; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); }
.feature-item i { width: 45px; height: 45px; min-width: 45px; background: rgba(230,126,34,0.1); color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
.feature-item h4 { font-size: 15px; font-weight: 600; margin-bottom: 3px; }
.feature-item p { font-size: 13px; color: var(--gray); margin: 0; }

.info-section { background: #fff; padding: 60px 0; }
.info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.info-card { background: var(--light); border-radius: 12px; padding: 30px; text-align: center; transition: all 0.3s; }
.info-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
.info-card i { font-size: 36px; color: var(--primary); margin-bottom: 15px; }
.info-card h3 { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
.info-card p { font-size: 14px; color: var(--gray); }

@media (max-width: 1024px) {
    .company-grid { grid-template-columns: 1fr; }
    .company-badge { right: 20px; }
    .info-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .features-grid, .info-grid { grid-template-columns: 1fr; }
    .company-content h2 { font-size: 24px; }
}
</style>

<!-- Banner -->
<div class="page-banner">
    <div class="container">
        <h1><i class="fas fa-building"></i> Company Profile</h1>
        <p>Learn more about AAFIYA GENUINE PARTS and our legacy</p>
    </div>
</div>

<!-- About -->
<section class="company-section">
    <div class="container">
        <div class="company-grid">
            <div class="company-image">
                <i class="fas fa-motorcycle"></i>
                <div class="company-badge"><span>50+</span><small>Years of<br>Excellence</small></div>
            </div>
            <div class="company-content">
                <h2>Your Trusted Partner for <span>Two Wheeler Spare Parts</span></h2>
                <p>AAFIYA GENUINE PARTS is an esteemed manufacturer and supplier of quality-assured and cost-effective two-wheeler spare parts. Our flagship brand was launched in 2015, building on over five decades of industry expertise.</p>
                <p>We specialize in Speedometer & Control Cables, Side Blinkers, Bearings, Plugs, and a comprehensive range of other components. Our commitment to quality, innovation, and customer satisfaction has made us a preferred choice across India.</p>
                <div class="features-grid">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h4>Quality Assured</h4>
                            <p>Every product tested for durability</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-rupee-sign"></i>
                        <div>
                            <h4>Cost Effective</h4>
                            <p>Competitive pricing without compromise</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-boxes"></i>
                        <div>
                            <h4>Wide Range</h4>
                            <p>India's largest spare parts catalog</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shipping-fast"></i>
                        <div>
                            <h4>On-Time Delivery</h4>
                            <p>Reliable logistics nationwide</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Info -->
<section class="info-section">
    <div class="container">
        <div class="section-header" style="margin-bottom:40px;">
            <span style="display:inline-block;padding:5px 18px;background:rgba(230,126,34,0.1);color:var(--primary);font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:1px;border-radius:50px;margin-bottom:12px;">Our Strengths</span>
            <h2 style="font-size:28px;font-weight:700;">Why <span style="color:var(--primary);">Choose Us</span></h2>
        </div>
        <div class="info-grid">
            <div class="info-card">
                <i class="fas fa-medal"></i>
                <h3>Uncompromising Quality</h3>
                <p>Every product undergoes rigorous quality checks to ensure durability, performance, and safety.</p>
            </div>
            <div class="info-card">
                <i class="fas fa-tags"></i>
                <h3>Competitive Pricing</h3>
                <p>Cost-effective solutions without compromising on quality, giving you the best value for money.</p>
            </div>
            <div class="info-card">
                <i class="fas fa-warehouse"></i>
                <h3>Extensive Inventory</h3>
                <p>India's largest range of two-wheeler spare parts with thousands of SKUs in stock.</p>
            </div>
            <div class="info-card">
                <i class="fas fa-truck"></i>
                <h3>Timely Delivery</h3>
                <p>Robust logistics network ensuring your orders reach you on time, every time.</p>
            </div>
            <div class="info-card">
                <i class="fas fa-headset"></i>
                <h3>Dedicated Support</h3>
                <p>Our experienced team provides personalized assistance for all your spare part needs.</p>
            </div>
            <div class="info-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Trusted Legacy</h3>
                <p>Over 50 years of trust and reliability in the automotive spare parts industry.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
