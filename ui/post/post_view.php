<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<div class="container">
    <h1>All Posts</h1>
    
    <?php if (!empty($posts)): ?>
        <div class="posts-container">
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <div class="post-header">
                        <div class="user-info">
                            <span class="username">@<?= htmlspecialchars($post['username']) ?></span>
                        </div>
                        <span class="timestamp"><?= date("F j, Y, g:i a", strtotime($post['created_at'])) ?></span>
                    </div>

                    <?php if (strpos($post['media_type'], 'image') !== false): ?>
                        <img src="/uploads/posts/<?= htmlspecialchars($post['media_path']) ?>" alt="Post Image">
                    <?php elseif (strpos($post['media_type'], 'video') !== false): ?>
                        <video controls>
                            <source src="/uploads/posts/<?= htmlspecialchars($post['media_path']) ?>" type="<?= $post['media_type'] ?>">
                        </video>
                    <?php endif; ?>

                    <div class="description-container">
                        <p class="description" id="description-<?= $post['id'] ?>">
                            <?= htmlspecialchars($post['description']) ?>
                        </p>
                        <?php if ($post['user_id'] === $_SESSION['user_id']): ?>
                            <button class="edit-btn" onclick="editDescription(<?= $post['id'] ?>)">Edit</button>
                        <?php endif; ?>
                    </div>

                    <?php if ($post['user_id'] === $_SESSION['user_id']): ?>
                        <div class="edit-description-container" id="edit-container-<?= $post['id'] ?>" style="display: none;">
                            <textarea class="description-textarea" id="edit-description-<?= $post['id'] ?>"><?= htmlspecialchars($post['description']) ?></textarea>
                            <div class="button-group">
                                <button class="save-btn" onclick="saveDescription(<?= $post['id'] ?>)">Save</button>
                                <button class="cancel-btn" onclick="cancelEdit(<?= $post['id'] ?>)">Cancel</button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="action-bar">
                        <div class="action-buttons">
                            <div class="like-container">
                                <i class="fas fa-thumbs-up <?= $post['user_liked'] ? 'liked' : '' ?>" 
                                   onclick="likePost(<?= $post['id'] ?>)"></i>
                                <span id="like-count-<?= $post['id'] ?>"><?= $post['like_count'] ?></span>
                            </div>
                            <?php if ($post['user_id'] === $_SESSION['user_id']): ?>
                                <div class="delete-container">
                                    <i class="fas fa-trash" onclick="deletePost(<?= $post['id'] ?>)"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="empty-message">No posts found.</p>
    <?php endif; ?>
</div>

<?php include basePath('ui/partials/footer.php'); ?>