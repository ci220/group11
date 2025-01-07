    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About RailConnect</h3>
                <p>Your premier community for railway enthusiasts, professionals, and hobbyists.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                    <li><a href="/guidelines">Community Guidelines</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Connect With Us</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 RailConnect. All rights reserved.</p>
        </div>
    </footer>

    <?php // Check if there are multiple js files to include
    if (isset($js) && is_array($js)): ?>

        <?php foreach ($js as $jsFile): ?>
            <script src="<?= $jsFile ?>"></script>
        <?php endforeach; ?>

    <?php else: ?>
        <script src="<?= $js ?>"></script>
    <?php  endif;?>
    
</body>
</html>
