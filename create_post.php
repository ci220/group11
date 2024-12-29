
<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "railwayforum");


// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $description = $_POST['description'];
    $media = file_get_contents($_FILES['media']['tmp_name']);
    $media_type = $_FILES['media']['type'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, media, media_type, description) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("isss", $user_id, $media, $media_type, $description);
   
    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error);
    }

    echo "Post created successfully!";
    header('Location: posting.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
</head>

<body>
<?php include 'navigation.php'; ?>
    <div class="container">
        <h1>Create Post</h1>
        <form action="create_post.php" method="POST" enctype="multipart/form-data">
            <div class="upload-box">
                <label for="media">Add photo/video from device</label>
                <input type="file" name="media" id="media" accept="image/jpeg, image/png, video/mp4" required>
            </div>
            <textarea name="description" placeholder="Add description..." required></textarea>
            <button type="submit">POST</button>
        </form>
    </div>
    <!-- Footer Extension-->
    <?php include 'footer.php'; ?>

    
    <script src="js/script.js"></script>
    <script src="js/components.js"></script>
</body>
</html>



