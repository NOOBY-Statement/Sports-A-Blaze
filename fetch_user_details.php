<?php
// Include your database connection file
include('conn.php');

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect or handle unauthenticated user scenario
    header("Location: login.php"); // Example redirect to login page
    exit();
}

// Get user details based on session user_id
$userId = $_SESSION['user_id'];

// Prepare SQL query to fetch user details
$sql = "SELECT name, contactNumber, email, address FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

// Bind parameters and execute SQL query
$stmt->bind_param('i', $userId);
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Fetch user details as an associative array
$userDetails = $result->fetch_assoc();

// Close prepared statement
$stmt->close();


?>
