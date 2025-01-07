<?php
$title = "Verify OTP";
$css = ["css/styles.css"];
$js = ["js/script.js", "js/components.js"];

require basePath('ui/partials/header.php');
require basePath('ui/partials/navigation.php');

$config = require(basePath('config.php'));
$db = new Database($config['database']);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['registration_data']) && isset($_SESSION['registration_data']['otp'])) {
        $storedOtp = $_SESSION['registration_data']['otp'];
        $enteredOtp = $_POST['otp'];

        // Optional: check for expiration
        if (time() > $_SESSION['registration_data']['otp_expires_at']) {
            $errors[] = "OTP has expired. Please register again.";
        } elseif ($enteredOtp === $storedOtp) {
            $firstName = $_SESSION['registration_data']['firstName'];
            $secondName = $_SESSION['registration_data']['secondName'];
            $username = $_SESSION['registration_data']['username'];
            $email = $_SESSION['registration_data']['email'];
            $password = $_SESSION['registration_data']['password'];

            $sql = "INSERT INTO users (first_name, second_name, username, email, password, created_at) 
                    VALUES (:firstName, :secondName, :username, :email, :password, NOW())";

            try {
                $db->query($sql, [
                    ':firstName' => $firstName,
                    ':secondName' => $secondName,
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $password
                ]);
                unset($_SESSION['registration_data']);
                setFlash('success', 'Registration successful! You can now log in.');
                header('Location: /login');
                exit();
            } catch (PDOException $e) {
                $errors[] = "Registration failed: " . $e->getMessage();
            }
        } else {
            $_SESSION['registration_data']['otp_attempts']++;
            $errors[] = "Invalid OTP";
        }
    } else {
        $errors[] = "No registration data found. Please register again.";
    }

    if (!empty($errors)) {
        setFlash('error', implode(', ', $errors));
        header("Location: /verify-otp");
        exit();
    }
}
?>

<body>
    <main>
        <div class="register-box">
            <h2>Verify OTP</h2>
            <?php if (hasFlash('error')): ?>
                <div class="error-message">
                    <?= getFlash('error') ?>
                </div>
            <?php endif; ?>
            <form class="register-form" action="/verify-otp" method="POST">
                <input type="text" name="otp" placeholder="Enter OTP" required>
                <button type="submit">Verify OTP</button>
            </form>
        </div>
    </main>
<?php require basePath('ui/partials/footer.php'); ?>