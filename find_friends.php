<?php
session_start();
require 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$search = '';
$users = [];

// Fetch users based on search query
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $pdo->prepare("
        SELECT id, first_name, second_name, username 
        FROM users 
        WHERE (first_name LIKE :search OR second_name LIKE :search OR username LIKE :search) 
        AND id != :current_user
    ");
    $stmt->execute([
        ':search' => "%$search%",
        ':current_user' => $_SESSION['user_id']
    ]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Friends | Railway Community Forum</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            margin-bottom: 200px;
        }
        .friend-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .friend-card img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }
        .friend-details {
            display: flex;
            align-items: center;
        }
        .add-friend-btn {
            margin-left: 5px;
            background-color: #42b72a;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .add-friend-btn:hover {
            background-color: #369e24;
        }
        .remove-friend-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .remove-friend-btn:hover {
            background-color: #c0392b;
        }
    </style>
    <script>
        function addFriend(friendId) {
            fetch('fetch_friend.php?friend_id=' + friendId)
                .then(response => response.json())
                .then(data => {
                    if (data && data.username) {
                        alert("Friend " + data.username + " added successfully!");
                        document.getElementById('friend-' + friendId).innerHTML = 'Added';
                        document.getElementById('btn-' + friendId).disabled = true;
                    } else {
                        alert("Error adding friend.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
        }
    </script>
</head>
<body>
    <script>
        function updateFriend(action, friendId) {
            fetch(`update_friend.php?action=${action}&friend_id=${friendId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
        }
    </script>
</head>
<body>
    <!-- Header -->
    <?php include 'navigation.php'; ?>

    <!-- Main Content -->
    <main>
        <div class="container">
            <!-- Page Heading -->
            <h1>Find Friends</h1>
            <form method="GET" class="d-flex mb-4">
                <input type="text" name="search" class="form-control me-2" placeholder="Search for friends..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <!-- Search Results -->
            <?php if ($users): ?>
                <?php foreach ($users as $user): ?>
                    <div class="friend-card">
                        <div class="friend-details">
                            <img src="https://via.placeholder.com/50" alt="Profile Picture">
                            <div>
                                <h6 class="mb-0"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['second_name']); ?></h6>
                                <small>@<?php echo htmlspecialchars($user['username']); ?></small>
                            </div>
                        </div>
                        <div class="friend-buttons">
                            <button class="add-friend-btn" onclick="updateFriend('add', <?php echo $user['id']; ?>)">
                                Add Friend
                            </button>
                            <button class="remove-friend-btn" onclick="updateFriend('remove', <?php echo $user['id']; ?>)">
                                Remove
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted text-center">No users found. Try searching for someone!</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
