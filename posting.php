<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "railwayforum");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all posts along with usernames
$query = "SELECT posts.*, users.username FROM posts 
          JOIN users ON posts.user_id = users.id 
          ORDER BY posts.id DESC";
$result = $conn->query($query);

session_start();
$userId = $_SESSION['user_id']; // Assuming user_id is stored in the session


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }
        .posts-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }
        .post {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .post img, .post video {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 16px;
        }
 
        .description {
            font-size: 1.1rem;
            line-height: 1.4;
            color: #444;
            text-align: left;
        }
        .timestamp {
            font-size: 0.88rem;
            color: #888;
        
        }
        
        /* Username styling */
        .username {
            font-family: 'Arial', sans-serif; /* Change to a clean, professional font */
            font-size: 16px; /* Slightly larger for emphasis */
            font-weight: bold; /* Make it stand out */
            color: black; /* Black color for the username */
            text-decoration: none; /* Remove underline */
        }
        .actions {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1rem;
        }
        .like-btn {
            background: #007BFF;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }   
          .like-count {
            font-size: 1rem;
            color: #333;
        }
        .like-btn, .like-count {
            display: flex;
            align-items: center;
        }
        
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>
<div class="container">
    <h1>All Posts</h1>
    <div class="posts-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <!-- Display username -->
                <div class="user-info">
                <a href="user_profile.php?id=<?php echo $row['user_id']; ?>" class="username">
                    <?php echo htmlspecialchars($row['username']); ?>
                </a>
                </div>
                <p class="timestamp"><?php echo date("F j, Y, g:i a", strtotime($row['created_at'])); ?></p>

                <!-- Display image or video -->
                <?php if (strpos($row['media_type'], 'image') !== false): ?>
                    <img src="data:<?php echo $row['media_type']; ?>;base64,<?php echo base64_encode($row['media']); ?>" alt="Post Image">
                <?php elseif (strpos($row['media_type'], 'video') !== false): ?>
                    <video controls>
                        <source src="data:<?php echo $row['media_type']; ?>;base64,<?php echo base64_encode($row['media']); ?>" type="<?php echo $row['media_type']; ?>">
                    </video>
                <?php endif; ?>

                <!-- Display description and timestamp -->
                <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>

                <!-- Actions (Like button and count) -->
                <div class="actions">
                    <!-- Like button -->
                    <div class="like-btn" onclick="likePost(<?php echo $row['id']; ?>)">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <!-- Like count -->
                    <span id="like-count-<?php echo $row['id']; ?>" class="like-count"><?php echo $row['likes']; ?> Likes</span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
    // Function to handle liking a post
    function likePost(postId) {
        const likeCountSpan = document.getElementById(`like-count-${postId}`);
        
        fetch('like_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ postId: postId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                likeCountSpan.textContent = `${data.likes} Likes`; // Update like count
            } else {
                alert('1 account, only 1 Like');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
<?php include 'footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
