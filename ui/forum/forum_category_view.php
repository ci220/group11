<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<div class="container">
    <div class="forum-header">
        <h1>Forum Categories</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="/forum/create" method="GET">
                <button type="submit" class="create-discussion-btn">Create Discussion</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="categories-grid">
        <?php foreach ($categories as $category): ?>
            <div class="category-card">
                <h3><?= htmlspecialchars($category['name']) ?></h3>
                <p><?= htmlspecialchars($category['description']) ?></p>
                <form action="/forum/discussions" method="GET">
                    <input type="hidden" name="category" value="<?= htmlspecialchars($category['name']) ?>">
                    <button type="submit" class="btn">Explore</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include basePath('ui/partials/footer.php'); ?>