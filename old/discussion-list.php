<?php
session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle category selection
$category = $_GET['category'] ?? ''; // Default to show all if no category is selected

// Handle search and filter
$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'latest';
$orderQuery = $order === 'oldest' ? 'ASC' : 'DESC';

// Fetch discussions based on category, search, and order, including the username
if ($category) {
    $stmt = $pdo->prepare(
        "SELECT discussions.*, users.username 
        FROM discussions 
        JOIN users ON discussions.user_id = users.id 
        WHERE discussions.category = ? AND discussions.title LIKE ? 
        ORDER BY discussions.date $orderQuery"
    );
    $stmt->execute([$category, "%$search%"]);
} else {
    $stmt = $pdo->prepare(
        "SELECT discussions.*, users.username 
        FROM discussions 
        JOIN users ON discussions.user_id = users.id 
        WHERE discussions.title LIKE ? 
        ORDER BY discussions.date $orderQuery"
    );
    $stmt->execute(["%$search%"]);
}

$discussions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion List</title>
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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(254, 254, 254);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .create-discussion-btn {
            background-color: black;
            color: rgb(255, 255, 255);
            border: 1px solid white;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
        }

        .create-discussion-btn:hover {
            background-color: rgb(105, 105, 105);
            color: rgb(255, 255, 255);
        }

        main {
            padding: 20px;
            flex: 1;
        }

        .category-selection {
    width: 81%; /* Set width to 80% */
    margin: 0 auto 20px; /* Center horizontally with top/bottom margin */
    padding: 10px;
    background: white;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box; /* Padding won't affect width */
}

        .search-filter {
            margin-bottom: 20px;
            padding: 10px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-selection select,
        .search-filter select,
        .search-filter input[type="text"] {
            padding: 5px;
            font-size: 14px;
        }

        .discussion-list .discussion-item {
            background: white;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .discussion-list .discussion-item:hover {
            background-color: #f0f8ff;
        }

        .discussion-title {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }

        .discussion-meta {
            margin: 5px 0;
            font-size: 12px;
            color: gray;
        }

        .discussion-footer {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: gray;
        }

        main {
             padding: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .search-filter {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-box input {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-box button {
            padding: 8px 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: #3498db;
        }

        .filter-box label {
            margin-right: 8px;
        }

        .filter-box select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .discussion-list {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .discussion-item {
            cursor: pointer;
            padding: 10px 0;
        }

        .discussion-item h2 {
            font-size: 18px;
            margin: 0;
            color: #2c3e50;
            font-weight: bold;
        }

        .discussion-meta {
            font-size: 14px;
            color: #7f8c8d;
        }

        .discussion-description {
            font-size: 16px;
            color: #34495e;
            margin: 8px 0;
        }

        .discussion-footer {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #95a5a6;
        }

        hr {
            border: 0;
            border-top: 1px solid #ecf0f1;
            margin: 10px 0;
        }

        .discussion-list .discussion-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .discussion-list .discussion-item .discussion-details {
            flex: 1;
        }

        .discussion-list .discussion-item .discussion-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-left: 20px;
        }

        .discussion-item h2 {
            font-size: 18px;
            margin: 0;
            color: #2c3e50;
            font-weight: bold;
        }

        .discussion-meta, .discussion-description {
            font-size: 14px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>

<main>

<!-- Discussion List Title -->
<h1 style="
        text-align: center;
        font-size: 28px;
        font-family: 'Arial', sans-serif;
        color: #2c3e50;
        font-weight: bold;
        margin-bottom: 20px;
    ">
        Discussion List
    </h1>

<?php if (isset($_SESSION['user_id'])): ?>
        <div class="category-selection">
            <!-- Category Selection -->
            <form method="GET" action="discussion-list.php" style="flex: 1;">
                <label for="category">Select Category:</label>
                <select id="category" name="category" onchange="this.form.submit()">
                    <option value="">-- All Categories --</option>
                    <option value="Train Operations" <?= $category === 'Train Operations' ? 'selected' : '' ?>>Train Operations</option>
                    <option value="Stations" <?= $category === 'Stations' ? 'selected' : '' ?>>Stations</option>
                    <option value="Road Planning" <?= $category === 'Road Planning' ? 'selected' : '' ?>>Road Planning</option>
                </select>
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
            </form>

            <!-- Create New Discussion Button -->
            <form method="GET" action="create-discussion.php" style="text-align: right;">
                <button type="submit" class="create-discussion-btn">Create New Discussion</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Category Selection and Search Section -->
    <section class="search-filter">
        <form method="GET" action="discussion-list.php">
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

    <!-- Discussion List -->
    <section class="discussion-list">
        <?php if (count($discussions) > 0): ?>
            <?php foreach ($discussions as $discussion): ?>
                <div class="discussion-item" onclick="window.location.href='discussion-detail.php?id=<?= $discussion['id'] ?>';">
                    <div class="discussion-details">
                        <h2><?= htmlspecialchars($discussion['title']) ?></h2>
                        <p class="discussion-meta">by <span class="username"><?= htmlspecialchars($discussion['username']) ?></span></p>
                        <p class="discussion-description"><?= htmlspecialchars(substr($discussion['content'], 0, 100)) ?>...</p>
                        <span class="discussion-footer"><?= htmlspecialchars($discussion['date']) ?></span>
                    </div>
                    <?php if (!empty($discussion['image_path'])): ?>
                        <img src="<?= htmlspecialchars($discussion['image_path']) ?>" alt="Discussion Image" class="discussion-image">
                    <?php endif; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No discussions found.</p>
        <?php endif; ?>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>