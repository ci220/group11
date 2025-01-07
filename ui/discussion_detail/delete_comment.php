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

$data = json_decode(file_get_contents('php://input'), true);
$commentId = (int)$data['comment_id'];
$userId = $_SESSION['user_id'];

try {
    // Verify comment ownership
    $comment = $db->query(
        "SELECT * FROM comments WHERE id = ? AND user_id = ?",
        [$commentId, $userId]
    )->fetch();

    if (!$comment) {
        echo json_encode(['success' => false, 'message' => 'Comment not found']);
        exit();
    }

    // Delete the comment
    $db->query(
        "DELETE FROM comments WHERE id = ?",
        [$commentId]
    );

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error occurred']);
}