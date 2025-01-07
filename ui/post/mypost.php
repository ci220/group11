<?php
$title = "My Posts";
$css = [
    "css/styles.css",
    "css/post.css",
];
$js = ["js/post.js"];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch posts with like counts
$posts = $db->query(
    "SELECT p.*, 
            (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) as like_count,
            (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id AND user_id = ?) as user_liked
     FROM posts p 
     WHERE p.user_id = ? 
     ORDER BY p.created_at DESC",
    [$userId, $userId]
)->fetchAll();

require 'mypost_view.php';