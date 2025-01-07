<?php
$title = "All Posts";
$css = [
    "css/styles.css",
    "css/post.css"
];
$js = ["js/post.js"];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}

// Fetch all posts with user info and like counts
$posts = $db->query(
    "SELECT p.*, u.username, 
            (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) as like_count,
            (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id AND user_id = ?) as user_liked
     FROM posts p 
     JOIN users u ON p.user_id = u.id 
     ORDER BY p.created_at DESC",
    [$_SESSION['user_id']]
)->fetchAll();

require 'post_view.php';