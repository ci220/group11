<?php
session_start();
$conn = new mysqli("localhost", "root", "", "railwayforum");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'];
$userId = $_SESSION['user_id']; // Assuming user_id is stored in the session

// Check if the user has already liked the post
$result = $conn->query("SELECT * FROM post_likes WHERE user_id = $userId AND post_id = $postId");
if ($result->num_rows > 0) {
    // User has already liked this post
    echo json_encode(['success' => false, 'message' => 'You have already liked this post.']);
    exit;
}

// Insert into post_likes table
$stmt = $conn->prepare("INSERT INTO post_likes (user_id, post_id) VALUES (?, ?)");
$stmt->bind_param("ii", $userId, $postId);
$stmt->execute();

// Increment the like count in the posts table
$conn->query("UPDATE posts SET likes = likes + 1 WHERE id = $postId");

// Fetch the updated like count
$likeResult = $conn->query("SELECT likes FROM posts WHERE id = $postId");
$likeRow = $likeResult->fetch_assoc();

echo json_encode(['success' => true, 'likes' => $likeRow['likes']]);

$conn->close();
?>
