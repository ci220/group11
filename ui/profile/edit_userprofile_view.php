<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        
        <?php
        if (!empty($_SESSION['_flash'])) {
            foreach ($_SESSION['_flash'] as $key => $message) {
                if ($key === 'success') {
                    echo "<div class='success-message'>$message</div>";
                } elseif ($key === 'error') {
                    echo "<div class='error-message'>$message</div>";
                }
            }
        }
        $old = $_SESSION['_flash']['old'] ?? [];
        unset($_SESSION['_flash']['old']);
        ?>

        <form action="/profile/edit" method="POST" enctype="multipart/form-data">
            <div class="profile-picture-container">
                <?php 
                $profilePicture = !empty($user['profile_picture']) 
                    ? '/uploads/images/profile/' . htmlspecialchars($user['profile_picture']) 
                    : '/image/Avatar.png'; 
                ?>
                <img src="<?= htmlspecialchars($profilePicture) ?>" alt="Profile Picture" class="profile-picture">
                <input type="file" name="profile_picture" accept="image/jpeg,image/png">
            </div>

            <div class="profile-field">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" 
                       value="<?= htmlspecialchars($old['first_name'] ?? $user['first_name']) ?>" required>
            </div>

            <div class="profile-field">
                <label for="second_name">Second Name</label>
                <input type="text" name="second_name" id="second_name" 
                       value="<?= htmlspecialchars($old['second_name'] ?? $user['second_name']) ?>" required>
            </div>

            <div class="profile-field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" 
                       value="<?= htmlspecialchars($old['email'] ?? $user['email']) ?>" required>
            </div>

            <div class="button-container">
                <button type="button" onclick="window.location.href='/profile'" class="cancel-button">Cancel</button>
                <button type="submit" class="save-button">Save Changes</button>
            </div>
        </form>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>

