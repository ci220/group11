<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            <h2>Join RailConnect</h2>
            <div class="error-message" id="errorMessage"></div>
            <form class="register-form" action="register_handler.php" method="POST">
                <div class="input-row">
                    <input type="text" name="firstName" placeholder="First Name" autocomplete="given-name" required>
                    <input type="text" name="secondName" placeholder="Second Name" autocomplete="family-name" required>
                </div>
                <input type="text" name="username" placeholder="Username" autocomplete="username" required>
                <input type="email" name="email" placeholder="Email" autocomplete="email" required>
                <div class="password-input">
                    <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <div class="password-input">
                    <input type="password" name="confirmPassword" placeholder="Confirm Password" autocomplete="new-password" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <button type="submit">Create Account</button>
            </form>
            <p class="login-text">Already have an account? <a href="login.php">Login</a></p>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/validate_register.js"></script>
    <script src="js/components.js"></script>
</body>
</html>
