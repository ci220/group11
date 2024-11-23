<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railway Community Forum</title>
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

    <main>
        <!-- Image Slider -->
        <div class="slider">
            <div class="slides">
                <img src="image/slideshow.jpg" alt="Modern Trains">
                <img src="image/slideshow.jpg" alt="Railway Heritage">
                <img src="image/slideshow.jpg" alt="Railway Technology">
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>

        <!-- Latest Discussions -->
        <section class="latest-discussions">
            <h2>Latest Railway Discussions</h2>
            <div class="discussion-grid">
                <div class="discussion-card">
                    <h3>New High-Speed Rail Project Updates</h3>
                    <p>Latest developments in the cross-country rail project...</p>
                    <div class="meta">
                        <span>Posted by @rail_enthusiast</span>
                        <span>10 mins ago</span>
                    </div>
                </div>
                <div class="discussion-card">
                    <h3>Heritage Steam Locomotives</h3>
                    <p>Discussing preservation techniques for steam engines...</p>
                    <div class="meta">
                        <span>Posted by @steam_master</span>
                        <span>1 hour ago</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="featured-categories">
            <h2>Railway Categories</h2>
            <div class="category-grid">
                <div class="category-card">
                    <i class="fas fa-train"></i>
                    <h3>Modern Railways</h3>
                    <p>850 Topics</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-history"></i>
                    <h3>Heritage Railways</h3>
                    <p>620 Topics</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-cog"></i>
                    <h3>Technical Discussion</h3>
                    <p>1.1k Topics</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Route Planning</h3>
                    <p>450 Topics</p>
                </div>
            </div>
        </section>

        <!-- Popular Topics -->
        <section class="popular-topics">
            <h2>Trending Railway Topics</h2>
            <div class="topics-list">
                <div class="topic-item">
                    <h3>Electric vs Diesel Locomotives</h3>
                    <p>Comparing modern railway propulsion systems...</p>
                    <div class="topic-stats">
                        <span>Views: 2.3k</span>
                        <span>Replies: 89</span>
                    </div>
                </div>
                <div class="topic-item">
                    <h3>Signal Systems Modernization</h3>
                    <p>Discussion on new railway signaling technology...</p>
                    <div class="topic-stats">
                        <span>Views: 1.8k</span>
                        <span>Replies: 56</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Extension-->
    <?php include 'footer.php'; ?>

    
    <script src="js/script.js"></script>
    <script src="js/components.js"></script>
</body>
</html>


