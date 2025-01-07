function openModal(modalId) {
  document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = 'none';
  // Reset form if it's the add/edit modal
  if (modalId === 'addCommentModal') {
      document.getElementById('modalTitle').innerText = 'Add Comment';
      document.getElementById('commentContent').value = '';
      document.getElementById('commentId').value = '';
  }
}

function editComment(commentId, content) {
  document.getElementById('modalTitle').innerText = 'Edit Comment';
  document.getElementById('commentContent').value = content;
  document.getElementById('commentId').value = commentId;
  openModal('addCommentModal');
}

function openDeleteModal(commentId) {
  const confirmDelete = document.getElementById('confirmDelete');
  confirmDelete.onclick = function() {
      deleteComment(commentId);
  };
  openModal('deleteModal');
}

function deleteComment(commentId) {
  if (!confirm('Are you sure you want to delete this comment?')) return;

  fetch(`/forum/comment/delete`, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({
          comment_id: commentId,
          discussion_id: document.querySelector('[name="discussion_id"]').value
      })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          location.reload();
      } else {
          alert(data.message || 'Error deleting comment');
      }
  })
  .catch(error => {
      console.error('Error:', error);
      alert('Failed to delete comment');
  });
}

// Add event listeners when document loads
document.addEventListener('DOMContentLoaded', function() {
  // Close modal when clicking outside
  window.onclick = function(event) {
      if (event.target.classList.contains('modal')) {
          closeModal(event.target.id);
      }
  };

  // Handle comment form submission
  const commentForm = document.getElementById('commentForm');
  if (commentForm) {
      commentForm.addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);
          
          fetch('/forum/comment/save', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              } else {
                  alert(data.message || 'Error saving comment');
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert('Failed to save comment');
          });
      });
  }

  // Close modals when clicking X
  document.querySelectorAll('.close').forEach(closeBtn => {
      closeBtn.addEventListener('click', function() {
          const modalId = this.closest('.modal').id;
          closeModal(modalId);
      });
  });
});