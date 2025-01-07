<?php

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$title = "Login";
$css = ["css/styles.css"];
$js = ["js/script.js", "js/components.js", 'js/validate_login.js', 'js/modal.js'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $db->query("SELECT * FROM users WHERE username = ?", [$username])->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        session_regenerate_id(true);
        
        header('Location: /');
        exit();
    } else {
        // Store error in flash, redirect
        setFlash('error', 'Invalid credentials.');
        header('Location: /login');
        exit();
    }
}

require 'login_view.php';