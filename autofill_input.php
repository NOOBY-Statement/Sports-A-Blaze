<?php
            // Start session and include database connection
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