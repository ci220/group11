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
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .category-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-10px);
        }

        .category-card h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #333;
        }

        .category-card p {
            font-size: 1em;
            color: #666;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #000;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #333;
            transform: scale(1.05);
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

</body>
</html>
