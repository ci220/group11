<?php

$title = "Find Friends";
$css = [
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css",
    "../css/styles.css",
    "../css/friends.css",
];
$js = [
    "js/friends.js",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

$search = '';
$users = [];

// Fetch users based on search query
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $db->query(
        "SELECT id, first_name, second_name, username, profile_picture 
         FROM users 
         WHERE (first_name LIKE ? OR second_name LIKE ? OR username LIKE ?) 
         AND id != ?",
        ["%$search%", "%$search%", "%$search%", $_SESSION['user_id']]
    );
    $users = $stmt->fetchAll();
}

require 'find_friends_view.php';
