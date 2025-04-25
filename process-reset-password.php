<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["token"])) {
        die('<script>alert("Token not found."); window.location.href = "reset-password.php";</script>');
    }

    $token = $_POST["token"];
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
    

    $sql = "SELECT * FROM users WHERE reset_token_hash = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token_hash]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //if ($user === false) {
    //    die('<script>alert("Token not found."); window.location.href = "reset-password.php";</script>');
    //}

    //if (strtotime($user["reset_token_expires_at"]) <= time()) {
    //    die('<script>alert("Token has expired."); window.location.href = "reset-password.php";</script>');
    //}

   // if (strlen($_POST["pword"]) < 8) {
        //die('<script>alert("Password must be at least 8 characters."); window.location.href = "reset-password.php";</script>');
   // }

    //if (!preg_match("/[a-z]/i", $_POST["pword"])) {
       // die('<script>alert("Password must contain at least one letter."); window.location.href = "reset-password.php";</script>');
    //}

    //if (!preg_match("/[0-9]/", $_POST["pword"])) {
       // die('<script>alert("Password must contain at least one number."); window.location.href = "reset-password.php";</script>');
    //}

    if ($_POST["pword"] !== $_POST["confirm_pword"]) {
        die('<script>alert("Passwords must match."); window.location.href = "reset-password.php";</script>');
    }

    $password_hash = password_hash($_POST["pword"], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$password_hash, $user["id"]]);

    if ($stmt->rowCount() === 0) {
        die('<script>alert("Failed to update password."); window.location.href = "reset-password.php";</script>');
    }

    echo '<script>alert("Password updated. You can now login."); window.location.href = "login.php";</script>';
} else {
    die('<script>alert("Invalid request method."); window.location.href = "reset-password.php";</script>');
}
?>
