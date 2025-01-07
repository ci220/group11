<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<div class="container">
    <h1>My Posts</h1>
    
    <?php if (!empty($posts)): ?>
        <div class="posts-container">
            <?php foreach ($posts as $post): ?>
                <div class="post">
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
                        <button class="edit-btn" onclick="editDescription(<?= $post['id'] ?>)">Edit</button>
                    </div>

                    <div class="edit-description-container" id="edit-container-<?= $post['id'] ?>" style="display: none;">
                        <textarea id="edit-description-<?= $post['id'] ?>" class="description-textarea"><?= htmlspecialchars($post['description']) ?> </textarea>
                        <div class="button-group">
                            <button class="save-btn" onclick="saveDescription(<?= $post['id'] ?>)">Save</button>
                            <button class="cancel-btn" onclick="cancelEdit(<?= $post['id'] ?>)">Cancel</button>
                        </div>
                    </div>

                    <div class="action-bar">
                        <p class="timestamp"><?= date("F j, Y, g:i a", strtotime($post['created_at'])) ?></p>
                        <div class="action-buttons">
                            <div class="like-container">
                                <i class="fas fa-thumbs-up <?= $post['user_liked'] ? 'liked' : '' ?>" 
                                   onclick="likePost(<?= $post['id'] ?>)"></i>
                                <span id="like-count-<?= $post['id'] ?>"><?= $post['like_count'] ?></span>
                            </div>
                            <div class="delete-container">
                                <i class="fas fa-trash" onclick="deletePost(<?= $post['id'] ?>)"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="empty-message">No posts found. Create your first post!</p>
    <?php endif; ?>
</div>

<?php include basePath('ui/partials/footer.php'); ?>