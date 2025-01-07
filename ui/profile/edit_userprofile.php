<?php
$title = 'Edit Profile';
$css = ["../css/styles.css"];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

// Check login
if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Login to proceed');
    header('Location: /login');
    exit();
}

// Fetch user data
$userId = $_SESSION['user_id'];
$user = $db->query(
    'SELECT first_name, second_name, username, email, profile_picture 
     FROM users WHERE id = ?', 
    [$userId]
)->fetch();

if (!$user) {
    setFlash('error', 'User not found');
    header('Location: /profile');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Validate inputs
    $firstName = trim($_POST['first_name']);
    $secondName = trim($_POST['second_name']); 
    $email = trim($_POST['email']);

    if (empty($firstName)) {
        $errors[] = 'First name required';
    }
    if (empty($secondName)) {
        $errors[] = 'Second name required';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['profile_picture']['type'], $allowedTypes)) {
            $errors[] = 'Invalid file type. JPG/PNG only.';
        }
        if ($_FILES['profile_picture']['size'] > 5000000) {
            $errors[] = 'File too large. Max 5MB.';
        }
    }

    if (empty($errors)) {
        try {
            // Update user info
            $db->query(
                'UPDATE users SET first_name = ?, second_name = ?, email = ? WHERE id = ?',
                [$firstName, $secondName, $email, $userId]
            );

            // Handle profile picture if uploaded
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                $newFileName = 'profile_' . uniqid() . '.' . $ext;
                $uploadPath = 'uploads/images/profile/' . $newFileName;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
                    // Update profile picture in DB
                    $db->query(
                        'UPDATE users SET profile_picture = ? WHERE id = ?',
                        [$newFileName, $userId]
                    );
                }
            }

            setFlash('success', 'Profile updated successfully');
            header('Location: /profile');
            exit();

        } catch (PDOException $e) {
            $errors[] = 'Database error occurred';
            error_log($e->getMessage());
        }
    }

    // If there were errors, store them and redirect back
    if (!empty($errors)) {
        setFlash('error', implode(', ', $errors));
        $_SESSION['_flash']['old'] = $_POST;
        header('Location: /profile/edit');
        exit();
    }
}

require 'edit_userprofile_view.php';