<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
?>
<header>
    <nav>
        <div class="logo">RailConnect</div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <!-- <li><a href="/about">About Us</a></li> -->
                <li><a href="/notifications">Notification</a></li>
                <li><a href="/forum">Forums</a></li>
                <li><a href="/posts">Post</a></li>
                <li><a href="/friends">Friends</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/chat">Chat</a></li>
                <li>
                    <form action="/logout" method="POST" style="display:inline;">
                        <button type="submit" class="register-btn">Logout</button>
                    </form>
                </li>

            </ul>
        <?php else: ?>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About Us</a></li>
                <li><a href="/forum">Forums</a></li>
                <li><a href="/login">Login</a></li>
                <li><a href="/faq">FAQ</a></li>
                <li><a href="/contact">Contact Us</a></li>
                <li><a href="/register" class="register-btn">Register</a></li>
            </ul>
        <?php endif; ?>
    </nav>
</header>
