function openModal(message) {
    document.getElementById('successMessage').innerText = message;
    document.getElementById('successModal').style.display = "block";
}

function closeModal() {
    document.getElementById('successModal').style.display = "none";
}

function checkForSuccessMessage() {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        openModal(decodeURIComponent(message));
    }
}

window.onload = checkForSuccessMessage;