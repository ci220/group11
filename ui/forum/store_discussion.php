<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /forum/create');
    exit();
}

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to create a discussion');
    header('Location: /login');
    exit();
}

$config = require(basePath('config.php'));
$db = new Database($config['database']);

function uploadImage($file, $folder) {
    // Validate file size (10MB max)
    if ($file['size'] > 10 * 1024 * 1024) {
        return ['success' => false, 'error' => 'File size must be less than 2MB'];
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_types)) {
        return ['success' => false, 'error' => 'Only JPG and PNG files are allowed'];
    }

    // Create unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    
    // Create upload directory if it doesn't exist
    $upload_dir = basePath("public/uploads/$folder");
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $filepath = "$upload_dir/$filename";

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return [
            'success' => true, 
            'path' => "/uploads/$folder/$filename"
        ];
    }

    return ['success' => false, 'error' => 'Failed to upload file'];
}

$errors = [];
$category = $_POST['category'];
$title = trim($_POST['title']);
$content = trim($_POST['content']);

// Validate input
if (empty($category)) $errors[] = 'Category is required';
if (empty($title)) $errors[] = 'Title is required';
if (strlen($content) < 20) $errors[] = 'Content must be at least 20 characters';

// Handle image upload if present
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $result = uploadImage($_FILES['image'], 'forum');
    if ($result['success']) {
        $image_path = $result['path'];
    } else {
        $errors[] = $result['error'];
    }
}

if (!empty($errors)) {
    $_SESSION['_flash']['error'] = implode(', ', $errors);
    $_SESSION['_flash']['old'] = $_POST;
    header('Location: /forum/create');
    exit();
}

try {
    $db->query(
        "INSERT INTO discussions (category, title, content, date, user_id, image_path) 
         VALUES (?, ?, ?, NOW(), ?, ?)",
        [$category, $title, $content, $_SESSION['user_id'], $image_path]
    );

    setFlash('success', 'Discussion created successfully!');
    header('Location: /forum/discussions');
} catch (Exception $e) {
    error_log($e->getMessage());
    setFlash('error', 'An error occurred while creating the discussion');
    header('Location: /forum/create');
}