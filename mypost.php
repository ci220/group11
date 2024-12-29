<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "railwayforum");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve the logged-in user's ID

// Retrieve posts for the logged-in user
$query = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Error fetching posts: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posts</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        h1 {
            text-align: center;
            padding: 10px 0;
            color: black;
            font-size: 1.8rem;
        }
        .posts-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }
        /* General styling for the post container */
/* Overall post styling */
.post {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 16px;
    margin: 16px 0;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Media styling */
img, video {
    max-width: 100%;
    border-radius: 8px;
    margin-bottom: 16px;
}

/* Description container */
.description-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.edit-btn {
    padding: 6px 12px;
    background-color:rgb(0, 0, 0);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}



/* Action bar styling */
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
    font-size: 14px;
    color: #555;
}

/* Timestamp styling */
.timestamp {
    margin: 0;
    
    color: #999; /* Subtle text color */
}

/* Action buttons (like and delete) */
.action-buttons {
    display: flex;
    gap: 16px; /* Space between like and delete buttons */
}

.like-container, .delete-container {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.like-container i, .delete-container i {
    margin-right: 8px;
}

.like-container i {
    color: #007bff; /* Green for like */
    
}

.delete-container i {
    color: #dc3545; /* Red for delete */
}

.like-container i:hover, .delete-container i:hover {
    opacity: 0.8; /* Slight hover effect */
}

/* Save and cancel buttons in edit mode */
.save-btn, .cancel-btn {
    margin: 8px 4px 0;
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.save-btn {
    background-color: #28a745;
    color: white;
}

.cancel-btn {
    background-color: #dc3545;
    color: white;
}




    </style>
</head>
<body>
<?php include 'navigation.php'; ?>
<div class="container">
    <h1>My Posts</h1>
    <?php if ($result->num_rows > 0): ?>
        <div class="posts-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
    <!-- Display image or video -->
    <?php if (strpos($row['media_type'], 'image') !== false): ?>
        <img src="data:<?php echo $row['media_type']; ?>;base64,<?php echo base64_encode($row['media']); ?>" alt="Post Image">
    <?php elseif (strpos($row['media_type'], 'video') !== false): ?>
        <video controls>
            <source src="data:<?php echo $row['media_type']; ?>;base64,<?php echo base64_encode($row['media']); ?>" type="<?php echo $row['media_type']; ?>">
        </video>
    <?php endif; ?>

    <!-- Description container -->
    <div class="description-container">
        <p class="description" id="description-<?php echo $row['id']; ?>">
            <?php echo htmlspecialchars($row['description']); ?>
        </p>
        <button class="edit-btn" onclick="editDescription(<?php echo $row['id']; ?>)">Edit</button>
    </div>

    <!-- Edit description -->
    <div class="edit-description-container" id="edit-container-<?php echo $row['id']; ?>" style="display: none;">
        <textarea id="edit-description-<?php echo $row['id']; ?>" rows="3" cols="50"><?php echo htmlspecialchars($row['description']); ?></textarea>
        <button class="save-btn" onclick="saveDescription(<?php echo $row['id']; ?>)">Save</button>
        <button class="cancel-btn" onclick="cancelEdit(<?php echo $row['id']; ?>)">Cancel</button>
    </div>

    <!-- Like, Delete, and Timestamp container -->
    <div class="action-bar">
        <p class="timestamp"><?php echo date("F j, Y, g:i a", strtotime($row['created_at'])); ?></p>
        <div class="action-buttons">
            <div class="like-container">
                <i class="fas fa-thumbs-up"></i>
                <span id="like-count-<?php echo $row['id']; ?>"><?php echo $row['likes']; ?></span>
            </div>
            <div class="delete-container">
                <i class="fas fa-trash" onclick="deletePost(<?php echo $row['id']; ?>)"></i>
            </div>
        </div>
    </div>
</div>

            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="text-align: center; padding: 20px;">No posts found. Create your first post!</p>
    <?php endif; ?>
</div>

<script>
    function likePost(postId) {
        fetch('like_post.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId: postId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeCount = document.getElementById(`like-count-${postId}`);
                likeCount.textContent = data.likes;
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    function deletePost(postId) {
        if (confirm('Are you sure you want to delete this post?')) {
            fetch('delete_post.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ postId: postId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Post deleted successfully!');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
    function editDescription(postId) {
    // Hide the description and show the edit container
    document.getElementById(`description-${postId}`).style.display = 'none';
    document.getElementById(`edit-container-${postId}`).style.display = 'block';
}

function cancelEdit(postId) {
    // Hide the edit container and show the description
    document.getElementById(`edit-container-${postId}`).style.display = 'none';
    document.getElementById(`description-${postId}`).style.display = 'block';
}

function saveDescription(postId) {
    const newDescription = document.getElementById(`edit-description-${postId}`).value;

    fetch('edit_description.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ postId: postId, description: newDescription })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the description in the UI
            document.getElementById(`description-${postId}`).textContent = newDescription;
            // Hide the edit container and show the updated description
            document.getElementById(`edit-container-${postId}`).style.display = 'none';
            document.getElementById(`description-${postId}`).style.display = 'block';
        } else {
            alert('Failed to update the description.');
        }
    })
    .catch(error => console.error('Error:', error));
}


</script>
<?php include 'footer.php'; ?>
</body>
</html>
