<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$content = trim($_POST['content']);
$discussionId = (int)$_POST['discussion_id'];
$commentId = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : null;
$userId = $_SESSION['user_id'];

try {
    if ($commentId) {
        // Edit existing comment
        $comment = $db->query(
            "SELECT * FROM comments WHERE id = ? AND user_id = ?",
            [$commentId, $userId]
        )->fetch();

        if (!$comment) {
            echo json_encode(['success' => false, 'message' => 'Comment not found']);
            exit();
        }

        $db->query(
            "UPDATE comments SET content = ? WHERE id = ?",
            [$content, $commentId]
        );
    } else {
        // Create new comment
        $db->query(
            "INSERT INTO comments (discussion_id, user_id, content, date) 
             VALUES (?, ?, ?, NOW())",
            [$discussionId, $userId, $content]
        );
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error occurred']);
}