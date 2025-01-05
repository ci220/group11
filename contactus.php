<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php include 'navigation.php'; ?>

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
            <form method="POST" action="contact_handler.php"> <!-- Correctly point to contact_handler.php -->
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

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/components.js"></script>
    <script src="js/validate_login.js"></script>
</body>

</html>
