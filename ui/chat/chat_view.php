<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main class="chat-container">
    <script>
        const userId = <?= $_SESSION['user_id'] ?>;
    </script>
    <div class="chat-wrapper">
        <!-- Friends List -->
        <div class="friends-sidebar">
            <div class="friends-header">
                <h2>Friends</h2>
                <?php if (!empty($friends)): ?>
                    <?php foreach ($friends as $friend): ?>
                        <div class="friend-item" data-friend-id="<?= $friend['id'] ?>">
                            <div class="friend-info">
                                <img src="<?= $friend['profile_picture'] ? '/uploads/images/profile/' . $friend['profile_picture'] : '/image/Avatar.png' ?>" 
                                     alt="Profile picture">
                                <span><?= htmlspecialchars($friend['username']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-friends">No friends yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-main">
            <div id="chat-header">
                <h3>Select a friend to start chatting</h3>
            </div>

            <div id="messages">
                <!-- Messages will be loaded here -->
            </div>

            <div class="message-input-container">
                <form id="message-form">
                    <textarea id="message-input" 
                              placeholder="Type your message..." 
                              rows="1"></textarea>
                    <button type="submit" disabled>Send</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>