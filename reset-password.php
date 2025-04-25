<?php

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$host = 'localhost';
$db = 'sports_a_blaze';
$user = 'root';
$pass = ''; // Update your database password here

// PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set PDO attributes as needed (optional)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
// var_dump($token);
// var_dump($token_hash);

$sql = "SELECT * FROM users WHERE reset_token_hash = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$token_hash]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link rel="stylesheet" href="style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    
    
</head>
<body>
<div>
<div class="form-container">
  <button type="button" class="close-button" aria-label="Close" onclick="window.location.href='landingpage.php';" style="position: absolute; top: 10px; right: 30px; background: none; border: none; font-size: 40px; color: white;">
    <span aria-hidden="true">&times;</span>
  </button>
<form action="process-reset-password.php" method="POST">
    <div style="font-size: 27px; font-weight: 500;">
    <ion-icon name="key" style="height: 27px; width: 27px; margin-top: 20px;"></ion-icon>
        Reset Password
    </div>

    <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']); // Clear the error after displaying it
                ?>
            </div>
    <?php endif; ?>

    <div class="mb-3">
  <label for="text" class="form-label"></label>
  <div class="input-container">
    <ion-icon name="person-circle"></ion-icon>
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
    <input type="text" name="pword" class="form-control" id="pword" placeholder="Input New Password" required>
  </div>
</div>

<div class="mb-3">
  <label for="text" class="form-label"></label>
  <div class="input-container">
    <ion-icon name="person-circle"></ion-icon>
    <input type="text" name="confirm_pword" class="form-control" id="confirm-pword" placeholder="Re-enter New Password" required>
  </div>
</div>



<!-- <div class="mb-3">
  <label for="password" class="form-label"></label>
  <div class="input-container">
    <ion-icon name="lock-closed"></ion-icon>
    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
  </div>
</div>

<div class="col-12">
  <p class="text-left"> 
    <a href="forgot_pass.php" style="text-decoration:none; color: #007bff; font-size: 15px;">Forgot Password?</a>
  </p>
</div> -->

<button type="submit" name="login" class="btn-custom">Submit</button>
<!-- 
<div class="col-12 login-link">
  <p class="text-center mt-3">Don't have an account yet? 
    <a href="signup.php" style="text-decoration:none;">Register</a>
  </p> -->

</div>

</form>
</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>