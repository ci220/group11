
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
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<body>
 
    <?php include 'navigation.php'; ?>


    <!-- Main Content -->
    <main class="flex-grow pt-16 pb-16">
        <div class="container w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-4">
            <h1 class="text-2xl font-semibold mb-4 text-gray-800">Create Post</h1>
            <form action="create_post.php" method="POST" enctype="multipart/form-data">
                <div class="upload-box border-2 border-dashed border-gray-300 rounded-lg p-4 mb-4 text-center">
                    <label class="block text-gray-600 mb-2" for="media">Add photo/video from device</label>
                    <div class="relative inline-block">
                        <input accept="image/jpeg, image/png, video/mp4" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="media" name="media" required="" type="file" onchange="previewFile()"/>
                        <button type="button" class="bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75">Choose File</button>
                    </div>
                    <div id="file-name" class="mt-2 text-gray-600"></div>
                    <div id="preview" class="mt-4"></div>
                </div>
                <textarea class="w-full border border-gray-300 rounded-lg p-2 mb-4 text-gray-800" name="description" placeholder="Add description..." required=""></textarea>
                <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600" type="submit">POST</button>
            </form>
        </div>
    </main>

    <!-- Fixed Footer -->
  
    <?php include 'footer.php'; ?>


    <script>
        function previewFile() {
            const preview = document.getElementById('preview');
            const fileName = document.getElementById('file-name');
            const file = document.getElementById('media').files[0];
            const reader = new FileReader();

            fileName.textContent = file ? file.name : '';

            reader.addEventListener("load", function () {
                if (file.type.startsWith('image/')) {
                    preview.innerHTML = `<img src="${reader.result}" alt="Preview" class="w-full h-auto rounded-lg"/>`;
                } else if (file.type.startsWith('video/')) {
                    preview.innerHTML = `<video controls class="w-full h-auto rounded-lg"><source src="${reader.result}" type="${file.type}">Your browser does not support the video tag.</video>`;
                } else {
                    preview.innerHTML = `<p class="text-gray-600">File preview not available</p>`;
                }
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
