<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\ExceptionPHP;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';



    // PHPMailer configuration
    $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                        // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'sportsblaze.tester@gmail.com';          // SMTP username
        $mail->Password   = 'gqgpojfeqffaxmge';                      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        // Enable SMTP debugging
        //  $mail->SMTPDebug = 2; // Enable verbose debug output

        // Content
        $mail->isHTML(true);     
        return $mail;                                   
?>
