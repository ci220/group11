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

if ($userId == $friendId) {
    echo json_encode(['success' => false, 'message' => 'You cannot add yourself as a friend']);
    exit();
}

try {
    switch ($action) {
        case 'add':
            // Check if a friend request already exists
            $existing = $db->query(
                "SELECT * FROM friends 
                 WHERE (user_id = ? AND friend_id = ?) 
                 OR (user_id = ? AND friend_id = ?)",
                [$userId, $friendId, $friendId, $userId]
            )->fetch();

            if ($existing) {
                if ($existing['status'] === 'pending') {
                    echo json_encode(['success' => false, 'message' => 'Friend request already sent']);
                } elseif ($existing['status'] === 'accepted') {
                    echo json_encode(['success' => false, 'message' => 'You are already friends']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Friend request already exists']);
                }
                exit();
            }

            // Create a new friend request with 'pending' status
            $db->query(
                "INSERT INTO friends (user_id, friend_id, status, created_at) 
                 VALUES (?, ?, 'pending', NOW())",
                [$userId, $friendId]
            );

            echo json_encode(['success' => true, 'message' => 'Friend request sent!']);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}
