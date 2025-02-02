<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <nav>
        <div class="logo">RailConnect</div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="posting.php">Post</a></li>
                <li><a href="userprofile.php">Profile</a></li>
                <li><a href="chat.php">Chat</a></li>
                <li><a href="logout.php">Logout</a></li>

            </ul>
        <?php else: ?>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="forums.php">Forums</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="FAQ.php">FAQ</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="register.php" class="register-btn">Register</a></li>
            </ul>
        <?php endif; ?>
    </nav>
</header>
