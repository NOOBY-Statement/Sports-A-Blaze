<?php
// Start session to access session variables
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include_once 'conn.php';

// Fetch user data based on user_id stored in session
$id = $_SESSION['id'];
$query = "SELECT name, email, contact, address FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $contact = $row['contact'];
    $address = $row['address'];
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>