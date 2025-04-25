
<?php
// Start session and include database connection
session_start();
$conn = new mysqli("localhost", "root", "", "sports_a_blaze");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];
$userName = '';
$userContactNumber = '';
$userEmail = '';
$userAddress = '';

// Query to fetch user details
$sql_user_details = "SELECT name, contactNumber, email, address FROM users WHERE id = ?";
$stmt_user_details = $conn->prepare($sql_user_details);
$stmt_user_details->bind_param("i", $userId);
$stmt_user_details->execute();
$stmt_user_details->store_result();

// Check if user exists
if ($stmt_user_details->num_rows > 0) {
    // Bind results
    $stmt_user_details->bind_result($userName, $userContactNumber, $userEmail, $userAddress);
    $stmt_user_details->fetch();
}

// Close statement and connection
$stmt_user_details->close();
$conn->close();






?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="styles_main.css">
    <style>
    .custom-popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    z-index: 1000;
    }
</style>
</head>

<body>

<!-- Your main content -->
<div id="mainContent">
    <!-- Button or link to trigger the popup -->
    <button onclick="openPopup()">Open Reservation Form</button>
</div>

<!-- Popup form -->
<div id="reservationPopup" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close">&times;</span>
        <h2>Reservation Form</h2>
        <form id="reservationForm" action="connection.php" method="POST">
            <input type="text" id="name" name="name" required placeholder="Name" value="<?php echo htmlspecialchars($userName); ?>"><br><br>
            
            <div class="form-row">
                <div class="form-group">
                    <input type="tel" id="contactNumber" name="contactNumber" required placeholder="Contact Number" value="<?php echo htmlspecialchars($userContactNumber); ?>">
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" required placeholder="Email" value="<?php echo htmlspecialchars($userEmail); ?>">
                </div>
            </div>

            <textarea id="address" name="address" required placeholder="Address"><?php echo htmlspecialchars($userAddress); ?></textarea><br><br>

            <div class="form-row">
                <div class="form-group">
                    <label for="pickupDate">Pickup Date</label>
                    <input type="date" id="pickupDate" name="pickupDate" required>
                </div>
                <div class="form-group">
                    <label for="returnDate">Return Date</label>
                    <input type="date" id="returnDate" name="returnDate" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="startTime">Start Time</label>
                    <input type="time" id="startTime" name="startTime" required>
                </div>
                <div class="form-group">
                    <label for="endTime">End Time</label>
                    <input type="time" id="endTime" name="endTime" required>
                </div>
            </div>
            <label for="sportType">Equipment</label>
            <input type="hidden" name="sportType" id="sportType">
            <input type="text" id="disabledSportType" name="disabledSportType" disabled>
            
            <button type="submit" name="submit">Submit Reservation</button>
        </form>
    </div>
</div>

<div>
    <!-- Display error message if there is any -->
    <?php if (!empty($error_message)) : ?>
        <script>
            // Display error message as unique popup
            showCustomPopup('<?php echo addslashes($error_message); ?>', true);
        </script>
    <?php endif; ?>

    <!-- Display success message if reservation was successful -->
    <?php if (!empty($success_message)) : ?>
        <script>
            // Display success message as unique popup
            showCustomPopup('<?php echo addslashes($success_message); ?>', false);
        </script>
    <?php endif; ?>
</div>

<!-- Unique popup container -->
<div id="custom-popup" class="custom-popup">
    <div id="custom-popup-content"></div>
</div>


<script>
    function openPopup() {
        var popup = document.getElementById('reservationPopup');
        popup.style.display = 'block';
    }
</script>

</body>
</html>
