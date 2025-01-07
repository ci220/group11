<?php
session_start();
require 'database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

if (isset($_GET['action'], $_GET['friend_id'])) {
    $action = $_GET['action'];
    $friend_id = (int) $_GET['friend_id'];
    $current_user = $_SESSION['user_id'];

    if ($action === 'add') {
        $stmt = $pdo->prepare("INSERT INTO friends (user_id, friend_id) VALUES (:user_id, :friend_id)");
        $stmt->execute([':user_id' => $current_user, ':friend_id' => $friend_id]);
        echo json_encode(['success' => true, 'message' => 'Friend added successfully!']);
    } elseif ($action === 'remove') {
        $stmt = $pdo->prepare("DELETE FROM friends WHERE user_id = :user_id AND friend_id = :friend_id");
        $stmt->execute([':user_id' => $current_user, ':friend_id' => $friend_id]);
        echo json_encode(['success' => true, 'message' => 'Friend removed successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request parameters.']);
}
