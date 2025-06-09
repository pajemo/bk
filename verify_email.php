<?php
require 'config.php';

$message = '';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Check verification code (correct column names)
    $stmt = $conn->prepare("
SELECT ev.VerificationID, ev.user_id, ev.Expiry, ev.IsUsed, u.email_verified_at
FROM emailverifications ev
JOIN users u ON ev.user_id = u.id
WHERE ev.VerificationCode = ?
    ");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        if ($row['IsUsed']) {
            $message = "This verification link has already been used.";
        } elseif ($row['IsEmailVerified']) {
            $message = "Your email is already verified.";
        } elseif (strtotime($row['Expiry']) < time()) {
            $message = "This verification link has expired. <a href='resend_verification.php'>Click here to request a new verification code</a>.";
        } else {
            // Mark user as verified
$stmt2 = $conn->prepare("UPDATE users SET email_verified_at = NOW() WHERE id = ?");
$stmt2->bind_param("i", $row['user_id']);
            $stmt2->execute();

            // Mark code as used
            $stmt3 = $conn->prepare("UPDATE emailverifications SET IsUsed = 1 WHERE VerificationID = ?");
            $stmt3->bind_param("i", $row['VerificationID']);
            $stmt3->execute();

            $message = "Email verified successfully! You can now <a href='login.php'>login</a>.";
        }
    } else {
        $message = "Invalid verification code.";
    }
} else {
    $message = "No verification code provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification - Pajemo Bank</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Email Verification</h2>
    <p><?php echo $message; ?></p>
    <?php include 'footer.php'; ?>
</body>
</html>
