<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <div class="container">
        <?php if ($discussion): ?>
            <div class="discussion-header">
                <!-- Title -->
                <h1><?= htmlspecialchars($discussion['title']) ?></h1>

                <!-- Posted by -->
                <p><strong>Posted by:</strong> <?= htmlspecialchars($discussion['username']) ?> 
                   on <?= date("F j, Y, g:i a", strtotime($discussion['date'])) ?></p>
            </div>

            <!-- Content -->
            <div class="discussion-content">
                <p><?= nl2br(htmlspecialchars($discussion['content'])) ?></p>
            </div>

            <!-- Image -->
            <?php if ($discussion['image_path']): ?>
                <div class="discussion-image-container">
                    <img src="<?= htmlspecialchars($discussion['image_path']) ?>" alt="Discussion image" class="discussion-image">
                </div>
            <?php endif; ?>

            <!-- Add Comment Button -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <button class="add-btn" onclick="openModal('addCommentModal')">Add Comment</button>
            <?php endif; ?>

            <!-- Comment Section -->
            <div class="comment-section">
                <h3>Comments</h3>
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <div class="comment-header">
                                <strong><?= htmlspecialchars($comment['username']) ?></strong> - 
                                <?= date("F j, Y, g:i a", strtotime($comment['date'])) ?>
                            </div>
                            <div class="comment-content">
                                <?= nl2br(htmlspecialchars($comment['content'])) ?>
                            </div>
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                                <div class="actions">
                                    <button onclick="editComment(<?= $comment['id'] ?>, '<?= htmlspecialchars($comment['content'], ENT_QUOTES) ?>')">Edit</button>
                                    <button onclick="openDeleteModal(<?= $comment['id'] ?>)">Delete</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No comments yet.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'comment_modals_partials.php'; ?>
</main>


<?php include basePath('ui/partials/footer.php'); ?>