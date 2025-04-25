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
<form action="send-password-reset.php" method="POST">
    <div style="font-size: 27px; font-weight: 500;">
    <ion-icon name="key" style="height: 27px; width: 27px; margin-top: 20px;"></ion-icon>
        Recover Password
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
  <label for="email" class="form-label"></label>
  <div class="input-container">
    <ion-icon name="person-circle"></ion-icon>
    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
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