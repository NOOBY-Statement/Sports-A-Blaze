<?php
// Token generation and storage example
$email = $_POST["email"];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);


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

$sql = "UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$token_hash, $expiry, $email]);

if ($stmt->rowCount() == 0) {
    die("Email not found or token not stored");
}

// Sending the reset email
$mail = require __DIR__ . "/mailer.php";
$mail->setFrom("noreply@example.com");
$mail->addAddress($email);
$mail->Subject = "Password Reset";
$mail->Body = "Click <a href='localhost/SPORTS-A-BLAZE/reset-password.php?token=$token'>here</a> to reset your password.";

try {
    $mail->send();
    echo '<script>alert("Password reset instructions sent to your email."); window.location.href = "forgot_pass.php";</script>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
}

?>



