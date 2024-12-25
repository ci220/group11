<?php
session_start();
require_once 'database.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['id'];

// Fetch accepted friends
$stmt = $pdo->prepare("
    SELECT u.user_id, u.username, u.profile_picture 
    FROM users u
    JOIN friends f ON (f.friend_id = u.user_id OR f.user_id = u.user_id)
    WHERE f.status = 'accepted' 
    AND (f.user_id = :user_id OR f.friend_id = :user_id)
    AND u.user_id != :user_id
");
$stmt->execute([':user_id' => $current_user_id]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch pending friend requests
$pending_stmt = $pdo->prepare("
    SELECT u.user_id, u.username, u.profile_picture 
    FROM users u
    JOIN friends f ON f.user_id = u.user_id
    WHERE f.friend_id = :user_id AND f.status = 'pending'
");
$pending_stmt->execute([':user_id' => $current_user_id]);
$pending_requests = $pending_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTML for Friends List Page -->
<div class="friends-list">
    <h2>My Friends</h2>
    <?php foreach ($friends as $friend): ?>
        <div class="friend-card">
            <img src="<?php echo htmlspecialchars($friend['profile_picture']); ?>" alt="Profile Picture">
            <h3><?php echo htmlspecialchars($friend['username']); ?></h3>
            <div class="friend-actions">
                <a href="private_message.php?friend_id=<?php echo $friend['user_id']; ?>">Send Message</a>
                <form action="remove_friend.php" method="POST">
                    <input type="hidden" name="friend_id" value="<?php echo $friend['user_id']; ?>">
                    <button type="submit">Remove Friend</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="friend-requests">
    <h2>Friend Requests</h2>
    <?php foreach ($pending_requests as $request): ?>
        <div class="request-card">
            <img src="<?php echo htmlspecialchars($request['profile_picture']); ?>" alt="Profile Picture">
            <h3><?php echo htmlspecialchars($request['username']); ?></h3>
            <form action="accept_friend.php" method="POST">
                <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                <button type="submit" class="accept">Accept</button>
            </form>
            <form action="reject_friend.php" method="POST">
                <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                <button type="submit" class="reject">Reject</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>