<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['friend_id'])) {
    exit();
}

$current_user = $_SESSION['user_id'];
$friend_id = $_GET['friend_id'];

// Check if the friendship already exists
$stmt = $pdo->prepare("SELECT * FROM friends WHERE user_id = :user_id AND friend_id = :friend_id");
$stmt->execute([':user_id' => $current_user, ':friend_id' => $friend_id]);

if ($stmt->rowCount() == 0) {
    // Add friendship
    $insert = $pdo->prepare("INSERT INTO friends (user_id, friend_id) VALUES (:user_id, :friend_id)");
    $insert->execute([':user_id' => $current_user, ':friend_id' => $friend_id]);
}

// Fetch friend's username
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :friend_id");
$stmt->execute([':friend_id' => $friend_id]);
$friend = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($friend);
?>
