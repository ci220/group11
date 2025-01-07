<?php
session_start();
include 'database.php'; // Include database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Initialize error message variable
$errorMessage = '';
$successMessage = '';

// Fetch user data
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = trim($_POST['current_password']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (!password_verify($currentPassword, $user['password'])) {
        $errorMessage = 'Current password is incorrect.';
    } elseif (strlen($newPassword) < 8) {
        $errorMessage = 'New password must be at least 8 characters long.';
    } elseif ($newPassword !== $confirmPassword) {
        $errorMessage = 'New password and confirmation do not match.';
    } else {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        if ($stmt->execute([$hashedPassword, $userId])) {
            // Set success message to be displayed
            $successMessage = 'Password changed successfully.';
            // Redirect to user profile with alert
            echo "<script>
                    alert('$successMessage');
                    window.location.href = 'userprofile.php';
                  </script>";
            exit();
        } else {
            $errorMessage = 'Failed to change password. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Add your custom CSS here -->
</head>
<body>

<?php include 'navigation.php'; ?>

<main>
    <div class="change-password-container">
        <h2>Change Password</h2>
        
        <?php if (!empty($errorMessage)): ?>
            <div class="error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <div class="button-container">
                <button type="button" class="cancel-button" onclick="window.location.href='userprofile.php'">Cancel</button>
                <button type="submit" class="save-button">Save Changes</button>  
            </div>     
        </form>
    </div>
</main>
</body>
</html>

