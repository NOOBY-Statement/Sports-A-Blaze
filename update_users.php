<?php
session_start(); // Start the session at the beginning of the script

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id']; // Assumes user ID is stored in session

// Database connection
$conn = mysqli_connect("localhost", "root", "", "sports_a_blaze");
if ($conn === false) {
    die("Connection Error: " . mysqli_connect_error());
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$contact = $_POST['contact'] ?? '';
$address = $_POST['address'] ?? '';
$password = $_POST['password'] ?? '';

// Handle password hashing if needed
if (!empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET name=?, email=?, contactNumber=?, address=?, password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssssi", $name, $email, $contact, $address, $password, $user_id);
} else {
    $sql = "UPDATE users SET name=?, email=?, contactNumber=?, address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssi", $name, $email, $contact, $address, $user_id);
}

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: connection.php");
exit();
?>
