<?php
session_start();
require_once 'database.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['id'];
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare search query
$stmt = $pdo->prepare("
    SELECT id, username, profile_picture 
    FROM users 
    WHERE username LIKE :search 
    AND id != :current_user_id 
    AND id NOT IN (
        SELECT friend_id 
        FROM friends 
        WHERE id = :current_user_id AND status = 'accepted'
    )
");
$stmt->execute([
    ':search' => "%$search_query%", 
    ':current_user_id' => $current_user_id
]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTML for Search Users Page -->
<form method="GET">
    <input type="text" name="search" placeholder="Search users" value="<?php echo htmlspecialchars($search_query); ?>">
    <button type="submit">Search</button>
</form>

<div class="users-list">
    <?php foreach ($users as $user): ?>
        <div class="user-card">
            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
            <h3><?php echo htmlspecialchars($user['username']); ?></h3>
            <form action="add_friend.php" method="POST">
                <input type="hidden" name="friend_id" value="<?php echo $user['user_id']; ?>">
                <button type="submit">Add Friend</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>