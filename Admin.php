<?php
include ('conn.php');
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sports_a_blaze";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Update status in the database when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["status"]) && isset($_POST["reserve_id"])) {
    $newStatus = $_POST["status"];
    $id = $_POST["reserve_id"]; // The ID of the record to update

    $sql = "UPDATE reservation SET status='$newStatus' WHERE reserve_id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Record Updated Successfully!');
                window.location.href = 'Admin.php';
            </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete a record from the database when the delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["reserve_id"])) {
    $id = $_POST["reserve_id"]; // The ID of the record to delete

    $sql = "DELETE FROM reservation WHERE reserve_id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch the records from the reservation table
$sql = "SELECT reserve_id, name, contactNumber, email, address, equipment, pickupDate, returnDate, startTime, endTime, status FROM reservation";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sports A-Blaze</title>
    <link rel="stylesheet" href="styles_main.css">
    <style>
.actions {
    display: flex;
    gap: 10px;
}
            
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 30px;
    border-radius: 20px;
    border: 1px solid #888;
    width: 40%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.modal h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
    color: #333;
}

.modal form {
    display: flex;
    flex-direction: column;
}

.modal label {
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.modal input[type="text"],
.modal input[type="number"],
.modal input[type="file"],
.modal input[type="hidden"],
.modal input[type="checkbox"] {
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 100%;
}

.modal .checkbox-container {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.modal input[type="checkbox"] {
    width: 30px;
    height: 20px;
    margin-left: 10px;
    margin-top: 20px;
}

.modal img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

.modal button[type="submit"] {
    background-color: #146418;
    color: white;
    padding: 14px;
    margin-top: 20px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 18px;
    align-self: center;
    width: 100%;
    max-width: 520px;
    transition: background-color 0.3s ease, transform 0.4s ease;
}

.modal button[type="submit"]:hover {
    background-color: #45a049;
}

        .addbutton {
        background-color: #146418; 
        border: none; 
        color: white; 
        padding: 10px 15px;
        text-align: center;
        text-decoration: none; 
        display: inline-block; 
        font-size: 16px; 
        margin: 4px 2px; 
        cursor: pointer; 
        border-radius: 40px; 
        transition: background-color 0.3s ease, transform 0.4s ease; 
        width: 180px;
        margin-bottom: 20px;
    }

    .addbutton:hover {
        background-color: #45a049; 
        transform: scale(1.05); 
    }

    .editBtn, .deleteBtn {
            border: none; 
            color: white; 
            padding: 8px 16px;
            text-align: center; 
            text-decoration: none;
            display: inline-block; 
            font-size: 14px; 
            margin: 4px 2px; 
            cursor: pointer; 
            border-radius: 20px; 
            transition: background-color 0.3s ease, transform 0.3s ease; 
        }

        .editBtn {
            background-color: #569646; /* Green background */
        }

        .editBtn:hover {
            background-color: #45a049; 
            transform: scale(1.05); 
        }

        .deleteBtn {
            background-color: #ae1919; 
        }

        .deleteBtn:hover {
            background-color: #e53935; 
            transform: scale(1.05);
        }

        .status-cell {
    text-align: center;
}

.status-select {
    padding: 10px 15px; 
    border-radius: 10px; 
    font-size: 16px; 
    font-weight: bold;
    background-color: #fafafa; 
    color: #333; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    appearance: none; 
    cursor: pointer; 
    transition: background-color 0.3s ease, box-shadow 0.3s ease; 
    border: none;
}

.status-select:hover,
.status-select:focus {
    background-color: #fafafa; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); 
}


.status-select option {
    color: #fff; 
}

.status-select option[value='On-going'] {
    background-color: #a46900; 
}

.status-select option[value='Completed'] {
    background-color: #1a5c0a; 
}

.status-select option[value='Cancelled'] {
    background-color: #880000; 
}

.delete-button {
    background-color: #ae1919; 
    color: white; 
    padding: 10px 25px; 
    text-align: center; 
    text-decoration: none; 
    display: inline-block; 
    font-size: 14px; 
    margin: 5px; 
    cursor: pointer;
    border-radius: 20px; 
    border: none; 
    transition: background-color 0.3s ease, transform 0.2s ease; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    
}

.delete-button:hover {
    background-color: #d32f2f; 
    transform: scale(1.05); 
}

.delete-button:active {
    background-color: #b71c1c; 
    transform: scale(0.95); 
}

.report-buttons {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            justify-content: center;
            
        }

        .report-buttons button {
            padding: 10px 30px;
            border: none;
            border-radius: 30px;
            background-color: #6f3213; /* Darker green background */
            color: white; /* White text */
            font-size: 16px; /* Font size */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s ease; /* Smooth transition */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Light shadow */
            
        }

        .report-buttons button:hover {
            background-color: #7D462A; /* Even darker green on hover */
        }

        .report-buttons button:active {
            background-color: #1B5E20; /* Darkest green on click */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2); /* Smaller shadow */
            transform: translateY(2px); /* Slight downward movement */
        }



    </style>
</head>
<body>
    
    <!--SIDEBAR-->
    <div class="container">
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
                <a href="#dashboard" onclick="showPanel('dashboardPanel')">
                    <span class="icon">
                        <ion-icon name="home"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
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
                <a href="#equipment" onclick="showPanel('equipmentPanel')">
                    <span class="icon">
                        <ion-icon name="basket-sharp"></ion-icon>
                    </span>
                    <span class="title">Equipment</span>
                </a>
            </li>
            <li>
                <a href="#accounts" onclick="showPanel('accountsPanel')">
                    <span class="icon">
                    <ion-icon name="people-circle"></ion-icon>
                    </span>
                    <span class="title">Accounts</span>
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


    <!--========== MAIN ========= -->
    <div class="main">
        <div class="topbar">
            <div class="toggle" onclick="toggleSidebar()">
                <ion-icon name="menu"></ion-icon>
            </div>
        </div>
    <!---->

    
    <!-- DITO KAYO MAGSTART MAGLAGAY NG DIV-->
        <!-- Panels -->
        <?php include 'fetch_dashboard_data.php'; ?>
        <div id="dashboardPanel" class="panel active">
        <div>
            <h3 style="color: #033a18;">Welcome, <?php echo $_SESSION["name"]; ?>!</h3>
        </div>
        <br>
        <h3>Dashboard</h3><br>
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $totalReservations; ?></div>
                    <div class="cardName">Total Reservations</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="receipt"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $equipmentReservations;?></div>
                    <div class="cardName">Equipment Reservations</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="basketball"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $courtReservations;?></div>
                    <div class="cardName">Court Reservations</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="golf"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $totalAccounts;?></div>
                    <div class="cardName">Total Accounts</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="people"></ion-icon>
                </div>
            </div>
        </div> <!--END div cardBox-->
        <br><br>
        <h3>Latest Reservations</h3><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="background-color:#1a5c0a; border-color: #1a5c0a;">Reserve ID</th>
                    <th style="background-color: #4F7942 ; border-color: #4F7942 ;">Name</th>
                    <th style="background-color:#1a5c0a; border-color: #1a5c0a;">Contact Number</th>
                    <th style="background-color:#4F7942 ; border-color: #4F7942 ;">Email</th>
                    <th style="background-color:#1a5c0a; border-color: #1a5c0a;">Equipment</th>
                    <th style="background-color:#4F7942 ; border-color: #4F7942 ;">Pickup Date</th>
                    <th style="background-color:#1a5c0a; border-color: #1a5c0a;">Return Date</th>
                    <th style="background-color:#4F7942 ; border-color: #4F7942 ;">Start Time</th>
                    <th style="background-color:#1a5c0a; border-color: #1a5c0a;">End Time</th>
                </tr>

            </thead>
            <tbody>
                <?php foreach ($latestReservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['reserve_id']; ?></td>
                        <td><?php echo $reservation['name']; ?></td>
                        <td><?php echo $reservation['contactNumber']; ?></td>
                        <td><?php echo $reservation['email']; ?></td>
                        <td><?php echo $reservation['equipment']; ?></td>
                        <td><?php echo $reservation['pickupDate']; ?></td>
                        <td><?php echo $reservation['returnDate']; ?></td>
                        <td><?php echo date("g:i A", strtotime($reservation['startTime'])); ?></td>
                        <td><?php echo date("g:i A", strtotime($reservation['endTime'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br><br>

        <div class="report-buttons">    
            <form action="generate_daily_report.php" method="POST">
                <button type="submit">Generate Daily Report</button>
            </form>
            <form action="monthly_report.php" method="GET">
                <button type="submit">Generate Monthly Report</button>
            </form>
        </div>
    </div> <!--END div dashboardPanel-->


        <div id="reservationsPanel" class="panel">
            <h3 style="margin-bottom: 20px;">Reservations</h3>

            <div class="table-filter">
            <input type="text" id="table-search" class="form-control" placeholder="Search">
            </div>

            <table id="myTable" class="table table-striped custom-table">
            <thead>
                        <tr>
                            <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">ID</th>
                            <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">Name</th>
                            <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Contact Number</th>
                            <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">Email</th>
                            <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Address</th>
                            <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">Equipment</th>
                            <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Pickup Date</th>
                            <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">Return Date</th>
                            <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Start Time</th>
                            <th style="background-color:#7D462A; border-color: #7D462A; font-size: 14px;">End Time</th>
                            <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Status</th>
                            
                        </tr>
            </thead>
                <tbody >
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["reserve_id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["contactNumber"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["address"] . "</td>";
                            echo "<td>" . $row["equipment"] . "</td>";
                            echo "<td>" . $row["pickupDate"] . "</td>";
                            echo "<td>" . $row["returnDate"] . "</td>";
                            echo "<td>" . date("g:i A", strtotime($row["startTime"])) . "</td>";
                            echo "<td>" . date("g:i A", strtotime($row["endTime"])) . "</td>";
                            echo "<td class='status-cell'>";
                                echo "<form method='POST'>";
                                echo "<input type='hidden' name='reserve_id' value='" . $row["reserve_id"] . "'>";
                                echo "<select name='status' onchange='this.form.submit()' class='status-select'>";
                                echo "<option value='On-going'" . ($row["status"] == "On-going" ? " selected" : "") . ">On-going</option>";
                                echo "<option value='Completed'" . ($row["status"] == "Completed" ? " selected" : "") . ">Completed</option>";
                                echo "<option value='Cancelled'" . ($row["status"] == "Cancelled" ? " selected" : "") . ">Cancelled</option>";
                                echo "</select>";
                                echo "</form>";
                                echo "</td>";
                                
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
                    </table>
        </div> 
        <!--END div reservationPanel-->

        <div id="equipmentPanel" class="panel">
            <h3 style="margin-bottom: 10px;">Equipment</h3>
            <!--search-->
            

            <button id="addBtn" class="addbutton"><ion-icon name="add-circle" style="width:26px;"></ion-icon> Add New</button>
            <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Stocks</th>
                <th>Availability</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="equipmentTable">
            <?php
            $conn = new mysqli("localhost", "root", "", "sports_a_blaze");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, name, image_src, stocks, availability, category FROM equipment_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td><img src='" . $row["image_src"] . "' alt='Image' width='50'></td>";
                    echo "<td>" . $row["stocks"] . "</td>";
                    echo "<td>" . ($row["availability"] ? "Yes" : "No") . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td class='actions'><button class='editBtn' data-id='" . $row["id"] . "'>Edit</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>



        
<!-- Add/Edit Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle">Add New Equipment</h2>
        <form id="modalForm" method="post" action="">
            <input type="hidden" id="id" name="id">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            
            <label for="image_src">Attach Image</label>
            <input type="file" id="image_src" name="image_src">
            <input type="hidden" id="currentImageSrc" name="currentImageSrc">
            
            
            <label for="stocks">Stocks</label>
            <input type="number" id="stocks" name="stocks" min="0" required>
            
            <div class="checkbox-container">
                <label for="availability">Availability</label>
                <input type="checkbox" id="availability" name="availability">
            </div>
            
            <label for="category">Category</label>
            <input type="text" id="category" name="category" required>
            
            <button type="submit" id="modalSubmit">Submit</button>
        </form>
    </div>
</div>


    </div> <!--END div equipmentPanel-->
        

    <div id="accountsPanel" class="panel">
    <h3 style="margin-bottom: 20px;">List of Accounts</h3>

    
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">ID</th>
                <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Name</th>
                <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Email</th>
                <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Contact Number</th>
                <th style="background-color:#6f3213; border-color: #6f3213; font-size: 14px;">Address</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $conn = new mysqli("localhost", "root", "", "sports_a_blaze");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch user accounts
            $sql = "SELECT id, name, email, contactNumber, address FROM users";
            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['contactNumber']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No accounts found.</td></tr>';
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>


        <!--HANGGANG DITO LANG-->


    </div> <!--END div main-->
    </div> <!--END div container-->
<!--
    <script>
        function filterTable(tableId, searchInputId, columns) {
            document.getElementById(searchInputId).addEventListener('input', function() {
                var searchValue = this.value.toLowerCase();
                var table = document.getElementById(tableId);
                var rows = table.getElementsByTagName('tr');

                for (var i = 1; i < rows.length; i++) {
                    var cells = rows[i].getElementsByTagName('td');
                    var found = false;

                    for (var j = 0; j < columns.length; j++) {
                        if (cells[columns[j]]) {
                            if (cells[columns[j]].innerText.toLowerCase().includes(searchValue)) {
                                found = true;
                                break;
                            }
                        }
                    }

                    if (found) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        }

        // Apply filter to each table
        filterTable('accountsTable', 'accounts-search', [0, 1, 2, 3, 4]);
        filterTable('equipmentTable', 'equipment-search', [0, 1, 5]);
    </script> -->

    <!--JAVASCRIPT-->
    <script src="main.js"></script>

    <script>
    function confirmLogout() {
        var confirmed = window.confirm("Are you sure you want to logout?");
        if (confirmed) {
            // Perform logout action here (e.g., redirect to logout script)
            window.location.href = "landingpage.php"; // Replace with your logout script URL
        } else {
            
        }
    }
</script>
<script>
    // Get modal elements
        var modal = document.getElementById("modal");
        var modalForm = document.getElementById("modalForm");
        var modalTitle = document.getElementById("modalTitle");
        var modalSubmit = document.getElementById("modalSubmit");
        var addBtn = document.getElementById("addBtn");
        var closeBtn = document.getElementsByClassName("close")[0];

        // Open modal for adding new equipment
        addBtn.onclick = function() {
            modal.style.display = "block";
            modalTitle.innerText = "Add New Equipment";
            modalSubmit.innerText = "Submit";
            modalForm.action = "insert.php";
            document.getElementById("id").value = "";
            document.getElementById("name").value = "";
            document.getElementById("image_src").value = "";
            document.getElementById("stocks").value = "";
            document.getElementById("availability").checked = false;
            document.getElementById("category").value = "";
        }

        // Close modal
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Close modal if clicked outside of modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    // Open modal for editing equipment
document.querySelectorAll(".editBtn").forEach(function(editBtn) {
    editBtn.onclick = function() {
        var id = this.getAttribute("data-id");
        fetch("get_equipment.php?id=" + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);  // Log fetched data
                if (Object.keys(data).length > 0) {
                    // Open the modal
                    var modal = document.getElementById("modal");
                    var modalTitle = document.getElementById("modalTitle");
                    var modalSubmit = document.getElementById("modalSubmit");
                    var modalForm = document.getElementById("modalForm");

                    modal.style.display = "block";
                    modalTitle.innerText = "Edit Equipment";
                    modalSubmit.innerText = "Update";
                    modalForm.action = "update.php";

                    // Populate the form with fetched data
                    document.getElementById("id").value = data.id;
                    document.getElementById("name").value = data.name;
                    document.getElementById("stocks").value = data.stocks;
                    document.getElementById("availability").checked = data.availability;
                    document.getElementById("category").value = data.category;

                    document.getElementById("currentImageSrc").value = data.image_src;

                    console.log("Form values set successfully");
                } else {
                    console.error("Error: No data found for id " + id);
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    }
});
        // Handle delete
        document.querySelectorAll(".deleteBtn").forEach(function(deleteBtn) {
            deleteBtn.onclick = function() {
                var id = this.getAttribute("data-id");
                if (confirm("Are you sure you want to delete this record?")) {
                    fetch("delete.php?id=" + id)
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            location.reload();
                        })
                        .catch(error => console.error("Error:", error));
                }
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
    const statusSelects = document.querySelectorAll(".status-select");

    statusSelects.forEach(select => {
        updateSelectColor(select);

        select.addEventListener("change", function() {
            updateSelectColor(select);
        });
    });

    function updateSelectColor(select) {
        const selectedOption = select.options[select.selectedIndex];
        select.style.color = getOptionColor(selectedOption.value);
    }

    function getOptionColor(value) {
        switch (value) {
            case 'On-going':
                return '#a46900'; /* Orange */
            case 'Completed':
                return '#1a5c0a'; /* Green */
            case 'Cancelled':
                return '#880000'; /* Red */
            default:
                return '#333'; /* Default text color */
        }
    }
});


//serach filter
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("table-search").addEventListener("keyup", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("table-search");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                // Columns to search: ID (index 0), Name (index 1), Contact Number (index 2), Email (index 3), Address (index 4), Equipment (index 5), Status (index 10)
                td_id = tr[i].getElementsByTagName("td")[0];
                td_name = tr[i].getElementsByTagName("td")[1];
                td_contact = tr[i].getElementsByTagName("td")[2];
                td_email = tr[i].getElementsByTagName("td")[3];
                td_address = tr[i].getElementsByTagName("td")[4];
                td_equipment = tr[i].getElementsByTagName("td")[5];
                td_status = tr[i].getElementsByTagName("td")[10];

                if (td_id || td_name || td_contact || td_email || td_address || td_equipment || td_status) {
                    txtValue_id = td_id.textContent || td_id.innerText;
                    txtValue_name = td_name.textContent || td_name.innerText;
                    txtValue_contact = td_contact.textContent || td_contact.innerText;
                    txtValue_email = td_email.textContent || td_email.innerText;
                    txtValue_address = td_address.textContent || td_address.innerText;
                    txtValue_equipment = td_equipment.textContent || td_equipment.innerText;
                    txtValue_status = td_status.textContent || td_status.innerText;

                    if (txtValue_id.toUpperCase().indexOf(filter) > -1 || 
                        txtValue_name.toUpperCase().indexOf(filter) > -1 ||
                        txtValue_contact.toUpperCase().indexOf(filter) > -1 ||
                        txtValue_email.toUpperCase().indexOf(filter) > -1 ||
                        txtValue_address.toUpperCase().indexOf(filter) > -1 ||
                        txtValue_equipment.toUpperCase().indexOf(filter) > -1 ||
                        txtValue_status.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    });



    </script>

    <!--IONICONS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
