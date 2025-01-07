<?php
$title = "My Friends";
$css = [
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css",
    "../css/styles.css",
    "../css/friends.css"
];

$js = [
    "../js/friends.js",
];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}

// Get search query if exists
$search = $_GET['search'] ?? '';

// Fetch friends with optional search
$query = "SELECT u.id, u.username, u.first_name, u.second_name, u.profile_picture 
          FROM users u
          JOIN friends f ON (f.friend_id = u.id OR f.user_id = u.id)
          WHERE f.status = 'accepted' 
          AND (f.user_id = ? OR f.friend_id = ?)
          AND u.id != ?";

$params = [$_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id']];

if ($search) {
    $query .= " AND (u.username LIKE ? OR u.first_name LIKE ? OR u.second_name LIKE ?)";
    $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
}

$friends = $db->query($query, $params)->fetchAll();

require 'friends_list_view.php';
