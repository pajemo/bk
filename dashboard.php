<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Fetch user account and balance
$stmt = $conn->prepare("SELECT AccountID, Balance FROM Accounts WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    // Create new account with zero balance
    $stmtCreate = $conn->prepare("INSERT INTO Accounts (UserID, Balance) VALUES (?, 0)");
    $stmtCreate->bind_param("i", $userID);
    $stmtCreate->execute();

    // Fetch the newly created account
    $stmt = $conn->prepare("SELECT AccountID, Balance FROM Accounts WHERE UserID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

$accountID = $row['AccountID'];
$balance = $row['Balance'];

// Fetch recent transactions
$stmt = $conn->prepare("SELECT TransactionType, Amount, TransactionDate FROM Transactions WHERE AccountID = ? ORDER BY TransactionDate DESC");
$stmt->bind_param("i", $accountID);
$stmt->execute();
$result = $stmt->get_result();
$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Bank Website</title>
    <link rel="stylesheet" href="style_theme_update.css">
</head>
<body>
<?php include 'header.php'; ?>
    <h2>Dashboard</h2>
    <p>Welcome, User #<?php echo htmlspecialchars($userID); ?></p>
    <p>Account Balance: $<?php echo number_format($balance, 2); ?></p>
    <h3>Recent Transactions</h3>
    <table>
        <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php foreach ($transactions as $tx): ?>
        <tr>
            <td><?php echo htmlspecialchars($tx['TransactionType']); ?></td>
            <td>$<?php echo number_format($tx['Amount'], 2); ?></td>
            <td><?php echo htmlspecialchars($tx['TransactionDate']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="deposit.php">Make a Deposit</a> | <a href="withdrawal.php">Make a Withdrawal</a> | <a href="transfer.php">Transfer Funds</a> | <a href="logout.php">Logout</a></p>
<?php include 'footer.php'; ?>
</body>
</html>
