<?php
// Include database connection and session handling if needed


// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input (reserve_id)
    $reserveId = isset($_POST['reserve_id']) ? intval($_POST['reserve_id']) : 0;

    // Perform cancellation logic (update status to 'Cancelled' in database)
    $conn = new mysqli("localhost", "root", "", "sports_a_blaze");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare update statement
    $sql = "UPDATE reservations SET status = 'Cancelled' WHERE reserve_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserveId);
    
    // Execute update
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Reservation cancelled successfully.'];
    } else {
        $response = ['success' => false, 'message' => 'Failed to cancel reservation. Please try again.'];
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    // Method not allowed
    http_response_code(405);
    exit('Method Not Allowed');
}
?>
