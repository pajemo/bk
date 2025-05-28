<?php
// config.php - Database connection and email configuration

// MySQL database connection settings
$servername = "localhost"; // Change if needed
$username = "root";
$password = "";
$dbname = "bankdb";

// Create connection
$conn = new mysqli('localhost', 'root', '', 'bankdb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure PHPMailer is installed via Composer

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nellycreel@gmail.com'; // Your Gmail address
        $mail->Password   = 'jzmapoetkcdbejxy'; // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('nellycreel@gmail.com', 'localhost');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Function to generate random code
function generateCode($length = 6) {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

// Start session for user authentication
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
