<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @font-face {
            font-family: 'Times';
            src: url('font/Times.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>

    <main>
        <div class="register-box">
            <h2>Login to RailConnect</h2>
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>

            <form class="register-form" action="login_handler.php" method="POST">
                <input type="text" name="username" placeholder="Username or Email" autocomplete="username" required>
                <div class="password-input">
                    <input type="password" name="password" placeholder="Password" autocomplete="current-password" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="login-text">Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
    <script src="js/components.js"></script>
    <script src="js/validate_login.js"></script>
    <script src="js/modal.js"></script>



</body>
</html>
