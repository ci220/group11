document.querySelector('.register-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const firstName = document.querySelector('input[name="firstName"]').value;
    const secondName = document.querySelector('input[name="secondName"]').value;
    const username = document.querySelector('input[name="username"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="confirmPassword"]').value;
    const errorMessage = document.getElementById('errorMessage');

    // Clear previous error
    errorMessage.style.display = 'none';
    errorMessage.textContent = '';

    // Username validation - only letters and numbers
    if (!/^[a-zA-Z0-9]+$/.test(username)) {
        errorMessage.textContent = 'Username can only contain letters and numbers';
        errorMessage.style.display = 'block';
        return;
    }

    // Existing validation rules
    if (password !== confirmPassword) {
        errorMessage.textContent = 'Passwords do not match';
        errorMessage.style.display = 'block';
        return;
    }

    if (password.length < 8) {
        errorMessage.textContent = 'Password must be at least 8 characters long';
        errorMessage.style.display = 'block';
        return;
    }

    if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
        errorMessage.textContent = 'Please enter a valid email address';
        errorMessage.style.display = 'block';
        return;
    }

    if (username.length < 3) {
        errorMessage.textContent = 'Username must be at least 3 characters long';
        errorMessage.style.display = 'block';
        return;
    }

    // If validation passes, submit the form
    this.submit();
});
