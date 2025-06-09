<?php
require 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {
        // Check if user exists and email not verified
        $stmt = $conn->prepare("SELECT id, IsEmailVerified FROM users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            $message = "Email not registered.";
        } elseif ($row['IsEmailVerified']) {
            $message = "Email is already verified. You can login.";
        } else {
            // Generate new verification code
            $code = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

            // Insert new verification code
$stmt2 = $conn->prepare("INSERT INTO emailverifications (user_id, VerificationCode, Expiry, IsUsed, created_at, updated_at) VALUES (?, ?, ?, 0, NOW(), NOW())");
$stmt2->bind_param("iss", $row['id'], $code, $expiry);
            if ($stmt2->execute()) {
                // Simulate sending email
                $subject = "Your new email verification code";
                $body = "Your new verification code is: <b>$code</b>. It expires in 24 hours.";

                // You can replace this with actual email sending function
                if (sendEmail($email, $subject, $body)) {
                    $message = "A new verification code has been sent to your email.";
                } else {
                    $message = "Failed to send verification email. Please try again later.";
                }
            } else {
                $message = "Failed to generate verification code. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resend Verification Code - Pajemo Bank</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="content">
    <h1>Resend Verification Code</h1>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="resend_verification.php">
        <label for="email">Enter your email address:</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Resend Code">
    </form>
    <p><a href="login.php">Back to Login</a></p>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
