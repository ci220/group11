<?php
$title = "Search Users";
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

$search = $_GET['search'] ?? '';
$users = [];

if ($search) {
    $users = $db->query(
        "SELECT u.*, 
                (SELECT status FROM friends 
                 WHERE (user_id = ? AND friend_id = u.id)
                 OR (user_id = u.id AND friend_id = ?)
                ) as friend_status
         FROM users u 
         WHERE (first_name LIKE ? OR second_name LIKE ? OR username LIKE ?) 
         AND id != ?",
        [
        $_SESSION['user_id'], 
        $_SESSION['user_id'], 
         "%$search%", 
         "%$search%", 
         "%$search%", 
         $_SESSION['user_id']
         ]
    )->fetchAll();

}

require 'search_users_view.php';