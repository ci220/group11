<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<body>
    <main>
        <div class="register-box">
            <h2>Login to RailConnect</h2>

            

            <?php
                if (!empty($_SESSION['_flash'])) {
                    foreach ($_SESSION['_flash'] as $key => $message) {
                        if ($key === 'success') {
                            echo "<div class='success-message'>$message</div>";
                        } else {
                        // Simple inline display, customize as desired
                        echo "<div class='error-message'>$message</div>";
                        }
                    }
                }
            ?>

            <form class="register-form" action="/login" method="POST">
                <input type="text" name="username" placeholder="Username or Email" autocomplete="username" required>
                <div class="password-input">
                    <input type="password" name="password" placeholder="Password" autocomplete="current-password" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="login-text">Don't have an account? <a href="/register">Register</a></p>
        </div>
    </main>
 <div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p id="successMessage"></p>
    </div>
</div>
<?php include basePath('ui/partials/footer.php'); ?>
