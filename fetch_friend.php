<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['friend_id'])) {
    exit();
}

$friend_id = $_GET['friend_id'];

// Fetch friend's username
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :friend_id");
$stmt->execute([':friend_id' => $friend_id]);
$friend = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($friend);