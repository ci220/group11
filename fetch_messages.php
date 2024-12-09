<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['friend_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];
$friend_id = $_GET['friend_id'];

$sql = "SELECT m.sender_id, m.receiver_id, m.body, m.sent_at
        FROM messages m
        WHERE (m.sender_id = :user_id AND m.receiver_id = :friend_id)
           OR (m.sender_id = :friend_id AND m.receiver_id = :user_id)
        ORDER BY m.sent_at ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':user_id' => $user_id,
    ':friend_id' => $friend_id,
]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($messages);