<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <div class="container">
        <h1>Notifications</h1>

        <?php if ($requests): ?>
            <?php foreach ($requests as $request): ?>
                <div class="friend-card">
                    <div class="friend-details">
                        <?php 
                        $profilePicture = !empty($request['profile_picture']) 
                            ? '/uploads/images/profile/' . htmlspecialchars($request['profile_picture']) 
                            : 'image/Avatar.png'; 
                        ?>
                        <img src="<?= $profilePicture ?>" alt="Profile Picture">
                        <div>
                            <h6 class="mb-0"><?= htmlspecialchars($request['first_name'] . ' ' . $request['second_name']) ?></h6>
                            <small>@<?= htmlspecialchars($request['username']) ?></small>
                        </div>
                    </div>
                    <div class="friend-buttons">
                        <button class="accept-friend-btn" onclick="updateFriend('accept', <?= $request['id'] ?>)">
                            Accept
                        </button>
                        <button class="decline-friend-btn" onclick="updateFriend('decline', <?= $request['id'] ?>)">
                            Decline
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center">No Notifications.</p>
        <?php endif; ?>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>