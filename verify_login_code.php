<?php
require 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resend'])) {
    // Resend login code
    if (!isset($_SESSION['login_user_id'])) {
        $message = "Session expired. Please login again.";
    } else {
        $userID = $_SESSION['login_user_id'];
        // Generate new login code
        $code = generateCode(6);
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Insert new login code
        $stmt = $conn->prepare("INSERT INTO LoginCodes (UserID, Code, Expiry) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userID, $code, $expiry);
        $stmt->execute();

        // Get user email
        $stmt2 = $conn->prepare("SELECT Email FROM Users WHERE UserID = ?");
        $stmt2->bind_param("i", $userID);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $row2 = $result->fetch_assoc();

        if ($row2) {
            $email = $row2['Email'];
            $subject = "Your new login code";
            $body = "Your new login code is: <b>$code</b>. It expires in 10 minutes.";
            if (sendEmail($email, $subject, $body)) {
                $message = "New login code sent to your email.";
            } else {
                $message = "Failed to send new login code email.";
            }
        } else {
            $message = "User email not found.";
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['code']);

    if (empty($code)) {
        $message = "Please enter the login code.";
    } else {
        // Check login code
        $stmt = $conn->prepare("SELECT LoginCodeID, UserID, Expiry, IsUsed FROM LoginCodes WHERE Code = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            $message = "Invalid login code.";
        } elseif ($row['IsUsed']) {
            $message = "This login code has already been used.";
        } elseif (strtotime($row['Expiry']) < time()) {
            $message = "This login code has expired.";
        } else {
            // Mark code as used
            $stmt2 = $conn->prepare("UPDATE LoginCodes SET IsUsed = 1 WHERE LoginCodeID = ?");
            $stmt2->bind_param("i", $row['LoginCodeID']);
            $stmt2->execute();

            // Set session and redirect to dashboard
            $_SESSION['user_id'] = $row['UserID'];
            unset($_SESSION['login_user_id']);
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Login Code - Bank Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Verify Login Code</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="verify_login_code.php">
        <label>Login Code:</label><br>
        <input type="text" name="code" required><br><br>
        <input type="submit" value="Verify">
    </form>
    <form method="post" action="verify_login_code.php" style="margin-top: 10px; display: inline-block; margin-right: 10px;">
        <input type="hidden" name="resend" value="1">
        <input type="submit" value="Resend Code">
    </form>
    <form method="get" action="login.php" style="margin-top: 10px; display: inline-block; margin-right: 10px;">
        <input type="submit" value="Login">
    </form>
    <form method="get" action="register.php" style="margin-top: 10px; display: inline-block;">
        <input type="submit" value="Register">
    </form>
<?php include 'footer.php'; ?>
</body>
</html>
