    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate if new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "New password and confirm password do not match";
        exit();
    }

    // Update profile information in database
    $conn = new mysqli("localhost", "root", "", "sports_a_blaze");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare update query
    if (!empty($new_password)) {
        $sql = "UPDATE users SET name=?, email=?, address=?, contactNumber=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt->bind_param("sssssi", $name, $email, $address, $contact, $hashed_password, $_SESSION['user_id']);
    } else {
        $sql = "UPDATE users SET name=?, email=?, address=?, contactNumber=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $address, $contact, $_SESSION['user_id']);
    }

    if ($stmt->execute()) {
        // Update session variables with new information
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['address'] = $address;
        $_SESSION['contactNumber'] = $contact;

        echo "Profile Ppdated Successfully";

    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>