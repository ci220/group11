<?php
// Start session to track user login
session_start();

// Connect to the database
$host = 'localhost';
$dbname = 'railwayforum';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Get the logged-in user's ID
        $user_id = $_SESSION['user_id'];

        // Get the form data
        $category = $_POST['category'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $date = date('Y-m-d H:i:s'); // Current date and time
        $image_path = NULL;
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/'; // Directory to store images
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
            }

            $image_name = basename($_FILES['image']['name']);
            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $allowed_exts = ['jpg', 'jpeg', 'png'];

            if (in_array(strtolower($image_ext), $allowed_exts)) {
                $new_image_name = uniqid('img_', true) . '.' . $image_ext;
                $target_path = $upload_dir . $new_image_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $image_path = $target_path;
                } else {
                    $error = "Failed to upload the image. Please try again.";
                }
            } else {
                $error = "Invalid image format. Only JPG, JPEG, and PNG are allowed.";
            }
        }
        
        // Validate form input
        if (!empty($category) && !empty($title) && !empty($content) && strlen($content) >= 20) {
            // Insert the discussion into the database, including the user_id
            $stmt = $pdo->prepare("INSERT INTO discussions (category, title, content, date, user_id, image_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$category, $title, $content, $date, $user_id, $image_path]);

            $success = "Your discussion has been successfully posted!";
        } else {
            $error = "All fields are required, and content must be at least 20 characters.";
        }

    } else {
        // If the user is not logged in, redirect to login page
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Discussion</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        @font-face {
            font-family: 'Times';
            src: url('font/Times.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>

<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #f4f4f4;
    }

    main {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 20px auto;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    /* Layout: Form container with two columns */
    .form-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        align-items: start;
    }

    /* Form Fields */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-description {
        font-size: 14px;
        color: gray;
        margin-bottom: 10px;
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    /* Right Column - Upload Box */
    .image-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .upload-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 250px; /* Increased width */
    height: 250px; /* Increased height */
    border: 2px dashed #ccc;
    border-radius: 10px;
    cursor: pointer;
    margin: 10px 0;
    text-align: center;
    position: relative; /* Added for image placement */
    overflow: hidden; /* Prevents image overflow */
    transition: border-color 0.2s, background-color 0.2s;
}

.upload-box:hover {
    border-color: #007bff;
    background-color: #f0f8ff;
}

.upload-box img {
    position: absolute; /* Position image inside the box */
    top: 0;
    left: 0;
    width: 100%; /* Fit image inside the box */
    height: 100%;
    object-fit: cover; /* Ensure image is scaled proportionally */
    z-index: 1;
    display: none; /* Initially hidden */
}


    .upload-box span {
        font-size: 36px;
        color: #007bff;
        line-height: 1;
    }

    .upload-box p {
        font-size: 14px;
        color: #555;
    }

    /* Image Preview */
    #imagePreview {
        display: none;
        margin-top: 10px;
        max-width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        background-color: #0056b3;
    }

    .message {
        text-align: center;
        margin: 10px 0;
        padding: 10px;
        border-radius: 5px;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error-message {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

</head>
<body>
<?php include 'navigation.php'; ?>

<main>
    <h1>Let’s Discuss!</h1>
    <?php if (!empty($success)): ?>
        <p class="message success"><?= $success ?></p>
        <a href="discussion-list.php" style="text-align: center; display: block; margin-top: 15px; color: #007bff;">View Your Post</a>
    <?php endif; ?>

    <form action="create-discussion.php" method="POST" enctype="multipart/form-data">
        <div class="form-container">
            <!-- Left Column -->
            <div>
                <div class="form-group">
                    <label for="category">Categories</label>
                    <select id="category" name="category" required>
                        <option value="">-- Select Category --</option>
                        <option value="Train Operations">Train Operations</option>
                        <option value="Stations">Stations</option>
                        <option value="Road Planning">Road Planning</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <p class="form-description">Be specific and imagine you’re asking a question to another person.</p>
                    <input type="text" id="title" name="title" placeholder="Enter the title" required>
                </div>
                <div class="form-group">
                    <label for="content">What are the details of your problem?</label>
                    <p class="form-description">Introduce the problem and expand on what you put in the title. Minimum 20 characters.</p>
                    <textarea id="content" name="content" rows="5" placeholder="Describe your problem..." required></textarea>
                </div>
            </div>

            <!-- Right Column -->
            <div class="image-upload">
            <div class="form-group">
    <label for="image">Upload a Picture (Optional)</label>
    <p class="form-description">Accepted formats: JPG, JPEG, PNG (Max size: 2MB).</p>
    <label for="image-upload-box" class="upload-box">
        <span class="upload-icon">+</span>
        <p class="upload-text">Upload Here</p>
        <img id="imagePreview" alt="Preview">
        <input type="file" id="image-upload-box" name="image" accept="image/png, image/jpeg" style="display: none;">
    </label>
</div>

    <button type="submit">Post</button>
</div>

        </div>

        <?php if (!empty($error)): ?>
            <p class="message error-message"><?= $error ?></p>
        <?php endif; ?>
    </form>
</main>

<script>
    document.getElementById('image-upload-box').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const uploadBox = document.querySelector('.upload-box');

    // Validate the file type
    if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Show the preview
            uploadBox.style.border = 'none'; // Remove dashed border when an image is uploaded
        };

        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none'; // Hide the preview if invalid file type
        alert('Please upload a valid image (JPG or PNG format).');
    }
});

</script>

<!-- Footer Extension-->
<?php include 'footer.php'; ?>
</body>
</html>
