<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sports_a_blaze";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT name, image_src, stocks, availability, category FROM equipment_items";
$result = $conn->query($sql);

$categories = ['Basketball' => '', 'Badminton' => '', 'Volleyball' => '', 'Courts' => ''];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $image_src = $row["image_src"];
        $stocks = $row["stocks"];
        $availability = $row["availability"] ? "Available" : "Unavailable";
        $button_disabled = $stocks == 0 ? 'disabled' : '';
        $icon_name = $stocks == 0 ? 'close-circle' : 'checkmark-circle';
        $icon_color = $stocks == 0 ? 'style="color: red;"' : '';
        $category = $row["category"];

        $item_html = "
        <div class='contents'>
            <div class='iconBx'>
                <ion-icon name='$icon_name' $icon_color></ion-icon>
                <p>$availability</p>
            </div>
            <div>
                <img src='$image_src'>
                <h5>$name</h5>
                <button class='reserve-btn' data-sport-type='$name' $button_disabled>Reserve</button>
            </div>
        </div>";

        if (array_key_exists($category, $categories)) {
            $categories[$category] .= $item_html;
        }
    }
} else {
    echo "No items found.";
}

$conn->close();

foreach ($categories as $category => $items) {
    echo "<div class='category-section' id='$category'>";
    echo "<h2 style='text-align: center;'>$category</h2>";
    echo "<div class='gallery'>";
    echo $items;
    echo "</div>";
    echo "</div>";
}
?>
