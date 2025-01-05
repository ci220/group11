<?php
// Include the database connection file
include 'database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        die('All fields are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    try {
        // Create a database connection
        $database = new Database();
        $conn = $database->getConnection();

        // Insert query
        $sql = "INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param('sss', $name, $email, $message);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the contact page with success message
            header('Location: contactus.php?success=1');
            exit;
        } else {
            die('Error executing statement: ' . $stmt->error);
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
} else {
    // If the request is not POST, redirect back to the form
    header('Location: contactus.php');
    exit;
}
?>
