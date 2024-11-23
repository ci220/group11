<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Username validation - only letters and numbers
    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $errors[] = "Username can only contain letters and numbers";
    }
    
    // Existing server-side validation
    if (strlen($_POST['password']) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Username already taken";
    }
    
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Email already registered";
    }
    
    if (!empty($errors)) {
        $errorString = implode(", ", $errors);
        header("Location: register.php?error=" . urlencode($errorString));
        exit();
    }
    
    // Proceed with registration if no errors
    $firstName = $_POST['firstName'];
    $secondName = $_POST['secondName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (first_name, second_name, username, email, password, created_at) 
            VALUES (:firstName, :secondName, :username, :email, :password, NOW())";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':firstName' => $firstName,
            ':secondName' => $secondName,
            ':username' => $username,
            ':email' => $email,
            ':password' => $password
        ]);
        header('Location: login.php?registration=success');
    } catch (PDOException $e) {
        header("Location: register.php?error=Registration failed");
    }
    exit();
}

if (!empty($errors)) {
    $errorString = implode(", ", $errors);
    $formData = http_build_query([
        'error' => $errorString,
        'firstName' => $_POST['firstName'],
        'secondName' => $_POST['secondName'],
        'username' => $_POST['username'],
        'email' => $_POST['email']
    ]);
    header("Location: register.php?" . $formData);
    exit();
}

?>
