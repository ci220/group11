<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>My Friends</h1>
            <a href="/friends/search" class="btn btn-primary">Add Friends</a>
        </div>

        <form method="GET" class="d-flex mb-4">
            <input type="text" name="search" class="form-control me-2" 
                   placeholder="Search friends..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php if ($friends): ?>
            <?php foreach ($friends as $friend): ?>
                <div class="friend-card">
                    <div class="friend-details">
                        <?php 
                        $profilePicture = !empty($friend['profile_picture']) 
                            ? '/uploads/images/profile/' . htmlspecialchars($friend['profile_picture']) 
                            : 'image/Avatar.png'; 
                        ?>
                        <img src="<?= $profilePicture ?>" alt="Profile Picture">
                        <div>
                            <h6 class="mb-0"><?= htmlspecialchars($friend['first_name'] . ' ' . $friend['second_name']) ?></h6>
                            <small>@<?= htmlspecialchars($friend['username']) ?></small>
                        </div>
                    </div>
                    <div class="friend-buttons">
                        <button class="remove-friend-btn" onclick="updateFriend('remove', <?= $friend['id'] ?>)">
                            Remove Friend
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center">No friends found.</p>
        <?php endif; ?>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>