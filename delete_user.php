<?php
session_start();
include 'database.php'; // Include database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user ID from session
$userId = $_SESSION['user_id'];

// Prepare and execute the delete statement
$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
$stmt->execute([$userId]);

// Destroy the session and redirect to the login page
session_destroy();
header('Location: login.php?message=Account deleted successfully.');
exit();
?>