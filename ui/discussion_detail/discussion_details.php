<?php
$title = "Discussion Detail";
$css = [
    "../css/styles.css",
    "../css/forum.css",
    "../css/discussion_detail.css"
];
$js = ["../js/discussion_details.js"];

if (!isset($_GET['id'])) {
    header('Location: /forum/discussions');
    exit();
}

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$discussionId = $_GET['id'];

try {
    // Fetch discussion with user info
    $discussion = $db->query(
        "SELECT d.*, u.username 
         FROM discussions d 
         JOIN users u ON d.user_id = u.id 
         WHERE d.id = ?",
        [$discussionId]
    )->fetch();

    if (!$discussion) {
        header('Location: /forum/discussions');
        exit();
    }

    // Fetch comments
    $comments = $db->query(
        "SELECT c.*, u.username 
         FROM comments c 
         JOIN users u ON c.user_id = u.id 
         WHERE c.discussion_id = ? 
         ORDER BY c.date DESC",
        [$discussionId]
    )->fetchAll();

} catch (Exception $e) {
    error_log($e->getMessage());
    header('Location: /forum/discussions');
    exit();
}

require 'discussion_details_view.php';