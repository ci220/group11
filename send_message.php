<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($_SESSION['user_id'], $input['friend_id'], $input['message'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $friend_id = $input['friend_id'];
    $message_body = trim($input['message']);

    if ($message_body === '') {
        echo json_encode(['success' => false, 'error' => 'Message cannot be empty']);
        exit();
    }

    $insert_sql = "INSERT INTO messages (sender_id, receiver_id, body, sent_at)
                   VALUES (:sender_id, :receiver_id, :body, NOW())";
    $insert_stmt = $pdo->prepare($insert_sql);
    $insert_stmt->execute([
        ':sender_id' => $user_id,
        ':receiver_id' => $friend_id,
        ':body' => $message_body,
    ]);

    echo json_encode(['success' => true]);
}