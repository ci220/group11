

<?php include basePath('ui/partials/header.php'); ?>
<?php include basePath('ui/partials/navigation.php'); ?>
<main>
    <div class="profile-container">
        <h2>User Profile</h2>

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
            ?>
        <div class="profile-picture-container">
        <?php 
        $profilePicture = !empty($user['profile_picture']) ? '/uploads/images/profile/' . htmlspecialchars($user['profile_picture']) : 'image/Avatar.png'; 
       ?>
        <img src="<?= $profilePicture ?>" 
             alt="Profile Picture" 
             class="profile-picture">
    </div>
    <div class="profile-links">
        <a href="/post/create" class="profile-link">+ Create Post</a>
        <span class="link-separator">|</span>
        <a href="/mypost" class="profile-link">My Posts</a>
    </div>
        
        <form class="profile-form">
        <div class="profile-field">
                <label for="username">Username</label>
                <p id="username"><?= htmlspecialchars($user['username']) ?></p> <!-- Changed to plain text -->
            </div>
        <div class="profile-field">
        <label for="firstName">First Name</label>
        <div class="bordered-text"><?= htmlspecialchars($user['first_name']) ?></div>
        </div>
        <div class="profile-field">
            <label for="secondName">Second Name</label>
            <div class="bordered-text"><?= htmlspecialchars($user['second_name']) ?></div>
        </div>
        <div class="profile-field">
            <label for="email">Email</label>
            <div class="bordered-text"><?= htmlspecialchars($user['email']) ?></div>
        </div>
        </form>
        <div class="button-container">
                <button type="button" class="edit-profile-btn" onclick="window.location.href='/profile/edit'">Edit Profile</button>
                <button type="button" class="change-password-btn" onclick="window.location.href='/profile/change-password'">Change Password</button>
            </div>
            <div class="button-container">
                <form action="/profile/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                    <button type="submit" class="delete-acc-button">Delete Account</button>
                </form>
            </div>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>

