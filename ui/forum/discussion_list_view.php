<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <h1 style="text-align: center; font-size: 28px; color: #2c3e50; font-weight: bold; margin-bottom: 20px;">
        Discussion List
    </h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="category-selection">
            <form method="GET" action="/forum/discussions" style="flex: 1;">
                <label for="category">Select Category:</label>
                <select id="category" name="category" onchange="this.form.submit()">
                    <option value="">-- All Categories --</option>
                    <option value="Train Operations" <?= $category === 'Train Operations' ? 'selected' : '' ?>>Train Operations</option>
                    <option value="Stations" <?= $category === 'Stations' ? 'selected' : '' ?>>Stations</option>
                    <option value="Travel Tips" <?= $category === 'Travel Tips' ? 'selected' : '' ?>>Travel Tips</option>
                </select>
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
            </form>

            <form method="GET" action="/forum/create" style="text-align: right;">
                <button type="submit" class="create-discussion-btn">Create New Discussion</button>
            </form>
        </div>
    <?php endif; ?>

    <section class="search-filter">
        <form method="GET" action="/forum/discussions">
            <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search discussions..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </div>
            <div class="filter-box">
                <label for="order">Sort by:</label>
                <select id="order" name="order" onchange="this.form.submit()">
                    <option value="latest" <?= $order === 'latest' ? 'selected' : '' ?>>Latest</option>
                    <option value="oldest" <?= $order === 'oldest' ? 'selected' : '' ?>>Oldest</option>
                </select>
            </div>
        </form>
    </section>

    <section class="discussion-list">
        <?php if (!empty($discussions)): ?>
            <?php foreach ($discussions as $discussion): ?>
                <div class="discussion-item" onclick="window.location.href='/forum/discussion?id=<?= $discussion['id'] ?>';">
                    <div class="discussion-details">
                        <h2><?= htmlspecialchars($discussion['title']) ?></h2>
                        <p class="discussion-meta">by <span class="username"><?= htmlspecialchars($discussion['username']) ?></span></p>
                        <p class="discussion-description"><?= htmlspecialchars(substr($discussion['content'], 0, 100)) ?>...</p>
                        <span class="discussion-footer"><?= htmlspecialchars($discussion['date']) ?></span>
                    </div>
                    <?php if (!empty($discussion['image_path'])): ?>
                        <img src="<?= '' . htmlspecialchars($discussion['image_path']) ?>" alt="Discussion Image" class="discussion-image">
                    <?php endif; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No discussions found.</p>
        <?php endif; ?>
    </section>
</main>

<?php include basePath('ui/partials/footer.php'); ?>