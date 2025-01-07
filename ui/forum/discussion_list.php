<?php
$title = "Forum Categories";
$css = [
    "../css/styles.css",
    "../css/forum.css"
];


$config = require(basePath('config.php'));
$db = new Database($config['database']);

// Handle filters
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'latest';
$orderQuery = $order === 'oldest' ? 'ASC' : 'DESC';

try {
    if ($category) {
        $discussions = $db->query(
            "SELECT d.*, u.username 
             FROM discussions d 
             JOIN users u ON d.user_id = u.id 
             WHERE d.category = ? AND d.title LIKE ? 
             ORDER BY d.date $orderQuery",
            [$category, "%$search%"]
        )->fetchAll();
    } else {
        $discussions = $db->query(
            "SELECT d.*, u.username 
             FROM discussions d 
             JOIN users u ON d.user_id = u.id 
             WHERE d.title LIKE ? 
             ORDER BY d.date $orderQuery",
            ["%$search%"]
        )->fetchAll();
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    $discussions = [];
}

require 'discussion_list_view.php';