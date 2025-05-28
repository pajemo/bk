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
        // Fetch account ID
        $stmt = $conn->prepare("SELECT AccountID FROM Accounts WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $accountID = $row['AccountID'];

        // Update balance
        $stmt = $conn->prepare("UPDATE Accounts SET Balance = Balance + ? WHERE AccountID = ?");
        $stmt->bind_param("di", $amount, $accountID);
        $stmt->execute();

        // Insert transaction
        $stmt = $conn->prepare("INSERT INTO Transactions (AccountID, TransactionType, Amount, TransactionDate) VALUES (?, 'Deposit', ?, NOW())");
        $stmt->bind_param("id", $accountID, $amount);
        $stmt->execute();

        $message = "Deposit successful.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deposit - Bank Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Make a Deposit</h2>
    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="deposit.php">
        <label>Amount:</label><br>
        <input type="number" step="0.01" name="amount" required><br><br>
        <input type="submit" value="Deposit">
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
<?php include 'footer.php'; ?>
</body>
</html>
