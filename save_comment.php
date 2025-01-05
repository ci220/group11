<?php
session_start();

// Database connection
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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    $discussionId = $_POST['discussion_id'];
    $userId = $_SESSION['user_id']; // Get the user ID from session
    $commentId = $_POST['comment_id'] ?? null; // Check if it's an update

    // Validate comment content
    if (empty($content)) {
        echo "Comment content cannot be empty.";
        exit();
    }

    try {
        if ($commentId) {
            // Update existing comment
            $stmt = $pdo->prepare("UPDATE comments SET content = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$content, $commentId, $userId]);
            header("Location: discussion-detail.php?id=$discussionId"); // Redirect back to the discussion
        } else {
            // Insert new comment
            $stmt = $pdo->prepare("INSERT INTO comments (content, user_id, discussion_id) VALUES (?, ?, ?)");
            $stmt->execute([$content, $userId, $discussionId]);
            header("Location: discussion-detail.php?id=$discussionId"); // Redirect back to the discussion
        }
    } catch (PDOException $e) {
        echo "Error saving comment: " . $e->getMessage();
    }
}
?>
