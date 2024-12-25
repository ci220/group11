<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the friend list
$stmt = $pdo->prepare("
    SELECT users.id, users.username 
    FROM friends 
    JOIN users ON friends.friend_id = users.id 
    WHERE friends.user_id = :user_id
");
$stmt->execute([':user_id' => $user_id]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Determine the selected friend for chatting
$friend_id = isset($_GET['friend_id']) ? $_GET['friend_id'] : ($friends[0]['id'] ?? null);


// Get the friend's user ID from the URL or default to the first friend
if (isset($_GET['friend_id'])) {
    $friend_id = $_GET['friend_id'];
} else {
    // If no friend_id is set, default to the first friend in the list
    if (!empty($friends)) {
        $friend_id = $friends[0]['id'];
    } else {
        // If the user has no friends, handle accordingly
        $friend_id = null;
    }
}

// Proceed only if friend_id is available
if ($friend_id) {
    // Fetch friend's username
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :friend_id");
    $stmt->execute([':friend_id' => $friend_id]);
    $friend = $stmt->fetch();

    if (!$friend) {
        echo "Friend not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat with <?= htmlspecialchars($friend['username']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
.btn {
  background-color: DodgerBlue;
  border-radius: 12px;
  color: white;
  padding: 10px 16px;
  font-size: 16px;
  cursor: pointer;
  margin: 0px 16px
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
</style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <main>
    <div class="chat-page">
    <!-- Friend List Sidebar -->
    <div class="friend-list">
        <h3>Friends     <button onclick="window.location.href='find_friends.php'" class="btn">Add <i class="fa fa-plus"></i></button></a></h3> 
        <?php if (!empty($friends)): ?>
            <ul>
                <?php foreach ($friends as $friendItem): ?>
                    <li class="<?= ($friendItem['id'] == $friend_id) ? 'active' : ''; ?>">
                        <button class="friend-button" data-friend-id="<?= $friendItem['id']; ?>">
                            <?= htmlspecialchars($friendItem['username']); ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>You have no friends added.</p>
        <?php endif; ?>
    </div>

    <!-- Chat Area -->
    <?php if ($friend_id): ?>
<div class="chat-area">
    <h2>Chat with <?= htmlspecialchars($friend['username']); ?></h2>
    <div class="chat-container">
        <div class="messages" id="messages">
            <!-- Messages will be loaded here -->
        </div>

        <form id="messageForm" class="message-form">
          <div class="input-group">
            <textarea name="message" id="messageInput" placeholder="Type your message..." required></textarea>
            <button type="submit">Send</button>
          </div>
        </form>
    </div>
</div>
<?php else: ?>
<div class="chat-area">
    <h2>Select a friend to start chatting</h2>
</div>
<?php endif; ?>
</div>
    </main>

    <script>
const userId = <?= json_encode($user_id); ?>;
let friendId = <?= json_encode($friend_id); ?>;

function fetchMessages() {
    if (!friendId) return;

    fetch(`fetch_messages.php?friend_id=${friendId}`)
        .then(response => response.json())
        .then(data => {
            const messagesContainer = document.getElementById('messages');
            messagesContainer.innerHTML = '';
            data.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message');
                messageDiv.classList.add(message.sender_id == userId ? 'sent' : 'received');

                messageDiv.innerHTML = `
                    <p>${message.body}</p>
                    <span>${message.sent_at}</span>
                `;
                messagesContainer.appendChild(messageDiv);
            });
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        })
        .catch(error => console.error('Error:', error));
}

// Initial fetch and periodic updates
fetchMessages();
setInterval(fetchMessages, 5000);

// Handle message sending without page refresh
document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();

    if (message !== '') {
        fetch('send_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ friend_id: friendId, message: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                fetchMessages();
            } else {
                console.error('Error:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

// Handle friend selection
document.querySelectorAll('.friend-button').forEach(button => {
    button.addEventListener('click', function() {
        friendId = this.getAttribute('data-friend-id');

        // Update the active class
        document.querySelectorAll('.friend-list li').forEach(li => li.classList.remove('active'));
        this.parentElement.classList.add('active');

        // Clear the message input field
        document.getElementById('messageInput').value = '';

        // Update the chat header
        fetch(`fetch_friend.php?friend_id=${friendId}`)
            .then(response => response.json())
            .then(data => {
                document.querySelector('.chat-area h2').textContent = 'Chat with ' + data.username;
                // Fetch new messages
                fetchMessages();
            })
            .catch(error => console.error('Error:', error));
    });
});
</script>

    <?php include 'footer.php'; ?>
</body>
</html>