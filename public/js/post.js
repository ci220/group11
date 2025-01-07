function likePost(postId) {
  fetch('/posts/like', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ post_id: postId })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          document.getElementById(`like-count-${postId}`).textContent = data.likes;
          const likeIcon = document.querySelector(`#like-count-${postId}`).previousElementSibling;
          likeIcon.classList.toggle('liked');
      }
  });
}

function deletePost(postId) {
  if (!confirm('Are you sure you want to delete this post?')) return;

  fetch('/posts/delete', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ post_id: postId })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          location.reload();
      }
  });
}

function editDescription(postId) {
  document.getElementById(`description-${postId}`).style.display = 'none';
  document.getElementById(`edit-container-${postId}`).style.display = 'block';
}

function cancelEdit(postId) {
  document.getElementById(`edit-container-${postId}`).style.display = 'none';
  document.getElementById(`description-${postId}`).style.display = 'block';
}

function saveDescription(postId) {
  const description = document.getElementById(`edit-description-${postId}`).value;

  fetch('/posts/edit', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ post_id: postId, description })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          document.getElementById(`description-${postId}`).textContent = description;
          cancelEdit(postId);
      }
  });
}