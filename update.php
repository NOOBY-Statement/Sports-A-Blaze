<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "sports_a_blaze");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $stocks = isset($_POST['stocks']) ? intval($_POST['stocks']) : null;
    $availability = isset($_POST['availability']) ? 1 : 0;
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $currentImageSrc = isset($_POST['currentImageSrc']) ? $_POST['currentImageSrc'] : '';

    // Check if new image is uploaded
    if (!empty($_FILES['image_src']['name'])) {
        $image = $_FILES['image_src']['tmp_name'];
        $image_name = basename($_FILES['image_src']['name']);
        $image_dest = "uploads/" . $image_name;
        
        if (move_uploaded_file($image, $image_dest)) {
            $image_src = $image_dest; // Use the new image path
        } else {
            echo "Error uploading image.";
            exit();
        }
    } else {
        // Use the existing image if no new image is uploaded
        $image_src = $currentImageSrc;
    }

    // Validate fields
    if (!$id) {
        echo "Error: ID is missing.<br>";
    } elseif (empty($name)) {
        echo "Error: Name is missing.<br>";
    } elseif (!isset($stocks)) {
        echo "Error: Stocks is missing.<br>";
    } elseif (empty($category)) {
        echo "Error: Category is missing.<br>";
    } else {
        // Update record in the database
        $sql = "UPDATE equipment_items SET name='$name', image_src='$image_src', stocks=$stocks, availability=$availability, category='$category' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            // Success message to be displayed in modal
            echo "<script>
                alert('Record Updated Successfully!');
                window.location.href = 'Admin.php'; // Redirect to Admin.php
            </script>";
            exit; // Exit script to prevent further execution
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    $conn->close();
}
?>
