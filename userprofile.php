<?php
session_start();
include 'database.php'; // Include database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT first_name, second_name, username, email, profile_picture FROM users WHERE id = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If user data is not found
if (!$user) {
    echo 'Error: User not found.';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Add your custom CSS here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include 'navigation.php'; ?>

<main>
    <div class="profile-container">
        <h2>User Profile</h2>
        <div class="profile-picture-container">
        <?php 
        $profilePicture = !empty($user['profile_picture']) ? 'uploaded_img/' . htmlspecialchars($user['profile_picture']) : 'image/Avatar.png'; 
        ?>
        <img src="<?php echo $profilePicture; ?>" 
             alt="Profile Picture" 
             class="profile-picture">
    </div>
    <div class="profile-links">
        <a href="create_post.php" class="profile-link">+ Create Post</a>
        <span class="link-separator">|</span>
        <a href="my_posts.php" class="profile-link">My Posts</a>
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
        <div class="button-container">
                <button type="button" class="edit-profile-btn" onclick="window.location.href='edit_userprofile.php'">Edit Profile</button>
                <button type="button" class="change-password-btn" onclick="window.location.href='change_password.php'">Change Password</button>
            </div>
            <div class="button-container">
                <button type="button" class="delete-acc-button" onclick="if(confirm('Are you sure you want to delete your account? This action cannot be undone.')) { window.location.href='delete_user.php'; }">Delete Account</button>
            </div>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>