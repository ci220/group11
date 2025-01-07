<?php

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$errors = [];

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}

// Fetch user ID from session
$userId = $_SESSION['user_id'];
// Prepare and execute the delete statement
$stmt = $db->query('DELETE FROM users WHERE id = ?', [$userId]);

// Destroy the session and redirect to the login page
logout();
?>