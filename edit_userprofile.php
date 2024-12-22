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

if (!$user) {
    echo 'Error: User not found.';
    exit();
}

// Initialize error and success message variables
$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assume user is already authenticated and $userId is set
    $firstName = $_POST['first_name'];
    $secondName = $_POST['second_name'];
    $email = $_POST['email'];

    // Update user information in the database
    $updateStmt = $pdo->prepare('UPDATE users SET first_name = ?, second_name = ?, email = ? WHERE id = ?');
    if (!$updateStmt->execute([$firstName, $secondName, $email, $userId])) {
        $errorMessage = 'Failed to update user information. Please try again.';
    }

    // Handle profile picture upload
   // Handle profile picture upload
$profile_picture = $_FILES['profile_picture']['name'];
$profile_picture_size = $_FILES['profile_picture']['size'];
$profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];
$profile_picture_folder = 'uploaded_img/' . $profile_picture;

// Check if the directory exists, if not, create it
if (!is_dir('uploaded_img')) {
    mkdir('uploaded_img', 0755, true); // Create the directory with appropriate permissions
}

if (!empty($profile_picture)) {
    if ($profile_picture_size > 2000000) {
        $errorMessage = 'Image is too large. Maximum size is 2MB.';
    } else {
        // Update the profile picture in the database
        $image_update_stmt = $pdo->prepare('UPDATE users SET profile_picture = ? WHERE id = ?');
        if ($image_update_stmt->execute([$profile_picture, $userId])) {
            if (move_uploaded_file($profile_picture_tmp_name, $profile_picture_folder)) {
                $successMessage = 'Profile picture updated successfully!';
            } else {
                $errorMessage = 'Failed to move uploaded file.';
            }
        } else {
            $errorMessage = 'Failed to update profile picture. Please try again.';
        }
    }
}


        if (empty($errorMessage)) {
            header('Location: userprofile.php');
            exit();
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Add your custom CSS here -->
</head>
<body>

<?php include 'navigation.php'; ?>

<main>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        <?php if (!empty($successMessage)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="profile-picture-container">
                <?php 
                $profilePicture = !empty($user['profile_picture']) ? 'uploaded_img/' . htmlspecialchars($user['profile_picture']) : 'image/Avatar.png'; 
                ?>
                <img src="<?php echo $profilePicture; ?>" alt="Current Profile Picture" class="profile-picture">
            </div>
            <div ```php
            <div class="profile-field">
                <label for="profile_picture">Choose a new profile picture:</label>
                <input type="file" name="profile_picture" accept="image/jpg, image/jpeg, image/png" id="profile_picture">
            </div>
            <div class="profile-field">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
            </div>
            <div class="profile-field">
                <label for="second_name">Second Name</label>
                <input type="text" name="second_name" id="second_name" value="<?= htmlspecialchars($user['second_name']) ?>" required>
            </div>
            <div class="profile-field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="button-container">
                <button type="button" class="cancel-button" onclick="window.location.href='userprofile.php'">Cancel</button>
                <button type="submit" class="save-button">Save Changes</button>
            </div>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
