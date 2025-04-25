<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "sports_a_blaze");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $image_src = isset($_POST['image_src']) ? $_POST['image_src'] : '';
    $stocks = isset($_POST['stocks']) ? (int)$_POST['stocks'] : 0;
    $availability = isset($_POST['availability']) ? 1 : 0;
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    if ($name && $stocks && $category) {
        // Check if equipment already exists
        $sql = "SELECT id, stocks FROM equipment_items WHERE name='$name' AND category='$category'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Equipment exists, update stocks
            $row = $result->fetch_assoc();
            $existing_id = $row['id'];
            $existing_stocks = $row['stocks'];
            $new_stocks = $existing_stocks + $stocks;

            $update_sql = "UPDATE equipment_items SET stocks=$new_stocks WHERE id=$existing_id";
            if ($conn->query($update_sql) === TRUE) {
                echo "<script>
                    alert('Stocks Updated Successfully!');
                    window.location.href = 'Admin.php';
                </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            // Equipment does not exist, insert new record
            $insert_sql = "INSERT INTO equipment_items (name, image_src, stocks, availability, category) VALUES ('$name', '$image_src', $stocks, $availability, '$category')";

            if ($conn->query($insert_sql) === TRUE) {
                echo "<script>
                    alert('New Record Inserted Successfully!');
                    window.location.href = 'Admin.php';
                </script>";
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: Missing required fields.";
    }

    $conn->close();
}
?>
