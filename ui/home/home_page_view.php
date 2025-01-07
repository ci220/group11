<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main>
    <!-- Image Slider -->
    <div class="slider">
        <div class="slide active">
            <img src="image/head1.jpg" alt="Modern Trains">
        </div>
        <div class="slide active">
            <img src="image/head2.jpg" alt="Railway Heritage">
        </div>
        <button class="prev">❮</button>
        <button class="next">❯</button>
    </div>

    <!-- Latest Discussions -->
    <section class="latest-discussions">
    <h2>Latest Railway Discussions</h2>
    <div class="discussion-grid">
        <?php foreach ($latestDiscussions as $discussion): ?>
            <a href="/forum/discussion?id=<?= $discussion['id'] ?>" class="discussion-card">
                <h3><?= htmlspecialchars($discussion['title']) ?></h3>
                <p><?= htmlspecialchars(substr($discussion['content'], 0, 100)) ?>...</p>
                <div class="meta">
                    <span>Posted by @<?= htmlspecialchars($discussion['username']) ?></span>
                    <span><?= timeAgo($discussion['date']) ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

    <!-- Railway Categories -->
    <section class="featured-categories">
        <h2>Railway Categories</h2>
        <div class="category-grid">
            <?php foreach ($categories as $category): ?>
                <a href="/forum/discussions?category=<?= urlencode($category['name']) ?>" class="category-card">
                    <i class="fas fa-train"></i>
                    <h3><?= htmlspecialchars($category['name']) ?></h3>
                    <p><?= $category['topic_count'] ?> Topics</p>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php include basePath('ui/partials/footer.php'); ?>
