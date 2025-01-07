<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require basePath('vendor/autoload.php');

$title = "Register";
$css = ["css/styles.css"];
$js = ["js/script.js", "js/components.js", 'js/validate_register.js'];

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$errors = [];

// Simple function to generate a 6-digit OTP
function generateOtp(): string {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Send OTP using PHPMailer
function sendOtp($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        // TODO: put your actual Gmail credentials (use environment variables in production)
        $mail->Username = 'hzyw35149@gmail.com';
        $mail->Password = 'xiqvoiugpxoqxsin';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('hzyw35149@gmail.com', 'RailConnect');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'Your OTP is: ' . $otp;

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Server-side validation
    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $errors[] = "Username can only contain letters and numbers";
    }

    if (strlen($_POST['password']) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    if ($_POST['password'] !== $_POST['confirmPassword']) {
        $errors[] = "Passwords do not match";
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Check username duplication
    $stmt = $db->query("SELECT COUNT(*) FROM users WHERE username = ?", [$_POST['username']]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Username already taken";
    }

    // Check email duplication
    $stmt = $db->query("SELECT COUNT(*) FROM users WHERE email = ?", [$_POST['email']]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Email already registered";
    }

    if (empty($errors)) {
        $firstName = trim(htmlspecialchars($_POST['firstName']));
        $secondName = trim(htmlspecialchars($_POST['secondName']));
        $username = trim(htmlspecialchars($_POST['username']));
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Generate OTP
        $otp = generateOtp();
        $_SESSION['registration_data'] = [
            'firstName' => $firstName,
            'secondName' => $secondName,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'otp' => $otp,
            'otp_expires_at' => time() + (15 * 60), // 15 minutes expiry
            'otp_attempts' => 0
        ];

        // Send OTP to user's email
        sendOtp($email, $otp);

        // Redirect to OTP verification page
        header('Location: /verify-otp');
        exit();
    } else {
        // Store errors in flash, redirect with old input
        setFlash('error', implode(', ', $errors));
        $_SESSION['_flash']['old'] = $_POST;
        header("Location: /register");
        exit();
    }
}

require 'register_view.php';