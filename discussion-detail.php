<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'railwayforum';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch discussion details based on ID
$discussionId = $_GET['id'] ?? '';
$discussion = null;

if ($discussionId) {
    try {
        $stmt = $pdo->prepare(
            "SELECT discussions.*, users.username 
            FROM discussions 
            JOIN users ON discussions.user_id = users.id 
            WHERE discussions.id = ?"
        );
        $stmt->execute([$discussionId]);
        $discussion = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage(); // This will output any query-related errors
    }
}

// Fetch comments
$comments = [];
try {
    $stmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.discussion_id = ?");
    $stmt->execute([$discussionId]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Detail</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-btn {
            background-color: #27ae60;
            color: white;
        }

        .add-btn:hover {
            background-color: #218c53;
        }

        .cancel-btn {
            background-color: #e74c3c;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #c0392b;
        }

        /* Container Styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .discussion-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .discussion-content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .comment-section {
            margin-top: 30px;
        }

        .comment {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .comment-header {
            font-weight: bold;
        }

        .comment-content {
            margin-top: 5px;
        }

        .actions button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<?php include 'navigation.php'; ?>

<main>
    <div class="container">
        <!-- Discussion Details -->
        <?php if ($discussion): ?>
            <div class="discussion-header">
                <h1><?= htmlspecialchars($discussion['title']) ?></h1>
                <p><strong>Posted by:</strong> <?= htmlspecialchars($discussion['username']) ?> on <?= date("F j, Y, g:i a", strtotime($discussion['date'])) ?></p>
                <div class="discussion-content">
                    <p><?= htmlspecialchars($discussion['content']) ?></p>
                    <button onclick="openModal('addCommentModal')">Add Comment</button>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="comment-section">
                <h3>Comments</h3>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <strong><?= htmlspecialchars($comment['username']) ?></strong> - <?= date("F j, Y, g:i a", strtotime($comment['date'])) ?>
                        </div>
                        <div class="comment-content">
                            <?= htmlspecialchars($comment['content']) ?>
                        </div>
                        <?php if ($_SESSION['user_id'] == $comment['user_id']): ?>
                            <div class="actions">
                                <button onclick="editComment(<?= $comment['id'] ?>, '<?= htmlspecialchars($comment['content'], ENT_QUOTES) ?>')">Edit</button>
                                <button onclick="openDeleteModal(<?= $comment['id'] ?>)">Delete</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Add/Edit Comment Modal -->
<div id="addCommentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addCommentModal')">&times;</span>
        <h2 id="modalTitle">Add Comment</h2>
        <form id="commentForm" method="POST" action="save_comment.php">
            <textarea name="content" id="commentContent" placeholder="Enter your comment" required></textarea>
            <input type="hidden" name="comment_id" id="commentId">
            <input type="hidden" name="discussion_id" value="<?= $discussionId ?>">
            <button type="submit" class="add-btn">Save</button>
            <button type="button" class="cancel-btn" onclick="closeModal('addCommentModal')">Cancel</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        <h2>Are you sure you want to delete this comment?</h2>
        <button id="confirmDelete" class="add-btn">Yes, Delete</button>
        <button class="cancel-btn" onclick="closeModal('deleteModal')">Cancel</button>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function editComment(id, content) {
        document.getElementById('modalTitle').innerText = 'Edit Comment';
        document.getElementById('commentContent').value = content;
        document.getElementById('commentId').value = id;
        openModal('addCommentModal');
    }

    function openDeleteModal(id) {
        const confirmDelete = document.getElementById('confirmDelete');
        confirmDelete.onclick = function () {
            window.location.href = `delete_comment.php?id=${id}&discussion_id=<?= $discussionId ?>`;
        };
        openModal('deleteModal');
    }
</script>

<?php include 'footer.php'; ?>
</body>
</html>
