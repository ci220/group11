<?php
session_start();
require_once 'database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];
$friend_id = $_POST['friend_id'];

try {
    // Check if friendship already exists
    $check_stmt = $pdo->prepare("
        SELECT * FROM friends 
        WHERE (user_id = :user_id AND friend_id = :friend_id) 
        OR (user_id = :friend_id AND friend_id = :user_id)
    ");
    $check_stmt->execute([
        ':user_id' => $current_user_id, 
        ':friend_id' => $friend_id
    ]);

    if ($check_stmt->rowCount() == 0) {
        // Create friendship request
        $stmt = $pdo->prepare("
            INSERT INTO friends (user_id, friend_id, status) 
            VALUES (:user_id, :friend_id, 'pending')
        ");
        $stmt->execute([
            ':user_id' => $current_user_id, 
            ':friend_id' => $friend_id
        ]);

        $_SESSION['success_message'] = "Friend request sent!";
    } else {
        $_SESSION['error_message'] = "Friend request already exists.";
    }
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Error sending friend request.";
}

header("Location: search_users.php");
exit();