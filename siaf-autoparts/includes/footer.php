    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">
                        <span class="logo-icon"><img src="images/logo.png" alt="AAFIYA Logo"></span>
                        <div class="logo-text">
                            <span class="logo-main">AAFIYA</span>
                            <span class="logo-sub" style="color:var(--primary);">GENUINE PARTS</span>
                        </div>
                    </a>
                    <p>Manufacturer & Supplier of Quality Two Wheeler Spare Parts. Over 5 decades of excellence in delivering performance, durability, and reliability.</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="company-profile.php">Company Profile</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="admin/login.php">Admin Login</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Our Products</h4>
                    <ul>
                        <li><a href="products.php">Control Cables</a></li>
                        <li><a href="products.php">Bearings</a></li>
                        <li><a href="products.php">Spark Plugs</a></li>
                        <li><a href="products.php">Chain Sprockets</a></li>
                        <li><a href="products.php">Head Lights</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Contact Info</h4>
                    <p><i class="fas fa-map-marker-alt"></i> Godhra, India</p>
                    <p><i class="fas fa-phone-alt"></i> <a href="tel:08045479338" style="color:rgba(255,255,255,0.6);">9999999999</a></p>
                    <p><i class="fas fa-user"></i> Mr.Sirajjudin </p>
                    <p><i class="fas fa-file-invoice"></i> GST: 07GIDPS6775P2Z3 </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> AAFIYA GENUINE PARTS. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('hamburger')?.addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('navMenu').classList.toggle('active');
        });
        document.querySelectorAll('.nav-link').forEach(function(link) {
            link.addEventListener('click', function() {
                document.getElementById('hamburger').classList.remove('active');
                document.getElementById('navMenu').classList.remove('active');
            });
        });
    </script>
</body>
</html>
