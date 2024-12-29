<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "railwayforum");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the request
$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'];
$newDescription = $conn->real_escape_string($data['description']);

// Update the description in the database
$sql = "UPDATE posts SET description = '$newDescription' WHERE id = $postId";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
