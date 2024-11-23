document.addEventListener('DOMContentLoaded', function() {
    const navigationElement = document.getElementById('navigation');
    const footerElement = document.getElementById('footer');

    if (navigationElement) {
        fetch('navigation.php')
            .then(response => response.text())
            .then(data => {
                navigationElement.innerHTML = data;
            });
    }

    if (footerElement) {
        fetch('footer.php')
            .then(response => response.text())
            .then(data => {
                footerElement.innerHTML = data;
            });
    }
});
