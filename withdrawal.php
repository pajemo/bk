<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = floatval($_POST['amount']);

    if ($amount <= 0) {
        $message = "Please enter a valid amount.";
    } else {
        // Fetch account ID and balance
        $stmt = $conn->prepare("SELECT AccountID, Balance FROM Accounts WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $accountID = $row['AccountID'];
        $balance = $row['Balance'];

        if ($amount > $balance) {
            $message = "Insufficient balance.";
        } else {
            // Update balance
            $stmt = $conn->prepare("UPDATE Accounts SET Balance = Balance - ? WHERE AccountID = ?");
            $stmt->bind_param("di", $amount, $accountID);
            $stmt->execute();

            // Insert transaction
            $stmt = $conn->prepare("INSERT INTO Transactions (AccountID, TransactionType, Amount, TransactionDate) VALUES (?, 'Withdrawal', ?, NOW())");
            $stmt->bind_param("id", $accountID, $amount);
            $stmt->execute();

            $message = "Withdrawal successful.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Withdrawal - Bank Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Make a Withdrawal</h2>
    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="withdrawal.php">
        <label>Amount:</label><br>
        <input type="number" step="0.01" name="amount" required><br><br>
        <input type="submit" value="Withdraw">
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
<?php include 'footer.php'; ?>
</body>
</html>
