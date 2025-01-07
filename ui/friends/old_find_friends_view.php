<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <div class="container">
        <h1>Find Friends</h1>
        <form method="GET" class="d-flex mb-4">
            <input type="text" name="search" class="form-control me-2" placeholder="Search for friends..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Search Results -->
        <?php if ($users): ?>
            <?php foreach ($users as $user): ?>
                <div class="friend-card">
                    <div class="friend-details">
                    <?php $profilePicture = !empty($user['profile_picture']) ? '/uploads/images/profile/' . htmlspecialchars($user['profile_picture']) : 'image/Avatar.png'; ?>
                        <img src=<?=$profilePicture ?> alt="Profile Picture">
                        <div>
                            <h6 class="mb-0"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['second_name']); ?></h6>
                            <small>@<?php echo htmlspecialchars($user['username']); ?></small>
                        </div>
                    </div>
                    <div class="friend-buttons">
                        <button class="add-friend-btn" onclick="updateFriend('add', <?php echo $user['id']; ?>)">
                            Add Friend
                        </button>
                        <button class="remove-friend-btn" onclick="updateFriend('remove', <?php echo $user['id']; ?>)">
                            Remove
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center">No users found. Try searching for someone!</p>
        <?php endif; ?>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>