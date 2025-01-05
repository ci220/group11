<?php
session_start();
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

// Check if user is authorized to delete the comment
if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $commentId = $_GET['id'];
    $userId = $_SESSION['user_id'];
    $discussionId = $_GET['discussion_id'];

    // Verify comment ownership
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ? AND user_id = ?");
    $stmt->execute([$commentId, $userId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment) {
        // Delete comment
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$commentId]);
    }
}

header("Location: discussion-detail.php?id=" . $discussionId);
exit;
