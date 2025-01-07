<?php
header('Content-Type: application/json');

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$friendId = (int)$data['friend_id'];
$message = trim($data['message']);
$userId = $_SESSION['user_id'];

try {
    // Verify friendship exists
    $friendship = $db->query(
        "SELECT * FROM friends 
         WHERE ((user_id = ? AND friend_id = ?) 
         OR (user_id = ? AND friend_id = ?))
         AND status = 'accepted'",
        [$userId, $friendId, $friendId, $userId]
    )->fetch();

    if (!$friendship) {
        echo json_encode(['success' => false, 'message' => 'Not friends']);
        exit();
    }

    // Insert message
    $db->query(
        "INSERT INTO messages (sender_id, receiver_id, body) 
         VALUES (?, ?, ?)",
        [$userId, $friendId, $message]
    );

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error occurred']);
}