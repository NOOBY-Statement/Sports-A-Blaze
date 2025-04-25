<?php
include 'connect.php';
// Assuming na yung ID ni user ay 7 (edit nyo nalang tong part nato,
//if ever naa mag login and ibang account, dagdag kayo function
// need mag coordinate yung naka assign sa login at sa user page)
$id = 7; 
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$password = $_POST['password']; // Make sure to handle password hashing if needed

$sql = "UPDATE users SET name=?, email=?, contact=?, address=?, password=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $name, $email, $contact, $address, $password, $id);

if ($stmt->execute()) {
    echo "<script>
                alert('Record Updated Successfully!');
                window.location.href = 'Admin.php';
    </script>";
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();

header("Location: user.php");
exit();
?>
