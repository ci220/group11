<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>
<body>
    <main>
        <div class="register-box">
            <h2>Join RailConnect</h2>

            <div id="errorMessage" class="error-message" style="display:none;"></div>

            <?php
                if (!empty($_SESSION['_flash'])) {
                    foreach ($_SESSION['_flash'] as $key => $message) {
                        if (is_array($message)) {
                            $message = implode(', ', $message);
                        }
                        // Simple inline display, customize as desired
                        echo "<div class='error-message' id='errorMessage'>$message</div>";
                    }
                }

                $old = isset($_SESSION['_flash']['old']) ? $_SESSION['_flash']['old'] : [];
                // Clear old form data so it doesn't persist unnecessarily
                unset($_SESSION['_flash']['old']);
            ?>
            <form class="register-form" action="/register" method="POST">
                <div class="input-row">
                    <input type="text" name="firstName" placeholder="First Name" autocomplete="given-name" required value="<?= isset($_GET['firstName']) ? htmlspecialchars(urldecode($_GET['firstName'])) : '' ?>">
                    <input type="text" name="secondName" placeholder="Second Name" autocomplete="family-name" required value="<?= isset($_GET['secondName']) ? htmlspecialchars(urldecode($_GET['secondName'])) : '' ?>">
                </div>
                <input type="text" name="username" placeholder="Username" autocomplete="username" required value="<?= isset($_GET['username']) ? htmlspecialchars(urldecode($_GET['username'])) : '' ?>">
                <input type="email" name="email" placeholder="Email" autocomplete="email" required value="<?= isset($_GET['email']) ? htmlspecialchars(urldecode($_GET['email'])) : '' ?>">
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
            <p class="login-text">Already have an account? <a href="/login">Login</a></p>
        </div>
    </main>

<?php include basePath('ui/partials/footer.php'); ?>