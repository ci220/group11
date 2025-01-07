<?php include basePath('/ui/partials/header.php'); ?>
<?php include basePath('/ui/partials/navigation.php'); ?>

<main class="flex-grow pt-16 pb-16">
    <div class="container w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-4">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">Create Post</h1>

        <?php
        if (!empty($_SESSION['_flash'])) {
            foreach ($_SESSION['_flash'] as $key => $message) {
                if ($key === 'success') {
                    echo "<div class='success-message mb-4'>$message</div>";
                } elseif ($key === 'error') {
                    echo "<div class='error-message mb-4'>$message</div>";
                }
            }
        }
        $old = $_SESSION['_flash']['old'] ?? [];
        unset($_SESSION['_flash']['old']);
        ?>

        <form action="/post/create" method="POST" enctype="multipart/form-data">
            <div class="upload-box border-2 border-dashed border-gray-300 rounded-lg p-4 mb-4 text-center">
                <label class="block text-gray-600 mb-2" for="media">Add photo/video from device</label>
                <div class="relative inline-block">
                    <input 
                        accept="image/jpeg, image/png, video/mp4" 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                        id="media" 
                        name="media" 
                        required 
                        type="file" 
                        onchange="previewFile()"
                    />
                    <button type="button" class="bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75">
                        Choose File
                    </button>
                </div>
                <div id="file-name" class="mt-2 text-gray-600"></div>
                <div id="preview" class="mt-4"></div>
            </div>
            <textarea 
                class="w-full border border-gray-300 rounded-lg p-2 mb-4 text-gray-800" 
                name="description" 
                placeholder="Add description..." 
                required
            ><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600" type="submit">
                POST
            </button>
        </form>
    </div>
</main>

<?php include basePath('ui/partials/footer.php'); ?>