<?php
include('conn.php');

if(isset($_POST['submit'])) {
    if(isset($_POST['name'], $_POST['contactNumber'], $_POST['address'], $_POST['email'], $_POST['password'])) {
        $name = $_POST["name"];
        $contactNumber = $_POST["contactNumber"];
        $address = $_POST["address"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $verify_query = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $verify_query->bind_param("s", $email);
        $verify_query->execute();
        $result = $verify_query->get_result();

        if($result->num_rows > 0) {
            $_SESSION['error'] = "This email is already used, try another one please!";
        
        } else {
            $insertQuery = $conn->prepare("INSERT INTO users (name, email, contactNumber, address, password) VALUES (?, ?, ?, ?, ?)");
            $insertQuery->bind_param("sssss", $name, $email, $contactNumber, $address, $hashed_password);

            if($insertQuery->execute() === TRUE) {
                echo '<script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            var successModal = new bootstrap.Modal(document.getElementById("successModal"));
                            successModal.show();
                        });
                    </script>';
            } else {
                $_SESSION['error'] = "Error: " . $conn->error;
            }

            $insertQuery->close();
        }

        $verify_query->close();
    } else {
        $_SESSION['error'] = "All fields are required.";
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Signup</title>
    <link rel="stylesheet" href="style_signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="form-container">
    <button type="button" class="close-button" aria-label="Close" onclick="window.location.href='landingpage.php';" style="position: absolute; top: 10px; right: 30px; background: none; border: none; font-size: 40px; color: white;">
        <span aria-hidden="true">&times;</span>
    </button>

    <div>
    <h2 class="text-center mb-3">Create an Account</h2>
    </div>
    <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']); // Clear the error after displaying it
                ?>
            </div>
        <?php endif; ?>

    <form class="row g-2" action="#" method="POST" onsubmit="return validateForm()">
        <div class="col-md-12">
            <label for="inputName" class="form-label"></label>
            <input type="text" name="name" class="form-control" id="inputName" placeholder="Enter your name" aria-label="Name" style="border-radius:15px; height: 45px;" required>
        </div>
        <div class="col-md-12">
            <label for="inputEmail" class="form-label"></label>
            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter your email" aria-label="Email" style="border-radius:15px; height: 45px;" required>
        </div>
        <div class="col-6">
            <label for="inputContactNumber" class="form-label"></label>
            <input type="tel" name="contactNumber" class="form-control" id="inputContactNumber" placeholder="Contact Number" style="border-radius:15px; height: 45px;" required>
        </div>
        <div class="col-6">
            <label for="inputAddress" class="form-label"></label>
            <input type="text" name="address" class="form-control" id="inputAddress" placeholder="Enter your address" style="border-radius:15px; height: 45px;" required>
        </div>
        <div class="col-md-6">
            <label for="inputPassword" class="form-label"></label>
            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Enter password" style="border-radius:15px; height: 45px;" required>
        </div>
        <div class="col-md-6">
            <label for="inputConfirmPassword" class="form-label"></label>
            <input type="password" class="form-control" class="input-error" id="inputConfirmPassword" placeholder="Confirm password" style="border-radius:15px; height: 45px;" required>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="termsCheck" required>
                <label class="form-check-label" for="termsCheck">
                    I agree to the <a href="#" onclick="showTermsModal()" style="text-decoration:none;">Terms and Conditions</a>
                </label>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" name="submit" class="btn-primary">Register</button>
        </div>
        <div class="col-12 login-link">
            <p class="text-center mt-2">Already have an account? <a href="login.php" style="text-decoration:none;">Login</a></p>
        </div>
    </form>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Registration Successful!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Your registration was successful.</p>
        <a href="login.php" class="btn btn-primary btn-block">Login</a>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap modal for Terms and Conditions -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Terms and Conditions content -->
                <p>Terms and Conditions for Borrowing Court and Sports Equipment</p>
                <ul>
                    <li>Use of Equipment: The equipment provided is intended solely for sports and recreational purposes.</li>
                    <li>Responsibility: Borrowers are responsible for the proper use and care of the equipment during the borrowing period.</li>
                    <li>Damage or Loss: Any damage or loss of equipment due to negligence or misuse will result in the borrower being liable for repair or replacement costs.</li>
                    <li>Duration: Equipment must be returned by the agreed-upon date and time. Extensions may be granted upon prior approval, subject to availability.</li>
                    <li>Reservation: Equipment should be reserved in advance to ensure availability.</li>
                    <li>Safety: Borrowers must use the equipment in accordance with safety guidelines and regulations. Proper protective gear should be worn where applicable.</li>
                    <li>Liability: The borrowing party assumes all risks and liabilities associated with the use of the equipment.</li>
                    <li>Cancellation: Borrowers should notify in advance if they need to cancel their reservation to allow others to use the equipment.</li>
                    <li>Acceptance: By borrowing the equipment, the borrower agrees to these terms and conditions.</li>

                    <!-- Add more terms as needed -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var confirmPassword = document.getElementById("inputConfirmPassword");
        var password = document.getElementById("inputPassword");

        confirmPassword.addEventListener("input", function () {
            var confirmValue = confirmPassword.value;
            
            if (password.value !== confirmValue) {
                confirmPassword.setCustomValidity("Passwords do not match.");
                confirmPassword.classList.add("input-error");
            } else {
                confirmPassword.setCustomValidity("");
                confirmPassword.classList.remove("input-error");
            }
        });

        password.addEventListener("input", function () {
            var confirmValue = confirmPassword.value;
            
            if (password.value !== confirmValue) {
                confirmPassword.classList.add("input-error");
            } else {
                confirmPassword.classList.remove("input-error");
            }
        });
    });
    </script>

    <script>
    function validateForm() {
        var checkBox = document.getElementById("termsCheck");
        if (!checkBox.checked) {
            alert("Please agree to the Terms and Conditions.");
            return false;
        }
        return true;
    }

    function showTermsModal() {
        var termsModal = new bootstrap.Modal(document.getElementById('termsModal'));
        termsModal.show();
    }
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</html>