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

$action = $_POST['action'] ?? '';
$friendId = (int)$_POST['friend_id'];
$userId = $_SESSION['user_id'];

try {
    switch ($action) {
        case 'accept':
            // Accept friend request
            $db->query(
                "UPDATE friends SET status = 'accepted' 
                 WHERE user_id = ? AND friend_id = ?",
                [$friendId, $userId]
            );
            echo json_encode(['success' => true, 'message' => 'Friend request accepted']);
            break;

        case 'decline':
            // Decline friend request
            $db->query(
                "DELETE FROM friends 
                 WHERE user_id = ? AND friend_id = ?",
                [$friendId, $userId]
            );
            echo json_encode(['success' => true, 'message' => 'Friend request declined']);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}