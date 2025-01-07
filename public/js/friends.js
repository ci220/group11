function updateFriend(action, friendId) {
    let confirmationMessage;
    if (action === 'add') {
        confirmationMessage = 'Are you sure you want to send a friend request?';
    } else if (action === 'remove') {
        confirmationMessage = 'Are you sure you want to remove this friend?';
    } else if (action === 'accept') {
        confirmationMessage = 'Are you sure you want to accept this friend request?';
    } else if (action === 'decline') {
        confirmationMessage = 'Are you sure you want to decline this friend request?';
    }

    if (!confirm(confirmationMessage)) {
        return;
    }

    const formData = new FormData();
    formData.append('action', action);
    formData.append('friend_id', friendId);

    let endpoint;
    if (action === 'add') {
        endpoint = '/friends/add';
    } else if (action === 'remove') {
        endpoint = '/friends/delete';
    } else {
        endpoint = '/notifications/accept';
    }

    fetch(endpoint, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload(); // Reload the page to reflect changes
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
    });
}