
<div id="addCommentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addCommentModal')">&times;</span>
        <h2 id="modalTitle">Add Comment</h2>
        <form id="commentForm" method="POST" action="/forum/comment/save">
            <textarea name="content" id="commentContent" placeholder="Enter your comment" required></textarea>
            <input type="hidden" name="comment_id" id="commentId">
            <input type="hidden" name="discussion_id" value="<?= $discussionId ?>">
            <button type="submit" class="add-btn">Save</button>
            <button type="button" class="cancel-btn" onclick="closeModal('addCommentModal')">Cancel</button>
        </form>
    </div>
</div>


<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        <h2>Delete Comment?</h2>
        <p>Are you sure you want to delete this comment?</p>
        <button id="confirmDelete" class="add-btn">Yes, Delete</button>
        <button class="cancel-btn" onclick="closeModal('deleteModal')">Cancel</button>
    </div>
</div>