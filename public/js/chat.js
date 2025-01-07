// Grab form, input, and chat area
const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');
const messagesContainer = document.getElementById('messages');
const chatHeader = document.getElementById('chat-header');

// Initially hide chat sections
chatHeader.style.display = 'none';
messagesContainer.style.display = 'none';
messageForm.style.display = 'none';

// Active friend ID
let activeFriendId = null;

// Fetch messages once friend is selected
function fetchMessages() {
  if (!activeFriendId) return;

  fetch(`/chat/messages?friend_id=${activeFriendId}`)
    .then(res => res.json())
    .then(messages => {
      messagesContainer.innerHTML = messages.map(msg => `
          <div class="message ${msg.sender_id == userId ? 'sent' : 'received'}">
            <p>${msg.body}</p>
            <small>${new Date(msg.sent_at).toLocaleTimeString()}</small>
          </div>
        `).join('');
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    })
    .catch(err => console.error('Error:', err));
}

// Listen for friend selection
document.querySelectorAll('.friend-item').forEach(item => {
  item.addEventListener('click', () => {
    activeFriendId = item.dataset.friendId;
    // Enable send button
    const sendButton = document.querySelector('#message-form button');
    sendButton.disabled = false;

    // Set chat header text
    const friendName = item.querySelector('span').textContent;
    chatHeader.querySelector('h3').textContent = `Chat with ${friendName}`;

    // Show chat area
    chatHeader.style.display = 'block';
    messagesContainer.style.display = 'block';
    messageForm.style.display = 'flex';

    // Fetch messages one time
    fetchMessages();
  });
});

// Submit message
messageForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const message = messageInput.value.trim();
  if (!message || !activeFriendId) return;

  // Send message to server
  fetch('/chat/send', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ friend_id: activeFriendId, message })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Clear textbox, fetch messages once
        messageInput.value = '';
        fetchMessages();
      } else {
        console.error('Error:', data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
});