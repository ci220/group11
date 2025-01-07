<?php include basePath('ui/partials/header.php'); ?>
<?php include basePath('ui/partials/navigation.php'); ?>

<main>
    <div class="change-password-container">
        <h2>Change Password</h2>
        
        <?php if (hasFlash('error')): ?>
            <div class="error-message"><?= getFlash('error') ?></div>
        <?php endif; ?>

        <?php if (hasFlash('success')): ?>
            <div class="success-message"><?= getFlash('success') ?></div>
        <?php endif; ?>

        <form action="/profile/change-password" method="POST">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <div class="password-input">
                    <input type="password" name="current_password" id="current_password" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="new_password">New Password:</label>
                <div class="password-input">
                    <input type="password" name="new_password" id="new_password" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <div class="password-input">
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="button-container">
                <button type="button" class="cancel-button" onclick="window.location.href='/profile'">Cancel</button>
                <button type="submit" class="save-button">Save Changes</button>
            </div>
        </form>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>