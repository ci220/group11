<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>
<body>
    <div class="main-layout">
        <!-- Left Side: Picture with Text Overlay -->
        <div class="left-section">
            <img src="image/header.jpg" alt="Contact Us" class="left-image">
            <div class="overlay">
                <h2>Get in Touch</h2>
                <h3>We are here to assist you. Get in touch with us</h3>
            </div>
        </div>

        <!-- Right Side: Contact Form -->
        <div class="contact-container">
            <h2>Contact Us</h2>
            <form method="POST" action="contactus.php">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                </div>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <?php include basePath('ui/partials/footer.php'); ?>
