<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<div class="container">
    <div class="form-container">
        <h1>Create Discussion</h1>

        <?php if (isset($_SESSION['_flash']['error'])): ?>
            <div class="error-message">
                <?= $_SESSION['_flash']['error'] ?>
            </div>
        <?php endif; ?>

        <form action="/forum/store" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Category</label>
                <select name="category" required>
                    <option value="">Select a category</option>
                    <option value="Train Operations">Train Operations</option>
                    <option value="Stations">Stations</option>
                    <option value="Travel Tips">Travel Tips</option>
                </select>
            </div>

            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" required 
                       value="<?= htmlspecialchars($_SESSION['_flash']['old']['title'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" required><?= htmlspecialchars($_SESSION['_flash']['old']['content'] ?? '') ?></textarea>
                <p class="help-text">Minimum 20 characters</p>
            </div>

            <div class="form-group">
                <label>Image (Optional)</label>
                <div class="upload-box">
                    <input type="file" name="image" accept="image/*">
                    <p>PNG, JPG up to 2MB</p>
                </div>
            </div>

            <button type="submit" class="btn">Create Discussion</button>
        </form>
    </div>
</div>

<?php include basePath('ui/partials/footer.php'); ?>