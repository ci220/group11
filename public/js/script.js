document.addEventListener('DOMContentLoaded', function() {
    // Image slider code remains unchanged
    const slides = document.querySelector('.slides');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    let currentSlide = 0;
    const totalSlides = document.querySelectorAll('.slides img').length;

    function updateSlide() {
        slides.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlide();
        });

        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlide();
        });

        // Auto-slide every 5 seconds
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlide();
        }, 5000);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Image slider code remains unchanged
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    let currentSlide = 0;

    // Hide all slides except first
    slides.forEach((slide, index) => {
        if (index !== 0) slide.style.display = 'none';
    });

    function showSlide(n) {
        slides[currentSlide].style.display = 'none';
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].style.display = 'block';
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
        nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));

        // Auto slide
        setInterval(() => showSlide(currentSlide + 1), 5000);
    }

    // Single, clean password toggle implementation
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});

    // Check for error parameter and form data in URL
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    
    // Restore form data if present
    const firstNameInput = document.querySelector('input[name="firstName"]');
    if (firstNameInput) {
        firstNameInput.value = urlParams.get('firstName') || '';
    }
    
    const secondNameInput = document.querySelector('input[name="secondName"]');
    if (secondNameInput) {
        secondNameInput.value = urlParams.get('secondName') || '';
    }
    
    const usernameInput = document.querySelector('input[name="username"]');
    if (usernameInput) {
        usernameInput.value = urlParams.get('username') || '';
    }
    
    const emailInput = document.querySelector('input[name="email"]');
    if (emailInput) {
        emailInput.value = urlParams.get('email') || '';
    }    
    if (error) {
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = decodeURIComponent(error);
        errorMessage.style.display = 'block';
    }



    
