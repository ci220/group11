<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$friendId = (int)$_POST['friend_id'];
$userId = $_SESSION['user_id'];

try {
    // Remove friend relationship
    $db->query(
        "DELETE FROM friends 
         WHERE (user_id = ? AND friend_id = ?) 
         OR (user_id = ? AND friend_id = ?)",
        [$userId, $friendId, $friendId, $userId]
    );

    echo json_encode(['success' => true, 'message' => 'Friend removed successfully']);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}