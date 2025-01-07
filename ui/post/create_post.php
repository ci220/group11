
<?php
$title = "Create Post";
$css = [
    "../css/styles.css",
];

$js = [
  "../js/script.js",
  "../js/components.js",
  "../js/previewFile.js"
];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $userId = $_SESSION['user_id'];
    $description = trim($_POST['description']);

    // Validate description
    if (empty($description)) {
        $errors[] = 'Description is required';
    }

    // Validate and handle file upload
    if (!isset($_FILES['media']) || $_FILES['media']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Media file is required';
    } else {
        $allowedTypes = ['image/jpeg', 'image/png', 'video/mp4'];
        if (!in_array($_FILES['media']['type'], $allowedTypes)) {
            $errors[] = 'Invalid file type. Only JPG, PNG, or MP4 allowed.';
        }
        if ($_FILES['media']['size'] > 10000000) { // 10MB limit
            $errors[] = 'File too large. Maximum size is 10MB.';
        }
    }

    if (empty($errors)) {
        try {
            // Handle file upload
            $ext = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
            $newFileName = 'post_' . uniqid() . '.' . $ext;
            $uploadDir = 'uploads/posts/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadPath)) {
                // Insert post into database
                $db->query(
                    "INSERT INTO posts (user_id, media_path, media_type, description) 
                     VALUES (?, ?, ?, ?)",
                    [$userId, $newFileName, $_FILES['media']['type'], $description]
                );

                setFlash('success', 'Post created successfully!');
                sleep(2);
                header('Location: /mypost');
                exit();
            } else {
                $errors[] = 'Failed to upload file';
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'An error occurred while creating the post';
        }
    }

    if (!empty($errors)) {
        setFlash('error', implode(', ', $errors));
        $_SESSION['_flash']['old'] = $_POST;
        header('Location: /post/create');
        exit();
    }
}

require 'create_post_view.php';