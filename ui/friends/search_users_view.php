<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Search Users</h1>
            <a href="/friends" class="btn btn-primary">Back to Friends</a>
        </div>

        <form method="GET" class="d-flex mb-4">
            <input type="text" name="search" class="form-control me-2" 
                   placeholder="Search users..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php if ($users): ?>
            <?php foreach ($users as $user): ?>
                <div class="friend-card">
                    <div class="friend-details">
                        <?php 
                        $profilePicture = !empty($user['profile_picture']) 
                            ? '/uploads/images/profile/' . htmlspecialchars($user['profile_picture']) 
                            : 'image/Avatar.png'; 
                        ?>
                        <img src="<?= $profilePicture ?>" alt="Profile Picture">
                        <div>
                            <h6 class="mb-0"><?= htmlspecialchars($user['first_name'] . ' ' . $user['second_name']) ?></h6>
                            <small>@<?= htmlspecialchars($user['username']) ?></small>
                        </div>
                    </div>
                    <div class="friend-buttons">
                    <?php if ($user['friend_status'] === null): ?>
                            <button class="add-friend-btn" onclick="updateFriend('add', <?= $user['id'] ?>)">
                                Add Friend
                            </button>
                        <?php elseif ($user['friend_status'] === 'pending'): ?>
                            <button class="add-friend-btn request-sent" disabled>Request Sent</button>
                        <?php elseif ($user['friend_status'] === 'accepted'): ?>
                            <button class="add-friend-btn" disabled>Friends</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center">No users found. Try searching for someone!</p>
        <?php endif; ?>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>