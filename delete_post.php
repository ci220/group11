<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "railwayforum");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'];
$user_id = $_SESSION['user_id']; // The logged-in user ID

// Ensure the user is the one who created the post
$query = "SELECT user_id FROM posts WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if ($post['user_id'] === $user_id) {
    // Delete the post
    $deleteQuery = "DELETE FROM posts WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $postId);

    if ($deleteStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting post']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'You cannot delete this post']);
}

$conn->close();
?>
