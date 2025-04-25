<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sports_a_blaze";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$totalReservations = $equipmentReservations = $courtReservations = $totalAccounts = 0;

// Fetch total reservations
$totalReservationsQuery = "SELECT COUNT(*) AS total FROM reservation";
$totalReservationsResult = $conn->query($totalReservationsQuery);
if ($totalReservationsResult) {
    $totalReservationsRow = $totalReservationsResult->fetch_assoc();
    $totalReservations = $totalReservationsRow['total'];
}

// Fetch equipment reservations (excluding courts)
$equipmentReservationsQuery = "
    SELECT COUNT(*) AS total 
    FROM reservation 
    WHERE equipment NOT IN ('Basketball Court', 'Badminton Court', 'Volleyball Court')";
$equipmentReservationsResult = $conn->query($equipmentReservationsQuery);
if ($equipmentReservationsResult) {
    $equipmentReservationsRow = $equipmentReservationsResult->fetch_assoc();
    $equipmentReservations = $equipmentReservationsRow['total'];
}

// Fetch court reservations (including only courts)
$courtReservationsQuery = "
    SELECT COUNT(*) AS total 
    FROM reservation 
    WHERE equipment IN ('Basketball Court', 'Badminton Court', 'Volleyball Court')";
$courtReservationsResult = $conn->query($courtReservationsQuery);
if ($courtReservationsResult) {
    $courtReservationsRow = $courtReservationsResult->fetch_assoc();
    $courtReservations = $courtReservationsRow['total'];
}

// Fetch total accounts
$totalAccountsQuery = "SELECT COUNT(*) AS total FROM users";
$totalAccountsResult = $conn->query($totalAccountsQuery);
if ($totalAccountsResult) {
    $totalAccountsRow = $totalAccountsResult->fetch_assoc();
    $totalAccounts = $totalAccountsRow['total'];
}

// Fetch latest 3 reservations
$latestReservationsQuery = "
    SELECT reserve_id, name, contactNumber, email, equipment, pickupDate, returnDate, startTime, endTime 
    FROM reservation 
    ORDER BY reserve_id DESC 
    LIMIT 3";
$latestReservationsResult = $conn->query($latestReservationsQuery);
$latestReservations = [];
if ($latestReservationsResult) {
    while ($row = $latestReservationsResult->fetch_assoc()) {
        $latestReservations[] = $row;
    }
}

// Close connection
$conn->close();
?>