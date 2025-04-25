<?php
include 'conn.php'; // Include your database connection file

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Assume $userId is already set from session or wherever you're getting it
$userId = $_SESSION['user_id']; // Adjust based on your session variable

// Query to fetch reservations for the user
$sql = "SELECT * FROM reservation WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId); // Assuming user_id is an integer
$stmt->execute();
$result = $stmt->get_result();

// Fetch reservations as associative array
$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

// Close statement and connection
$stmt->close();
$conn->close();

?>
