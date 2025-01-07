<?php
$config = require(basePath('config.php'));
$db = new Database($config['database']);

if (!isset($_SESSION['user_id'])) {
    setFlash('error', 'Please login to proceed');
    header('Location: /login');
    exit();
}

$userId = $_SESSION['user_id'];

try {
    $db->pdo->beginTransaction();

    $db->query("DELETE FROM messages WHERE receiver_id = ?", [$userId]);

    // Delete user's messages
    $db->query("DELETE FROM messages WHERE sender_id = ?", [$userId]);

    // Delete user's comments
    $db->query("DELETE FROM comments WHERE user_id = ?", [$userId]);

    // Delete user's likes
    $db->query("DELETE FROM post_likes WHERE user_id = ?", [$userId]);

    // Delete user's posts and their media
    $posts = $db->query("SELECT media_path FROM posts WHERE user_id = ?", [$userId])->fetchAll(PDO::FETCH_ASSOC);
    foreach ($posts as $post) {
        if (!empty($post['media_path'])) {
            $mediaFilePath = basePath('uploads/posts/' . $post['media_path']);
            if (file_exists($mediaFilePath)) {
                unlink($mediaFilePath); // Delete the media file
            }
        }
    }
    $db->query("DELETE FROM posts WHERE user_id = ?", [$userId]);

    // Delete user's discussions
    $db->query("DELETE FROM discussions WHERE user_id = ?", [$userId]);

    // Delete friend relationships
    $db->query(
        "DELETE FROM friends 
         WHERE user_id = ? OR friend_id = ?", 
        [$userId, $userId]
    );

    // Delete user's profile picture
    $user = $db->query("SELECT profile_picture FROM users WHERE id = ?", [$userId])->fetch();
    if ($user['profile_picture'] && file_exists('uploads/images/profile/' . $user['profile_picture'])) {
        unlink('uploads/images/profile/' . $user['profile_picture']);
    }

    // Finally delete the user
    $db->query("DELETE FROM users WHERE id = ?", [$userId]);

    $db->pdo->commit();

    // Logout and redirect
    logout();
    setFlash('success', 'Your account has been deleted successfully.');
    header('Location: /login');
    exit();

} catch (Exception $e) {
    $db->pdo->rollBack();
    error_log("Account deletion failed: " . $e->getMessage());
    setFlash('error', 'Failed to delete account. Please try again.');
    header('Location: /profile');
    exit();
}