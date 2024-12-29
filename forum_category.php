<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forums</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @font-face {
            font-family: 'Times';
            src: url('font/Times.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>

<main class="container">
        <h2 class="page-title">Forum Categories</h2>
        <div class="categories-grid">
            <?php
                $categories = [
                    ["id" => 1, "name" => "Train Operations", "description" => "Discussions about train schedules, delays, and logistics."],
                    ["id" => 2, "name" => "Stations", "description" => "Topics about station facilities, cleanliness, and management."],
                    ["id" => 3, "name" => "Travel Tips", "description" => "Practical advice and tips for railway journeys."],
                ];

                foreach ($categories as $category) {
                    echo '<div class="category-card">';
                    echo '<h3>' . htmlspecialchars($category["name"]) . '</h3>';
                    echo '<p>' . htmlspecialchars($category["description"]) . '</p>';
                    echo '<a href="discussion-list.php' . $category["id"] . '" class="btn">Explore</a>';
                    echo '</div>';
                }
            ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
    <script src="js/components.js"></script>
    <script src="js/validate_login.js"></script>


</body>
</html>
