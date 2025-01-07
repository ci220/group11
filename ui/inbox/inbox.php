<?php

$title = "Notifcations";
$css = [
    "css/styles.css",
    "css/friends.css",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css",
];

$js = [
  "js/friends.js",
];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch pending friend requests
$requests = $db->query(
    "SELECT u.id, u.first_name, u.second_name, u.username, u.profile_picture 
     FROM users u
     JOIN friends f ON u.id = f.user_id
     WHERE f.friend_id = ? AND f.status = 'pending'",
    [$userId]
)->fetchAll();

require 'inbox_view.php';
