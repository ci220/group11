<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = :identifier OR email = :identifier";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':identifier' => $identifier]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        header('Location: index.php');
        exit();
    } else {
        header("Location: login.php?error=" . urlencode("Invalid credentials"));
        exit();
    }
}
