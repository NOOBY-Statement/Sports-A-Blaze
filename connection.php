<?php
include ('conn.php');

session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}


$userId = $_SESSION['user_id'];

// Check if the form is submitted
if(isset($_POST["submit"])) {
    // Get form data
    
    $name = $_POST['name'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pickupDate = $_POST['pickupDate'];
    $returnDate = $_POST['returnDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $equipment = $_POST['sportType'];
    $status = 'Ongoing'; // Hard-coded status for new reservations
        
        // Convert the time to 12-hour format with AM/PM
    $startTimeFormatted = date("g:i A", strtotime($startTime));
    $endTimeFormatted = date("g:i A", strtotime($endTime));


    // Validate or process data as needed

    // Check if the selected start time is within opening hours
    $user_selected_time = $_POST['startTime']; // Example: "09:30"
    $opening_time = strtotime('9:00 AM');
    $closing_time = strtotime('7:00 PM');

    if (strtotime($user_selected_time) < $opening_time || strtotime($user_selected_time) > $closing_time) {
        // Output message or handle error (in a production environment, you might redirect or show an error message)
        echo "<script>alert('Sorry, the store is closed at $user_selected_time.')</script>";
        exit; // Exit script to prevent further execution
    }

    // Check for duplicate reservation
    $sql_check_duplicate = "SELECT * FROM reservation 
                            WHERE name = ? 
                            AND equipment = ? 
                            AND pickupDate = ? 
                            AND startTime = ?";

    // Prepare statement for checking duplicate
    $stmt_check_duplicate = $conn->prepare($sql_check_duplicate);

    if ($stmt_check_duplicate === false) {
        echo "<scrip>alert('Preparation failed: " . $conn->error . "')</script>";
        exit;
    }

    // Bind parameters for checking duplicate
    $stmt_check_duplicate->bind_param("ssss", $name, $equipment, $pickupDate, $startTime);

    // Execute statement
    $stmt_check_duplicate->execute();

    // Store result to check if rows exist (duplicate found)
    $stmt_check_duplicate->store_result();

    
    // Check if there are any duplicate entries
    if ($stmt_check_duplicate->num_rows > 0) {
        echo "<script>
                alert('Sorry, a reservation with the same name, equipment, pickup date, and start time already exists.');
                window.location.href = 'connection.php'; 
            </script>";
        exit; // Exit script to prevent further execution
    }

    // Insert data into the database
    $sql_insert = "INSERT INTO reservation (user_id, name, contactNumber, email, address, equipment, pickupDate, returnDate, startTime, endTime, status) 
                    VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare statement for insert
    $stmt_insert = $conn->prepare($sql_insert);

    if ($stmt_insert === false) {
        echo "<script>alert('Preparation failed: " . $conn->error . "')</script>";
        exit;
    }

    // Bind parameters for insert
    $stmt_insert->bind_param("sssssssssss",$userId, $name, $contactNumber, $email, $address, $equipment, $pickupDate, $returnDate, $startTime, $endTime, $status);
    if ($stmt_insert->execute()) {
        // Decrement stock for the reserved equipment
        $update_stock_sql = "UPDATE equipment_items SET stocks = stocks - 1 WHERE name = ?";
        $update_stmt = $conn->prepare($update_stock_sql);
        $update_stmt->bind_param("s", $equipment);

        if ($update_stmt->execute()) {
            //echo "<script>alert('Reserved Successfully!')</script>";
            $success_message = "Reserved Successfully!";
        } else {
            echo "<script>alert('Reservation submitted, but there was an error updating stock: " . $update_stmt->error . "')</script>";
        }
    } else {
        echo "<script>alert('There was an error: " . $stmt_insert->error . "')</script>";
    }

    // Close statement for insert
    $stmt_insert->close();

    // Close statement for checking duplicate
    $stmt_check_duplicate->close();
}
    // Include file to fetch user reservations
include('fetch_user_reserve.php');
include('fetch_user_details.php');

// Close connection

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sports A-Blaze</title>
    <link rel="stylesheet" href="style_main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css"/>


    
    
</head>
<body>
    
    <div class="container">
        <!-- SIDEBAR -->
        <div class="navigation">
            <ul>
            <li>
                <a href="#">
                <span class="icon">
                    <img src="logo.png" alt="Sports A-Blaze Logo">
                </span>
                <span class="title" style="font-size: 20px;">Sports A-Blaze</span>
                </a>
            </li>
            <li>
                <a href="#reservation" onclick="showPanel('reservationsPanel')">
                <span class="icon">
                    <ion-icon name="cart-sharp"></ion-icon>
                </span>
                <span class="title">Reservation</span>
                </a>
            </li>
            <li>
                <a href="#myReservations" onclick="showPanel('myReservationPanel')">
                <span class="icon">
                    <ion-icon name="clipboard"></ion-icon>
                </span>
                <span class="title">My Reservations</span>
                </a>
            </li>
            <li>
                <a href="#profile" onclick="showPanel('profilePanel')">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <span class="title">Profile</span>
                </a>
            </li>
            <li>
                <a href="#logout" onclick="confirmLogout()">
                <span class="icon">
                    <ion-icon name="log-out-sharp"></ion-icon>
                </span>
                <span class="title">Logout</span>
        </a>
    </li>
        </ul>
    </div>
    
        <!-- MAIN CONTENT -->
        <div class="main">
            <div class="topbar">
            <div class="toggle" onclick="toggleSidebar()">
                <ion-icon name="menu"></ion-icon>
            </div>
        </div>

        
    
        <!-- Panels -->
        <div id="reservationsPanel" class="panel active">
        <div>
            <h3 style="color: #033a18;">Welcome, <?php echo $_SESSION["name"]; ?>!</h3>
        </div>

            <h3>List of Equipment</h3>
            <br>

            <div class="button-container">
                <button id="courtButton" class="switch-button">Court</button>
                <button id="equipmentButton" class="switch-button active">Equipment</button>
            </div>

            <div id="courtPanel" class="content-panel">
                <!-- Content for Court items -->
                <?php include 'fetch_court_items.php'; ?>
            </div>

            <div id="equipmentPanel" class="content-panel active">
                <!-- Content for Equipment items -->
                <?php include 'fetch_equipment_items.php'; ?>
            </div>

            <div id="courtSection">
    <!-- Content for Court section -->
            </div>

    <!-- Popup Form -->

    

<div id="reservationPopup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
            <h2 style="margin-bottom: 10px; color: #502504;">Reservation Form</h2>
            <?php include 'autofill_input.php'; ?>

            <form id="reservationForm" action="connection.php" method="POST" onsubmit="return validateDates()">
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
            
            <button type="submit" class="btn-submit" name="submit">Submit Reservation</button>
        </form>
        
    </div>
    
</div>
</div>

<!-- Modal for Success Message -->
<div id="myModalSuccess" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeModalSuccess()">&times;</span>
        <div class="check-icon">&#10003;</div>
        <div id="modal-content-success"></div>
    </div>
</div>

<!-- Modal for Error Message -->
<div id="myModalError" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="closed" onclick="closeModalError()">&times;</span>
        <div class="closed-icon">X</div>
        <div id="modal-content-error"></div>
    </div>
</div>


<!-- PHP block to trigger the modals -->
<?php if (!empty($success_message)) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showModalSuccess('<?php echo addslashes($success_message); ?>');
        });

        function showModalSuccess(message) {
            var modal = document.getElementById('myModalSuccess');
            var modalContent = document.getElementById('modal-content-success');
            modalContent.innerHTML = message;
            modal.style.display = 'block';
        }

        function closeModalSuccess() {
            var modal = document.getElementById('myModalSuccess');
            modal.style.display = 'none';
        }
    </script>
<?php endif; ?>

<?php if (!empty($error_message)) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showModalError('<?php echo addslashes($error_message); ?>');
        });

        function showModalError(message) {
            var modal = document.getElementById('myModalError');
            var modalContent = document.getElementById('modal-content-error');
            modalContent.innerHTML = message;
            modal.style.display = 'block';
        }

        function closeModalError() {
            var modal = document.getElementById('myModalError');
            modal.style.display = 'none';
        }
    </script>
<?php endif; ?>





<!-- DITO KAYO MAGSTART, MGA PANEL TO-->
    
    <!-- Panel for My Reservations -->
    <div id="myReservationPanel" class="panel">
        <h3 style="margin-bottom: 20px;">My Reservations</h3>
        
        <div class="contain" style="margin-left: 20px; margin-right: 20px;">
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th >Reservation ID</th>
                    <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">Equipment</th>
                    <th>Pickup Date</th>
                    <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">Return Date</th>
                    <th>Start Time</th>
                    <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">End Time</th>
                    <th>Status</th>
                    <!-- Add -->
                </tr>
            </thead>
            <tbody>
            
                <?php
                
                if (isset($reservations) && !empty($reservations)) {
                    foreach ($reservations as $reservation) {
                        echo '<tr>';
                        echo '<td>' . $reservation['reserve_id'] . '</td>';
                        echo '<td>' . $reservation['equipment'] . '</td>';
                        echo '<td>' . $reservation['pickupDate'] . '</td>';
                        echo '<td>' . $reservation['returnDate'] . '</td>';
                        
                        // Add columns
                        // Convert startTime and endTime to 12-hour format with AM/PM
                    $startTimeFormatted = date("g:i A", strtotime($reservation['startTime']));
                    $endTimeFormatted = date("g:i A", strtotime($reservation['endTime']));
                    
                    echo '<td>' . $startTimeFormatted . '</td>';
                    echo '<td>' . $endTimeFormatted . '</td>';
                    
                        // status color
                        $status = $reservation['status'];
                        if ($status == 'Completed') {
                            echo '<td style="color: green; font-weight: bold;">' . $status . '</td>';
                        } elseif ($status == 'Ongoing') {
                            echo '<td style="color: #983f12; font-weight: bold;">' . $status . '</td>';
                        } elseif ($status == 'Cancelled') {
                            echo '<td style="color: red; font-weight: bold;">' . $status . '</td>';
                        } else {
                            echo '<td>' . $status . '</td>';
                                }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                    echo '<td colspan="7">No reservations found.</td>';
                    echo '</tr>';
                }
                ?>
                
            </tbody>
        </table>
    </div>
    </div>
    <!-- End div Panel-->

    <div id="profilePanel" class="panel">
    <?php include 'fetch_users.php'; ?>
    <div class="profile-container">

    <div class="container-one">
    <h1>Profile</h1>
    <ion-icon name="person-circle-sharp" class="iconperson"></ion-icon>
    </div>

    <div class="container-one">
    <h2>Account Information</h2>
    <p class="note">Your private information is not visible to others.</p>
    <form id="profileForm" method="POST" action="update_users.php">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" class="disabled" disabled><br>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="disabled" disabled><br>
        
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" class="disabled" disabled><br>
        
        <label for="contact">Contact Number</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" class="disabled" disabled><br>
        <br>
        
        <label for="password" class="disabled">Change Password</label>
        <input type="password" id="password" name="password" class="disabled" disabled><br>
               
                    <label for="confirm_password" class="disabled">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="disabled" disabled>
<br>
<br>
        <div class="btn-group">
        <button type="button" id="editButton" class="btn-edit">Edit Profile</button>
        <button type="submit" id="updateButton" class="disabled" disabled>Save Changes</button>
        </div>
    </form>

    </div>
    </div>
    <script>
        
        document.getElementById('editButton').addEventListener('click', function() {
            var inputs = document.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.classList.remove('disabled');
                input.disabled = false;
            });
            document.getElementById('updateButton').classList.remove('disabled');
            document.getElementById('updateButton').disabled = false;
        });

        document.getElementById('updateButton').addEventListener('click', function() {
            var formData = new FormData(document.getElementById('profileForm'));
            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                // Optionally, reload the form data to reflect the updated information
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    
    </script>

<!-- End div Panel-->

    
    <div id="logoutPanel" class="panel">
    <h3>Logout</h3>
    <p>Are you sure you want to logout?</p>
    <button onclick="confirmLogout()">Logout</button>
</div>
    <!-- End div Panel-->

</div>
</div>
</div> <!--END div main-->
</div> <!--END div container-->

    <!--JAVASCRIPT-->
    <script src="script.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Get today's date in YYYY-MM-DD format
    let today = new Date().toISOString().split('T')[0];
    
    // Set the minimum Pickup Date to today's date
    let pickupDateInput = document.getElementById('pickupDate');
    pickupDateInput.setAttribute('min', today);
    
    // Set the minimum Return Date to today's date
    let returnDateInput = document.getElementById('returnDate');
    returnDateInput.setAttribute('min', today);
});

    function validateDates() {
            let pickupDate = document.getElementById('pickupDate').value;
            let returnDate = document.getElementById('returnDate').value;

            if (returnDate < pickupDate) {
                alert("Return date cannot be earlier than pickup date.");
                return false;
            }
            return true;
        }

    </script>

    <script>
    var ajax = new XMLHttpRequest();
    var method = "GET";
    var url = "data.php";
    var asynchronous = true;

    ajax.open(method, url, asynchronous);
    //sending ajax request
    ajax.send();

    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);

            var html = "";
            for (var a = 0; a < data.length; a++) {
                var id = data[a].id;
                var name = data[a].name;
                var contactNumber = data[a].contactNumber;
                var email = data[a].email;
                var address = data[a].address;
                var equipment = data[a].equipment;
                var pickupDate = data[a].pickupDate;
                var returnDate = data[a].returnDate;
                var startTime = data[a].startTime;
                var endTime = data[a].endTime;
                var status = data[a].status;

                html += "<tr>";
                html += "<td>" + id + "</td>";
                html += "<td>" + name + "</td>";
                html += "<td>" + contactNumber + "</td>";
                html += "<td>" + email + "</td>";
                html += "<td>" + address + "</td>";
                html += "<td>" + equipment + "</td>";
                html += "<td>" + pickupDate + "</td>";
                html += "<td>" + returnDate + "</td>";
                html += "<td>" + startTime + "</td>";
                html += "<td>" + endTime + "</td>";
                html += "<td>" + status + "</td>";
                html += "</tr>";
            }

            document.getElementById("data").innerHTML = html;
        }
    }
</script> 
<script>
    function confirmLogout() {
        var confirmed = window.confirm("Are you sure you want to logout?");
        if (confirmed) {
            // Perform logout action here (e.g., redirect to logout script)
            window.location.href = "landingpage.php"; // Replace with your logout script URL
        } else {
            // Optional: Handle cancel action if needed
            // Example: alert("Logout canceled");
        }
    }

    <!-- JavaScript for popup functionality -->
    // Function to show the unique popup
    function showCustomPopup(message, isError) {
        var popup = document.getElementById('custom-popup');
        var popupContent = document.getElementById('custom-popup-content');
        var popupColor = isError ? 'red' : 'green';

        // Set popup message and style
        popupContent.innerHTML = message;
        popupContent.style.color = popupColor;

        // Show the popup
        popup.style.display = 'block';

        // Automatically hide after 3 seconds (adjust timing as needed)
        setTimeout(function() {
            popup.style.display = 'none';
        }, 3000); // 3000 milliseconds = 3 seconds
    }
</script>

<script>
        function enableEdit() {
            document.getElementById('name').removeAttribute('readonly');
            document.getElementById('email').removeAttribute('readonly');
            document.getElementById('address').removeAttribute('readonly');
            document.getElementById('contact').removeAttribute('readonly');
            document.getElementById('password').removeAttribute('disabled');
            document.getElementById('confirm_password').removeAttribute('disabled');
            document.getElementById('editBtn').style.display = 'none';
            document.getElementById('updateBtn').style.display = 'inline-block';
        }
    </script>



    <!--IONICONS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
</body>
</html>
