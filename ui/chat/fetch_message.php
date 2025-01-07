<?php
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['friend_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit();
}

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$messages = $db->query(
    "SELECT * FROM messages 
     WHERE (sender_id = ? AND receiver_id = ?) 
     OR (sender_id = ? AND receiver_id = ?) 
     ORDER BY sent_at ASC",
    [$_SESSION['user_id'], $_GET['friend_id'], $_GET['friend_id'], $_SESSION['user_id']]
)->fetchAll();

echo json_encode($messages);