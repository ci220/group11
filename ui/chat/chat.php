<?php
$title = "Chat";
$css = [
    "css/styles.css",
    "css/chat.css"
];
$js = ["js/chat.js"];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch friends list
$friends = $db->query(
    "SELECT u.id, u.username, u.profile_picture 
     FROM users u 
     JOIN friends f ON (f.friend_id = u.id OR f.user_id = u.id)
     WHERE f.status = 'accepted' 
     AND (f.user_id = ? OR f.friend_id = ?)
     AND u.id != ?",
    [$userId, $userId, $userId]
)->fetchAll();

require 'chat_view.php';