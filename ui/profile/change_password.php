<?php
$title = "Change Password";
$css = ["../css/styles.css"];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $currentPassword = trim($_POST['current_password']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Fetch current user password
    $user = $db->query("SELECT password FROM users WHERE id = ?", 
        [$userId])->fetch();

    $errors = [];

    if (!password_verify($currentPassword, $user['password'])) {
        $errors[] = 'Current password is incorrect.';
    }
    if (strlen($newPassword) < 8) {
        $errors[] = 'New password must be at least 8 characters long.';
    }
    if ($newPassword !== $confirmPassword) {
        $errors[] = 'New password and confirmation do not match.';
    }

    if (empty($errors)) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $db->query("UPDATE users SET password = ? WHERE id = ?", 
                [$hashedPassword, $userId]);

            setFlash('success', 'Password changed successfully.');
            header('Location: /profile');
            exit();
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'Failed to update password. Please try again.';
        }
    }

    if (!empty($errors)) {
        setFlash('error', implode('<br>', $errors));
        header('Location: /profile/change-password');
        exit();
    }
}

require 'change_password_view.php';