<?php
require_once 'config/database.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $product = sanitize($_POST['product'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO contact_messages (name, email, phone, product, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $product, $message);

        if ($stmt->execute()) {
            $success = 'Thank you for your message! We will get back to you soon.';
        } else {
            $error = 'Sorry, there was an error sending your message. Please try again.';
        }
        $stmt->close();
    } else {
        $error = 'Please fill in all required fields.';
    }
}

$productName = $_GET['product'] ?? '';
?>
<?php require_once 'includes/header.php'; ?>

<style>
.contact-section { padding: 60px 0; }
.contact-grid { display: grid; grid-template-columns: 1fr 1.2fr; gap: 50px; }
.contact-info { display: flex; flex-direction: column; gap: 20px; }
.info-card { display: flex; gap: 16px; padding: 24px; background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: all 0.3s; border: 1px solid var(--border); }
.info-card:hover { transform: translateX(5px); border-color: var(--primary); }
.info-card i { width: 45px; height: 45px; min-width: 45px; background: var(--primary); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
.info-card h4 { font-size: 16px; font-weight: 600; margin-bottom: 5px; }
.info-card p { font-size: 14px; color: var(--gray); line-height: 1.6; }
.info-card a { color: var(--primary); }

.contact-form { background: #fff; border-radius: 16px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid var(--border); }
.contact-form h3 { font-size: 22px; font-weight: 700; margin-bottom: 20px; color: var(--dark); }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; }
.form-group input, .form-group select, .form-group textarea {
    width: 100%; padding: 12px 14px; border: 2px solid var(--border); border-radius: 8px;
    font-family: 'Poppins', sans-serif; font-size: 14px; transition: all 0.3s;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(230,126,34,0.1); }
.form-group textarea { resize: vertical; min-height: 100px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.btn-submit {
    width: 100%; padding: 14px; background: var(--primary); color: #fff; border: none; border-radius: 8px;
    font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s;
}
.btn-submit:hover { background: var(--primary-dark); }
.alert-success { background: #d4edda; color: #155724; padding: 14px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #c3e6cb; }
.alert-error { background: #f8d7da; color: #721c24; padding: 14px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #f5c6cb; }

@media (max-width: 1024px) {
    .contact-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .form-row { grid-template-columns: 1fr; }
}
</style>

<!-- Banner -->
<div class="page-banner">
    <div class="container">
        <h1><i class="fas fa-envelope"></i> Contact Us</h1>
        <p>We'd love to hear from you. Reach out for orders or inquiries.</p>
    </div>
</div>

<!-- Contact -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <div class="info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4>Visit Us</h4>
                        <p> Godhra<br> Gijarat<br> India<br></p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <h4>Call Us</h4>
                        <p><a href="tel:9999999999">9999999999</a></p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fas fa-user-tie"></i>
                    <div>
                        <h4>Proprietor</h4>
                        <p>Mr. Sirajuddin</p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fas fa-file-invoice"></i>
                    <div>
                        <h4>GST Number</h4>
                        <p>07GIDPS6775P2Z3</p>
                    </div>
                </div>
            </div>
            <div class="contact-form">
                <h3><i class="fas fa-paper-plane"></i> Send Us a Message</h3>
                <?php if ($success): ?>
                <div class="alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                <div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Your Name</label>
                            <input type="text" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="Enter phone number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <label>Interested Product</label>
                        <input type="text" name="product" placeholder="Product name" value="<?php echo htmlspecialchars($productName); ?>">
                    </div>
                    <div class="form-group">
                        <label>Your Message</label>
                        <textarea name="message" rows="4" placeholder="Tell us your requirements..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
