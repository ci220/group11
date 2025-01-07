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
    // Check if already liked
    $exists = $db->query(
        "SELECT id FROM post_likes WHERE user_id = ? AND post_id = ?",
        [$userId, $postId]
    )->fetch();

    if ($exists) {
        echo json_encode(['success' => false, 'message' => 'Already liked']);
        exit();
    }

    // Add like
    $db->query(
        "INSERT INTO post_likes (user_id, post_id) VALUES (?, ?)",
        [$userId, $postId]
    );

    // Get updated count
    $likes = $db->query(
        "SELECT COUNT(*) as count FROM post_likes WHERE post_id = ?",
        [$postId]
    )->fetch();

    echo json_encode(['success' => true, 'likes' => $likes['count']]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error occurred']);
}
