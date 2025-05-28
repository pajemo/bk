<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pajemo Bank</title>
    <link rel="stylesheet" href="style_theme_update.css">
</head>
<body id="login-page">
<?php
require 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {
        // Check if user exists and email verified
        $stmt = $conn->prepare("SELECT UserID, IsEmailVerified FROM Users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            $message = "Email not registered.";
        } elseif (!$row['IsEmailVerified']) {
            $message = "Email not verified. Please verify your email first.";
        } else {
            $userID = $row['UserID'];
            // Generate login code
            $code = generateCode(6);
            $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Insert login code
            $stmt2 = $conn->prepare("INSERT INTO LoginCodes (UserID, Code, Expiry) VALUES (?, ?, ?)");
            $stmt2->bind_param("iss", $userID, $code, $expiry);
            $stmt2->execute();

            // Send login code email
            $subject = "Your login code";
            $body = "Your login code is: <b>$code</b>. It expires in 10 minutes.";

            if (sendEmail($email, $subject, $body)) {
                $_SESSION['login_user_id'] = $userID;
                header("Location: verify_login_code.php");
                exit();
            } else {
                $message = "Failed to send login code email.";
            }
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="content">
    <h1>Login</h1>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="6" >
        <button type="button" id="togglePassword">Show</button>
        <input type="submit" value="Send Login Code">
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</div>

<script>
    function togglePassword() {
        var pwd = document.getElementById("password");
        var btn = event.target;
        if (pwd.type === "password") {
            pwd.type = "text";
            btn.textContent = "Hide";
        } else {
            pwd.type = "password";
            btn.textContent = "Show";
        }
    }
</script>
<?php include 'footer.php'; ?>
<script src="login.js"></script>
