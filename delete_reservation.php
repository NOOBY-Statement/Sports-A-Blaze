<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input

    $conn = new mysqli("localhost", "root", "", "sports_a_blaze");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM reservation WHERE reserve_id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Record Deleted Successfully!');
                window.location.href = 'Admin.php';
            </script>";
        exit; // Exit script to prevent further execution
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Error: ID not provided.";
}
?>
