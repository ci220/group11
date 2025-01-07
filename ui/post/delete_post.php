<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$data = json_decode(file_get_contents('php://input'), true);
$postId = (int)$data['post_id'];
$userId = $_SESSION['user_id'];

try {
    // Verify ownership
    $post = $db->query(
        "SELECT * FROM posts WHERE id = ? AND user_id = ?",
        [$postId, $userId]
    )->fetch();

    if (!$post) {
        echo json_encode(['success' => false, 'message' => 'Post not found']);
        exit();
    }

    // Delete file
    if (file_exists('uploads/posts/' . $post['media_path'])) {
        unlink('uploads/posts/' . $post['media_path']);
    }

    // Delete post and likes
    $db->query("DELETE FROM post_likes WHERE post_id = ?", [$postId]);
    $db->query("DELETE FROM posts WHERE id = ?", [$postId]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error occurred']);
}
