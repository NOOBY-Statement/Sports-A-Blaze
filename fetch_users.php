
<?php
$user_id = $_SESSION['user_id']; // Assumes user ID is stored in session

// Database connection
$conn = mysqli_connect("localhost", "root", "", "sports_a_blaze");
if ($conn == false) {
    die("Connection Error: " . mysqli_connect_error());
}

$sql = "SELECT name, email, address, contactNumber FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $address, $contact);
$stmt->fetch();
$stmt->close();
$conn->close();

?> 